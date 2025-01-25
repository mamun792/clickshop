<?php

namespace App\Http\Controllers\Api\Profile;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\StoreUserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function createAddress(StoreUserAddressRequest $request)
    {

        try {

            $validated = $request->validated();

            $user_id = Auth::user()->id;

            $validated['user_id'] = $user_id;

            // Save the address
            $address = UserAddress::create($validated);

            return ApiResponse::success([
                'success' => true,
                'address' => $address,
            ], 'Address saved successfully.');
        } catch (\Exception $e) {

            

            return ApiResponse::error('An error occurred', 500);
        }
    }


    public function updateAddress(StoreUserAddressRequest $request)
    {
        try {

            $validated = $request->data;

            $id = $request->id;

            // Find the address by ID
            $address = UserAddress::find($id);

            // Update the address
            $address->update($validated);

            return ApiResponse::success([
                'success' => true,
                'address' => $address,
            ], 'Address updated successfully.');

        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred', 500);
        }
    }

    public function getAddress(){
        try{

            $user_id = Auth::user()->id;

            $address = UserAddress::where('user_id', $user_id)->get();

            return ApiResponse::success([
                'success' => true,
                'address' => $address,
            ]);


        }catch(\Exception $error){
            return ApiResponse::error('An error occurred', 500);
        }
    }

    public function deleteAddress(Request $request){

        try{

            $user_id = Auth::user()->id;

            UserAddress::where('id', $request->id)->delete();
            $address = UserAddress::where('user_id', $user_id)->get();
            return ApiResponse::success([
                'success' => true,
                'address' => $address,
            ]);


        }catch(\Exception $error){
            return ApiResponse::error('An error occurred', 500);

        }
    }



}
