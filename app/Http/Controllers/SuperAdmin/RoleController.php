<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\SuperAdmin\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService) {}

    public function index(): View
    {
        abort_unless(auth()->user()->can('manage roles'), 403);

        return view('superadmin.roles.index', [
            'roles' => Role::with('permissions')->withCount('users')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        abort_unless(auth()->user()->can('manage roles'), 403);

        return view('superadmin.roles.create', [
            'permissionGroups' => config('roles.groups', []),
        ]);
    }

    public function show(Role $role): View
    {
        abort_unless(auth()->user()->can('manage roles'), 403);

        return view('superadmin.roles.show', [
            'role' => $role->load('permissions', 'users'),
            'permissions' => $role->permissions()->paginate(20),
            'users' => $role->users()->with('roles')->latest()->paginate(20),
            'permissionGroups' => config('roles.groups', []),
        ]);
    }

    public function edit(Role $role): View
    {
        abort_unless(auth()->user()->can('manage roles'), 403);

        return view('superadmin.roles.edit', [
            'role' => $role->load('permissions'),
            'permissionGroups' => config('roles.groups', []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->can('manage roles'), 403);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);
        $this->roleService->create($data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Role created.']);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        abort_unless(auth()->user()->can('manage roles'), 403);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name,'.$role->id],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);
        $this->roleService->update($role, $data);

        return back()->with('toast', ['type' => 'success', 'message' => 'Role updated.']);
    }
}
