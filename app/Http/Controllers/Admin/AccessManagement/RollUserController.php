<?php

namespace App\Http\Controllers\Admin\AccessManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Admin\UserRole\UserService;
use Spatie\Permission\Models\Role;

class RollUserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index()
    {
         $admins = User::where('role', 'admin')->get();
        return view('admin.accessManagement.role-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::latest()->get();
        return view('admin.accessManagement.role-user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validated=  $request->validate([
        //     'name' => ['required', 'max:255'],
        //     'email' => ['required', 'max:255', 'email', 'unique:users,email'],
        //     'password' => ['required', 'confirmed'],
        //     'role' => ['required']
        // ]);

        // $user=  $this->userService->createUser($validated);

        // assign role

        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
            'role' => ['required']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
         $user->role = 'admin';
        $user->save();

        $user->assignRole($request->role);

        return to_route('role-user.index');
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
        $admin = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.accessManagement.role-user.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users,email,' . $id],
            'password' => ['nullable', 'confirmed'],
            'role' => ['required']
        ]);

        $this->userService->updateUser($validated, $id);

        return to_route('role-user.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);

        return to_route('role-user.index')->with('success', 'Role deleted successfully');
    }


    public function createRole(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255', 'unique:roles,name']
        ]);

        $this->userService->createRole($validated);

        return back()->with('success', 'Role created successfully');
    }
}
