<?php

namespace App\Http\Controllers\Admin\CustomRegister;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CustomRegisterController extends Controller
{


    public function customRegister(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users',
            'phone' => 'required',
            'address' => 'required',
            // 'city' => 'required',
        ]);

        $userPhone=User::where('phone', $validatedData['phone'])->first();
        if($userPhone){
            return response()->json([
                'success' => false,
                'message' => 'User already registered',
            ]);
        }

    
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['phone'] . '@guest.com', // Generate a unique guest email
            'phone' => $validatedData['phone'], // Generate a unique guest email
            'password' => Hash::make('123456'), // Generate a secure random password
        ]);

    
        $user->addresses()->create([
            'address' => $validatedData['address'],
            'city' => $validatedData['city'] ?? null,
            'phone' => $validatedData['phone'],
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }



    public function searchUser(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([], 200);
        }

        try {
            $users = User::with([
                'addresses' => function ($subQuery) {
                    $subQuery->select('user_id', 'phone');
                }
            ])
                ->where('email', 'like', "%$query%")
                ->orWhereHas('addresses', function ($subQuery) use ($query) {
                    $subQuery->where('phone', 'like', "%$query%");
                })
                ->get(['id', 'name', 'email']);

            // Flatten phone number into the main user object for easier processing
            $response = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->addresses->pluck('phone')->first() ?? null
                ];
            });

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
