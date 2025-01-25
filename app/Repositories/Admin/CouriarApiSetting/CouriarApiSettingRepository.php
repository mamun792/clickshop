<?php

namespace App\Repositories\Admin\CouriarApiSetting;

use App\Models\CourierSetting;
use Illuminate\Support\Facades\Log;
use App\Models\ApiToken;
use SteadFast\SteadFastCourierLaravelPackage\Facades\SteadfastCourier;

class CouriarApiSettingRepository implements CourierApiSettingRepositoryInterface
{
    public function storeOrUpdate($data)
    {


        try {
            $result = CourierSetting::updateOrCreate(['id' => 1], $data);
        } catch (\Exception $e) {
            //  Log::error('Error in storeOrUpdate: ' . $e->getMessage());
            return false;
        }
    }


    public function get()
    {
        return CourierSetting::first();
    }

    public function sendOrder(array $orderData): ?array
    {
        return SteadfastCourier::placeOrder($orderData);
    }





    public function saveApiToken(array $attributes)
    {
        // Ensure the 'id' is included in the attributes
        if (!isset($attributes['id'])) {
            throw new \InvalidArgumentException('The "id" key is required to update the record.');
        }

        try {
            $cc = ApiToken::updateOrCreate(
                ['id' => $attributes['id']], // Ensure the ID matches
                [
                    'client_id' => $attributes['client_id'],
                    'client_secret' => $attributes['client_secret'],
                    'username' => $attributes['username'],
                    'password' => $attributes['password'],
                    'access_token' => $attributes['access_token'],
                    'refresh_token' => $attributes['refresh_token'],
                    'expires_at' => $attributes['expires_at'],
                ]
            );

            Log::info('Updated or created token:', $cc->toArray());
        } catch (\Exception $e) {
            Log::error('Error in updateOrCreate: ' . $e->getMessage());
            throw $e; // Rethrow to handle further up the stack
        }
    }

    public function getAccessToken()
    {
        $token = ApiToken::where('expires_at', '>', now())
            ->first();

        $acess = $token->access_token ?? null;
        //   Log::info('Token: ' . $acess);
        return $acess;
    }

    // redx
    public function getTokens()
    {
        $redx = CourierSetting::first();
        if (!$redx) {
            throw new \Exception("No records found in courier_settings table");
        }

        return $redx->redx_access_token;
    }
}
