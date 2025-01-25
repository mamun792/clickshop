<?php

namespace App\Repositories\Admin\Role;

use Spatie\Permission\Models\Role;

class RoleRepository
{
    /**
     * Get all roles with pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllRoles()
    {
        return Role::paginate(20);
    }
}
