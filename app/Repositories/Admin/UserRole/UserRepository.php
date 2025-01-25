<?php

namespace App\Repositories\Admin\UserRole;

use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Spatie\Permission\Models\Role;

class UserRepository
{
    public function findUserById(string $id): User
    {
        return User::findOrFail($id);
    }


    public function createUser(array $data): User
    {

        return User::create($data);
    }




    public function save(User $user): void
    {
        $user->save();
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    public function create(array $data): Role
    {
        return Role::create($data);
    }
}
