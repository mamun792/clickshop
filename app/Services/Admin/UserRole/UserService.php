<?php

namespace App\Services\Admin\UserRole;


use App\Models\User;
use App\Repositories\Admin\UserRole\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    /**
     * Inject UserRepository.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    public function createUser(array $data): void
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ];

     $ser= User::create($userData);
     $ser->assignRole($data['role']);
    // Log::info($ser);

       // $user = $this->userRepository->create($userData);

        // Assign role to the user
        // $user->assignRole($data['role']);
    }




    public function updateUser(array $data, string $id): void
    {
        $user = $this->userRepository->findUserById($id);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $this->userRepository->save($user);

        // Assign role
        $user->syncRoles($data['role']);
    }

    /**
     * Delete a user by ID.
     *
     * @param string $id
     * @throws \Exception
     */
    public function deleteUser(string $id): void
    {
        $user = $this->userRepository->findUserById($id);

        if ($user->getRoleNames()->contains('Super Admin')) {

            throw new \Exception("You can't delete super admin!");
        }

        DB::beginTransaction();
        try {
            $this->userRepository->deleteUser($user);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception('Something went wrong. Please try again!');
        }
    }

    public function createRole(array $data): void
    {
        $this->userRepository->create($data);
    }
}
