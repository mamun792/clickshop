<?php

namespace App\Services\Admin\CouriarApiSetting;

use App\Models\ApiToken;
use App\Models\CourierSetting;
use App\Models\Order;
use App\Repositories\Admin\CouriarApiSetting\CouriarApiSettingRepository;
use Illuminate\Http\Request;
use SteadFast\SteadFastCourierLaravelPackage\Facades\SteadfastCourier;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CouriarApiSettingService implements CouriarApiSettingServiceInterface
{
    protected $courierApiSettingRepository;
    protected $baseUrl;

    public function __construct(CouriarApiSettingRepository $courierApiSettingRepository)
    {
        $this->courierApiSettingRepository = $courierApiSettingRepository;
        $this->baseUrl = 'https://api-hermes.pathao.com';
    }

    public function storeOrUpdate($request)
    {

        return $this->courierApiSettingRepository->storeOrUpdate($request);
    }

    public function get()
    {
        return $this->courierApiSettingRepository->get();
    }

    // stefast courier

    public function prepareOrderData(Order $order): array
    {
        return [
            'order_id' => $order->id,
            'invoice' => $order->invoice_number,
            'recipient_name' => $order->customer_name,
            'recipient_phone' => $order->phone_number,
            'recipient_address' => $order->address,
            'cod_amount' => $order->total_price + $order->delivery_charge,
            'note' => $order->courier_note ?? 'Handle with care',
        ];
    }

    public function sendOrderToCourier(array $orderData): array
    {
        // Call the SteadfastCourier API
        $response = SteadfastCourier::placeOrder($orderData);

        // Check if response is null or doesn't have the expected structure
        if (is_null($response)) {

            return ['status' => 'error', 'message' => 'No response from the courier service.'];
        }

        // Check if the response contains the 'status' key and it's 200
        if (!isset($response['status']) || $response['status'] !== 200) {

            return ['status' => 'error', 'message' => 'Courier API error or unexpected response format.'];
        }

        // Ensure 'order_id' exists in orderData
        if (empty($orderData['order_id'])) {

            return ['status' => 'error', 'message' => 'Order ID is missing in the request.'];
        }

        // Find the order by ID
        $order = Order::find($orderData['order_id']);
        if (!$order) {

            return ['status' => 'error', 'message' => 'Order not found.'];
        }

        // Update the order with consignment data
        $this->updateOrderWithConsignmentData($order, $response);

        return ['status' => 'success', 'message' => 'Order has been successfully sent to the courier.', 'response' => $response];
    }


    private function updateOrderWithConsignmentData(Order $order, array $response)
    {
        $order->update([
            'consignment_id' => $response['consignment']['consignment_id'],
            'tracking_code' => 'https://steadfast.com.bd/t/' . $response['consignment']['tracking_code'],
            'couriar_status' => $response['consignment']['status'],
            'couriar_name' => 'steadfast'
        ]);
    }


    public function generateApiToken(Request $request)
    {
        $validatedData = $this->validateRequest($request);
        $baseUrl = 'https://api-hermes.pathao.com';
        $payload = $this->preparePayload($validatedData);

        try {
            $response = $this->makeApiRequest($baseUrl, $payload);
            return $this->handleApiResponse($response, $validatedData);
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'username' => 'required|email',
            'password' => 'required|string',
            'StoreId' => 'required|Integer',
            'is_enabled'=> 'nullable|in:yes,no',
        ]);
    }

    private function preparePayload(array $validatedData)
    {
        return [
            'client_id' => $validatedData['client_id'],
            'client_secret' => $validatedData['client_secret'],
            'grant_type' => 'password',
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
            'is_enabled' => $validatedData['is_enabled'] ?? 'no',
        ];
    }

    private function makeApiRequest(string $baseUrl, array $payload)
    {
        return Http::withHeaders(['Accept' => 'application/json'])
            ->post("$baseUrl/aladdin/api/v1/issue-token", $payload);
    }

    private function handleApiResponse($response, array $validatedData)
    {
        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['error']) && $data['error']) {

              throw new \Exception($data['error_description']);
            }

            if (isset($data['access_token'])) {

                $api= ApiToken::updateOrCreate(
                    ['id' => 1],
                    [
                        'client_id' => $validatedData['client_id'],
                        'client_secret' => $validatedData['client_secret'],
                        'username' => $validatedData['username'],
                        'password' => $validatedData['password'],
                        'access_token' => $data['access_token'],
                        'refresh_token' => $data['refresh_token'],
                        'StoreId' => $validatedData['StoreId'],
                        'is_enabled' => $validatedData['is_enabled'] ?? 'no',
                        'expires_at' => Carbon::now()->addSeconds($data['expires_in']),
                    ]
                );



                return redirect()->back()->with('success', 'API Token generated successfully.');
            }


            return redirect()->back()->with('error', 'Unexpected API response structure.');
        }


        return redirect()->back()->with('error', 'Failed to communicate with the API.');
    }

    public function getCityList(): array
    {
        $accessToken = $this->courierApiSettingRepository->getAccessToken();

        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'No valid access token found for the user.',
            ];
        }

        $endpoint = 'aladdin/api/v1/city-list';
        $response = $this->fetchCityList($endpoint, $this->headers($accessToken));

        if (is_array($response)) {
            return $response;
        }

        // Handle unexpected response types
        return [
            'success' => false,
            'message' => 'Unexpected API response format.',
        ];
    }

    protected function headers(string $accessToken = ''): array
    {

        return [


            'Authorization' => "Bearer $accessToken",

            'Content-Type'  => 'application/json; charset=UTF-8',
        ];
    }


    public function getZones($id)
    {
        $accessToken = $this->courierApiSettingRepository->getAccessToken();


        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'No valid access token found for the user.',
            ];
        }
        // Fetch the zones for the selected city
        $endpoint = "aladdin/api/v1/cities/$id/zone-list";
        $response = $this->fetchCityList($endpoint, $this->headers($accessToken));

        if (is_array($response)) {
            return $response;
        }

        // Handle unexpected response types
        return [
            'success' => false,
            'message' => 'Unexpected API response format.',
        ];
    }


    public function getAreas($zoneId)
    {
        $accessToken = $this->courierApiSettingRepository->getAccessToken();

        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'No valid access token found for the user.',
            ];
        }

        $endpoint = "aladdin/api/v1/zones/$zoneId/area-list";
        $response = $this->fetchCityList($endpoint, $this->headers($accessToken));


        if (is_array($response)) {
            return $response;
        }

        // Handle unexpected response types
        return [
            'success' => false,
            'message' => 'Unexpected API response format.',
        ];
    }





    public function sendOrderToPathaoCourier($order,  $itemQuantity)
    {
        // Validate order data  oder address at lest 10 chater

        if (strlen($order->address) < 10) {
            throw new \Exception('Address must be at least 10 characters long.');
        }



        $accessToken = $this->courierApiSettingRepository->getAccessToken();
        // Prepare the order payload
        $payload = $this->prepareOrderPayload($order, $itemQuantity);

        // Log the request payload for debugging


        try {
            // Send the request to Pathao API
            $response =  Http::withHeaders($this->headers($accessToken))
                ->post("$this->baseUrl/aladdin/api/v1/orders", $payload);



            if ($response->successful()) {

                return $response->json();
            } else {
                $this->logErrorResponse($response, $order->id);
                throw new \Exception('Failed to send order to Pathao Courier.');
            }
        } catch (\Exception $e) {

            throw $e;
        }
    }

    protected function logErrorResponse($response, $orderId)
    {


        if ($response->status() === 422) {
            $errors = $response->json()['errors'] ?? [];
            Log::error('Validation errors from Pathao API', [
                'errors' => $errors,
                'order_id' => $orderId,
            ]);
        }
    }

    protected function prepareOrderPayload($order, int $itemQuantity): array
    {
        if (empty($order->city_id) || empty($order->zone_id) || empty($order->area_id)) {
            throw new \Exception('City, Zone, and Area IDs are required.');
        }

        $pathaoStoreId =  ApiToken::where('id', 1)->first()->StoreId;
        $amount_to_collect = $order->total_price + $order->shipping_price;

        return [
            'store_id' => $pathaoStoreId,
            'merchant_order_id' => $order->invoice_number,
            'recipient_name' => $order->customer_name,
            'recipient_phone' => $order->phone_number,
            'recipient_address' => $order->address,
            'recipient_city' => (int)$order->city_id,
            'recipient_zone' => (int)$order->zone_id,
            'recipient_area' => (int)$order->area_id,
            'delivery_type' => 48,
            'item_type' => 2,
            'special_instruction' => $order->courier_note ??  'Deliver before 5 PM',
            'item_quantity' => $itemQuantity,
            'item_weight' => '0.5',
            'item_description' => 'Clothing item',
            'amount_to_collect' => $amount_to_collect,
        ];
    }




    public function fetchCityList(string $endpoint, array $headers = []): array
    {
        $response = Http::withHeaders($headers)
            ->get("$this->baseUrl/$endpoint");



        if ($response->successful()) {
            return $response->json();
        }



        return [
            'success' => false,
            'message' => 'Failed to communicate with the API.',
        ];
    }


    // bluk order


    public function sendBulkOrders(array $orders, string $accessToken): array
    {
        $url = "{$this->baseUrl}/aladdin/api/v1/orders/bulk";

        $response = Http::withHeaders($this->headers($accessToken))->post($url, [
            'orders' => $orders,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to send bulk orders: ' . $response->body());
        }



        return $response->json();





    }

    // redx

    private function getApiUrl($endpoint, $params = [])
    {
        $baseUrl = 'https://openapi.redx.com.bd/v1.0.0-beta/';

        // Build the query string from the parameters
        $queryString = http_build_query($params);

        // Return the full URL with query parameters if any
        return $baseUrl . $endpoint . ($queryString ? '?' . $queryString : '');
    }




    private function buildRedxHeader()
    {
        $accessToken =  $this->courierApiSettingRepository->getTokens();
        return [
            'API-ACCESS-TOKEN' => "Bearer {$accessToken}",
        ];
    }


    public function getCity($request)
    {

        $endpoint = 'areas';
        $districtName = $request->get('district_name', $request);

        // Build the API URL with query parameter
        $apiUrl = $this->getApiUrl($endpoint, ['district_name' => $districtName]);



        try {
            // Make the request with headers
            $response = Http::withHeaders($this->buildRedxHeader())->get($apiUrl);

            if ($response->successful()) {
                return $response->json(); // returns the API response as an array
            }

            // If the response was not successful, return a custom error
            return [
                'success' => false,
                'message' => 'Failed to fetch city data from RedX API.',
            ];
        } catch (\Exception $e) {

            return [
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again later.',
            ];
        }
    }

    public function getArea()
    {
        $endpoint = 'areas';
        $apiUrl = $this->getApiUrl($endpoint);


        try {
            // Make the request with headers
            $response = Http::withHeaders($this->buildRedxHeader())->get($apiUrl);

            if ($response->successful()) {
                return $response->json(); // returns the API response as an array
            }


            return [
                'success' => false,
                'message' => 'Failed to fetch areas from RedX API. Please try again later.',
            ];

        } catch (\Exception $e) {

            return [
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again later.',
            ];
        }
    }

    public function createParcel(array $data){
        $endpoint = 'parcels';
        $apiUrl = $this->getApiUrl($endpoint);

        try {
            // Make the request with headers
            $response = Http::withHeaders($this->buildRedxHeader())->post($apiUrl, $data);

            if ($response->successful()) {
                return $response->json(); // returns the API response as an array
            }

            return [
                'success' => false,
                'message' => 'Failed to create parcel in RedX API. Please try again later.',
            ];

        } catch (\Exception $e) {

            return [
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again later.',
            ];
        }
    }

}
