<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdatePasswordRequest;
use App\Http\Requests\Admin\Profile\UpdateRequest;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\ImageUploadService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function profileSetting()
    {
        $user_id = Auth::user()->id;
        $user_info = User::where('id', $user_id)->with('addresses')->first();


        return view('admin.profile.index', compact('user_info'));
    }

    public function profileUpdate(UpdateRequest $request)
    {

        $user = Auth::user();
        $imagePath = $this->imageUploadService->uploadImage($request->file('image'), 'users');

        $validatedData = $request->validated();


        if ($imagePath) {

            if ($user->image) {

                $this->imageUploadService->deleteFile($user->image);
            }

            $validatedData['image'] = $imagePath;
        }


        // Update user information
        $user->update($validatedData);

        // Update or create user address
        $user_address = UserAddress::firstOrCreate(
            ['user_id' => $user->id],
            ['phone' => $validatedData['phone'], 'address' => $validatedData['address'], 'city' => $validatedData['city']]
        );

        $user_address->update([
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
        ]);


        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function passwordUpdate(UpdatePasswordRequest $request)
    {

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function users(){
        $users = User::with('address')->get();

        return view('admin.user.index', compact('users'));
    }
}
