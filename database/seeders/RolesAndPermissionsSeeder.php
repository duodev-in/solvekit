<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $permissionDefinitions = collect(config('roles.groups', []))
                ->flatMap(fn (array $group): array => array_keys($group['permissions'] ?? []));
            $permissions = $permissionDefinitions
                ->mapWithKeys(fn (string $permission): array => [$permission => Permission::findOrCreate($permission, 'web')]);

            foreach (config('roles.roles', []) as $name => $rolePermissions) {
                $role = Role::findOrCreate($name, 'web');
                $role->syncPermissions($rolePermissions === '*' ? $permissions->values() : $rolePermissions);
            }

            Permission::query()
                ->where('guard_name', 'web')
                ->whereNotIn('name', $permissionDefinitions->all())
                ->delete();
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
