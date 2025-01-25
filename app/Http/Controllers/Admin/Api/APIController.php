<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouriarApiSetting\CourierApiSettingRequest;
use App\Models\Order;

use App\Services\Admin\CouriarApiSetting\CouriarApiSettingServiceInterface;
use Illuminate\Http\Request;
use SteadFast\SteadFastCourierLaravelPackage\Facades\SteadfastCourier;
use Illuminate\Support\Facades\Log;




use Illuminate\Support\Facades\Cache;


use App\Models\ApiToken;
use App\Models\CourierSetting;


use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Return_;

class APIController extends Controller
{
    protected $courierApiSettingService;



    public function __construct(CouriarApiSettingServiceInterface $courierApiSettingService)
    {
        $this->courierApiSettingService = $courierApiSettingService;
    }

    public function index()
    {
        $courierSetting = $this->courierApiSettingService->get();
        $patho = ApiToken::first();

        return view('admin.api.couriar-api.index', compact('courierSetting', 'patho'));
    }

    public function paymentApi()
    {
        return view('admin.api.payment-api.index');
    }

    public function storeOrUpdateCourier(CourierApiSettingRequest $request)
    {


        try {
            Cache::forget('courier_settings');
            Cache::forget('courier_settings_missing_logged');

            $this->courierApiSettingService->storeOrUpdate($request->validated());
            return  redirect()->back()->with('success', 'Courier API setting updated successfully');
        } catch (\Exception $e) {
            return  redirect()->back()->with('error', 'Something went wrong');
        }
    }



    public function    apiToken()
    {
        $patho = ApiToken::first();
        return view('admin.api.index', compact('patho'));
    }




    /**
     * Generate an API Token from the Pathao Hermes API.
     */
    public function generateApiToken(Request $request)
    {
        

        // return $request;
        $this->courierApiSettingService->generateApiToken($request);

        return redirect()->back()->with('success', 'API Token generated successfully.');
    }






    public function sendSteadfast($id)
    {
        try {
            $order = Order::find($id);

            // Check if order exists
            if (!$order) {
                return redirect()->back()->with('error', 'Order not found.');
            }

            // Prepare order data
            $orderData = $this->courierApiSettingService->prepareOrderData($order);

            // Send order to courier API
            $data = $this->courierApiSettingService->sendOrderToCourier($orderData);



            if (is_array($data) && isset($data['status']) && $data['status'] === 'error') {
                // Access the error message
                $errorMessage = $data['message'];




                return  redirect()->back()->with('error', $errorMessage);
            }


            return redirect()->back()->with('success', 'Order sent to Steadfast successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An unexpected error occurred while sending the order to Steadfast.');
        }
    }





    public function bulkSendSteadfast(Request $request)
    {
        $orderIds = $request->input('ids');

        if (empty($orderIds)) {
            return response()->json(['success' => false, 'message' => 'No orders selected.']);
        }

        $ordersData = [];

        foreach ($orderIds as $id) {
            $order = Order::find($id);

            if ($order) {
                $ordersData[] = [
                    'invoice' => $order->invoice_number,
                    'recipient_name' => $order->customer_name,
                    'recipient_phone' => $order->phone_number,
                    'recipient_address' => $order->address,
                    'cod_amount' => $order->total_price + $order->delivery_charge,
                    'note' => $order->courier_note ?? 'Handle with care', // Example note
                ];
            }
        }

        if (empty($ordersData)) {
            return response()->json(['success' => false, 'message' => 'No valid orders found.']);
        }

        // Use Steadfast API to bulk create orders
        try {
            $response = SteadfastCourier::bulkCreateOrders($ordersData);

            if (isset($response['status']) && $response['status'] == 200) {
                // Update the orders based on the response
                $responseData = $response['data']; // Array of consignment data
                foreach ($responseData as $consignment) {
                    // Find the order using the unique `invoice` field
                    $order = Order::where('invoice_number', $consignment['invoice'])->first();

                    if ($order) {

                        // Default courier status to the consignment status
                        $courierStatus = $consignment['status'] ?? 'pending';

                        // Check if consignment_id exists and fetch delivery status
                        if (isset($consignment['consignment_id'])) {
                            $deliveryStatusResponse = SteadfastCourier::checkDeliveryStatusByConsignmentId($consignment['consignment_id']);
                            if (isset($deliveryStatusResponse['delivery_status'])) {
                                $courierStatus = $deliveryStatusResponse['delivery_status']; // Override with delivery_status
                            }
                        }


                        $order->update([
                            'consignment_id' => $consignment['consignment_id'] ?? null,
                            'tracking_code' => isset($consignment['tracking_code'])
                                ? 'https://steadfast.com.bd/t/' . $consignment['tracking_code']
                                : null,
                            //'couriar_status' => $consignment['status'] ?? 'pending',
                            'couriar_status' => $courierStatus,
                            'couriar_name' => 'steadfast',
                        ]);
                    }

                    if ($consignment['consignment_id']) {
                        $delivery_status_response = SteadfastCourier::checkDeliveryStatusByConsignmentId($consignment['consignment_id']);
                    }
                }

                return response()->json([
                    'success' => true,
                    'data' => $response,
                    'delivery_status_response' => $delivery_status_response,
                    'message' => 'Orders sent and updated successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send orders.',
                    'data' => $response,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending orders.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getArea()
    {
        $areas = $this->courierApiSettingService->getArea();


        // Return the unique areas
        return response()->json($areas);
    }




    public function getCity(Request $request)
    {
        return $this->courierApiSettingService->getCity($request);
    }

    public function sendRedx($id)
    {
        try {
            // Fetch the order from the database
            $order = Order::findOrFail($id);


            $data = $this->playload($order);




            // Fetch the token from CourierSetting
            $response = $this->headers($data);

            // Check the response
            if ($response->successful()) {
                // Update the order with the consignment ID
                $order->update([
                    'consignment_id' => $response->json()['tracking_id'],
                ]);
                return back()->with('success', 'Parcel sent to RedX successfully.');
            } else {


                return back()->with('error', 'An error occurred while sending the parcel to RedX: ' . $response->json()['message']);
            }
        } catch (\Exception $e) {


            return  back()->with('error', 'An error occurred while sending the parcel to RedX: ' . $e->getMessage());
        }
    }

    private function playload($order)
    {
        $data = [
            "customer_name" => $order->customer_name,
            "customer_phone" => $order->phone_number,
            "delivery_area" => $order->area_name,
            "delivery_area_id" => $order->area_id,
            "customer_address" => $order->address,
            // "merchant_invoice_id" => $order->invoice_number,
            "cash_collection_amount" => $order->total_price,
            "parcel_weight" => 500, // Adjust as needed
            "instruction" => $order->courier_note ?? "",
            "value" => $order->total_price,
            "is_closed_box" => false,

        ];

        foreach ($data as $key => $value) {
            if (is_null($value)) {
                throw new \Exception("Missing required field: {$key}");
            }
        }


        return $data;
    }

    private function headers($data)
    {


        $corir = CourierSetting::first();
        $token = $corir->redx_access_token;

        if (!$corir || !$corir->redx_access_token) {
            throw new \Exception('RedX access token is missing in CourierSetting.');
        }

        // Send the request to the RedX API
        $response = Http::withHeaders([
            'API-ACCESS-TOKEN' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('https://openapi.redx.com.bd/v1.0.0-beta/parcel', $data);



        return $response;
    }




    public function sendBulkRedx(Request $request)
    {
        Log::info('Bulk RedX request: ' . json_encode($request->all()));

        $orderIds = $request->input('ids');

        if (empty($orderIds)) {
            return response()->json(['success' => false, 'message' => 'No orders selected.']);
        }

        $results = []; // Collect results for each order

        foreach ($orderIds as $id) {
            try {

                $order = Order::findOrFail($id);
                $data = $this->playload($order);
                $response = $this->headers($data);
                $results[] = ['order_id' => $id, 'status' => 'success'];
                // oder update consignment_id
                $order->update([
                    'consignment_id' =>  $response->json()['tracking_id'] ?? null,

                ]);
            } catch (\Exception $e) {
                Log::error("Error sending order {$id} to RedX: " . $e->getMessage());
                $results[] = ['order_id' => $id, 'status' => 'error', 'message' => $e->getMessage()];
            }
        }

        return response()->json(['success' => true, 'message' => 'Orders processed.', 'results' => $results]);
    }





    public function sendPathao($id)
    {

        try {
            $order = Order::where('id', $id)->with('items')->first();


            $item_quantity = $order->items->sum('quantity');


            // Pass the order data as an array to the courier service
            $response =    $this->courierApiSettingService->sendOrderToPathaoCourier($order, $item_quantity);

            if (is_string($response)) {
                $response = json_decode($response);
            } elseif (is_array($response)) {
                $response = json_decode(json_encode($response));
            }



            // Check if the response is successful and properly formatted
            if (isset($response->code) && $response->code == 200) {
                if (isset($response->data->consignment_id)) {
                    $consignmentId = $response->data->consignment_id;

                    // Update the order with the consignment ID and order status
                    $order->update([
                        'consignment_id' => $consignmentId,
                        'order_status' => 'Pending'
                    ]);

                    // Return a success message
                    return redirect()->back()->with('success', 'Order sent to Pathao successfully.');
                } else {
                    return redirect()->back()->with('error', 'Consignment ID is missing in the response.');
                }
            } else {
                return redirect()->back()->with('error', 'Failed to send the order to Pathao: ' . ($response->message ?? 'Unknown error.'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }






    public function sendBulkPathao(Request $request)
    {
        // check request addres alt list 11 chater  and 11 chater 2
        $request->validate([
            'orders' => 'required|array|min:1',


        ]);






        try {
            $orders = Order::whereIn('id', $request->orders)->with('items')->get();

            if ($orders->isEmpty()) {
                return response()->json(['error' => 'No orders found'], 404);
            }



            $acesstoken = ApiToken::first();

            if (!$acesstoken || !$acesstoken->access_token) {
                throw new \Exception('Access token not found in the database');
            }


            $bulkOrders = $orders->map(function ($order) use ($acesstoken) {
                return [
                    'store_id' => $acesstoken->StoreId,
                    'merchant_order_id' => $order->id,
                    'recipient_name' => $order->customer_name,
                    'recipient_phone' => $order->phone_number,
                    'recipient_address' => $order->address,
                    'recipient_city' => $order->city_id,
                    'recipient_zone' => $order->zone_id,
                    'recipient_area' => $order->area_id ?? null,
                    'delivery_type' => 48,
                    'item_type' => 2,
                    'special_instruction' => $order->courier_note ?? 'Handle with care',
                    'item_quantity' => $order->items->sum('quantity'),
                    'item_weight' => '0.5',
                    'amount_to_collect' => $order->total_price + $order->shipping_price,
                    'item_description' => 'Various items',
                ];
            })->toArray();


            $response = $this->courierApiSettingService->sendBulkOrders($bulkOrders, $acesstoken->access_token);



            return back()->with('success', 'Orders sent to Pathao successfully.');
        } catch (\Exception $e) {
            Log::error('Error sending bulk orders to Pathao: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while sending orders to Pathao.');
        }
    }


}
