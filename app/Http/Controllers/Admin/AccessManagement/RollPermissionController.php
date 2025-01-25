<?php

namespace App\Http\Controllers\Admin\AccessManagement;



use App\Http\Controllers\Controller;
use App\Services\Admin\Role\RolePermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RollPermissionController extends Controller
{

    protected $rolePermissionService;

    public function __construct(RolePermissionService $rolePermissionService)
    {
        $this->rolePermissionService = $rolePermissionService;
    }


    public function index()
    {
        $roles = $this->rolePermissionService->getAllRoles();
        return view('admin.accessManagement.role-permission.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = $this->rolePermissionService->getPermissionsGroupedByGroup();
        return view('admin.accessManagement.role-permission.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated= $request->validate([
            'name' => ['required', 'max:50', 'unique:roles,name']
        ]);

        $this->rolePermissionService->createRoleWithPermissions($validated, $request->permissions);


        return to_route('role-permission.index')->with('success', 'New role permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all()->groupBy('group');
        $rolePermissions = $role->permissions;
        $rolePermissions = $rolePermissions->pluck('name')->toArray();

        return view('admin.accessManagement.role-permission.edit', compact('permissions', 'role', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:50', 'unique:roles,name,' . $id]
        ]);
        $this->rolePermissionService->updateRoleWithPermissions($id, $validated, $request->permissions);

        return to_route('role-permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->rolePermissionService->deleteRole($id);

            return redirect()->back()->with('success', 'Role has been deleted successfully');

        }catch(\Exception $e) {
            logger($e);
            return response(['message' => 'Something Went Wrong Please Try Again!'], 500);
        }
    }

}
