<?php

namespace App\Services\SuperAdmin;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function create(array $data): Role
    {
        return DB::transaction(function () use ($data): Role {
            $permissions = $data['permissions'] ?? [];
            $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
            $role->syncPermissions($permissions);

            return $role;
        });
    }

    public function update(Role $role, array $data): Role
    {
        return DB::transaction(function () use ($role, $data): Role {
            $role->update(['name' => $data['name']]);
            $role->syncPermissions($data['permissions'] ?? []);

            return $role->refresh();
        });
    }

    public function permissions()
    {
        return Permission::query()->orderBy('name')->get();
    }

    public function permissionGroups(): array
    {
        return config('roles.groups', []);
    }
}
