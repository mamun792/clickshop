<?php

namespace App\Services\Admin\Role;

use App\Repositories\Admin\Role\RoleRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionService
{
    protected $roleRepository;

    /**
     * Inject the RoleRepository.
     *
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get all roles with pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllRoles()
    {
        return $this->roleRepository->getAllRoles();
    }

    public function getPermissionsGroupedByGroup()
    {
        return Permission::all()->groupBy('group');
    }

    public function createRoleWithPermissions(array $validatedData, array $permissions)
    {
        $role = Role::create(['guard_name' => 'web', 'name' => $validatedData['name']]);
        $role->syncPermissions($permissions);
    }

    public function updateRoleWithPermissions(string $roleId, array $validatedData, array $permissions)
    {
        $role = Role::findOrFail($roleId);
        $role->update(['guard_name' => 'web', 'name' => $validatedData['name']]);
        $role->syncPermissions($permissions);
    }

    public function deleteRole(string $roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->delete();
    }

}
