<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdatePasswordRequest;
use App\Http\Requests\Admin\Profile\UpdateRequest;
use App\Http\Requests\Api\LoginStoreRequest;
use App\Http\Requests\Api\RegisterStoreRequest;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\Api\Auth\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use App\Traits\FileUploadTrait;




class AuthController extends Controller
{
    protected $registerService;

    use FileUploadTrait;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }



    public function register(RegisterStoreRequest $request)
    {
        try {

            $data = $request->validated();

            $data['password'] = Hash::make($data['password']);

            $user = $this->registerService->register($data);

            return ApiResponse::success($user, 'User registered successfully', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return ApiResponse::validationError($e->errors(), 'Validation failed');
        } catch (\Exception $e) {

            return ApiResponse::error($e->getMessage(), 500);
        }
    }




    public function login(LoginStoreRequest $request)
    {

        $credentials = $request->validated();

        try {

            $token = $this->registerService->login($credentials);

            return ApiResponse::success($token, 'User logged in successfully');
        } catch (ValidationException $e) {

            return ApiResponse::validationError($e->errors(), 'Validation failed');
        } catch (QueryException $e) {

            return ApiResponse::error('Database query error', 500);
        } catch (AuthenticationException $e) {

            return ApiResponse::error('Invalid email or password', 401);
        } catch (\Exception $e) {

            dd($e->getMessage());

            return ApiResponse::error('An error occurred', 500);
        }
    }



    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return ApiResponse::success('User logged out successfully');
    }

    public function user()
    {
        return ApiResponse::success($this->registerService->getAuthenticatedUser(), 'User retrieved successfully');
    }

    public function refresh()
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return ApiResponse::success($newToken, 'Token refreshed');
    }

    protected function respondWithToken($token)
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());

        return ApiResponse::success($newToken, 'Token refreshed');
    }

    public function accountSetting(UpdateRequest $request){
      

        try{

            $user = Auth::user();
            $imagePath = $this->uploadFile($request, 'image');
    
            $validatedData = $request->validated();
    
            if ($imagePath) {
    
                if ($user->image) {
                    // Delete the old image from the public directory
                    $oldImagePath = public_path($user->image); // Full path of the old image
    
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Delete the old image
                    }
                }
    
                $validatedData['image'] = $imagePath;
            }
    
             // Update user information
             $user->update($validatedData);


             /*
    
             // Update or create user address
             $user_address = UserAddress::firstOrCreate(
                 ['user_id' => $user->id], // Condition to find the record
                 ['phone' => $validatedData['phone'] ]
             );
     
             $user_address->update([
                 'phone' => $validatedData['phone'],
             ]);   */
    
             return ApiResponse::success([
                'user' => $user
            ], 'User information updated successfully');


        }catch(\Exception $e){

            dd($e->getMessage());

            return ApiResponse::error('An error occurred', 500);


        }
       

    }

    public function passwordSetting(UpdatePasswordRequest $request){
        try{


            $user = Auth::user();
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            return ApiResponse::success('Password updated successfully', 201);
           

        }catch(\Exception $e){

            //dd($e->getMessage());

            return ApiResponse::error('An error occurred', 500);

        }


    }

    public function deleteAccount(Request $request){

        try{

            $user_id = Auth::user()->id;

            User::where('id', $user_id)->delete();

            return ApiResponse::success('User account deleted successfully', 201);

        }catch(\Exception $e){
            
            return ApiResponse::error('An error occurred', 500);

        }
    }

   


}
