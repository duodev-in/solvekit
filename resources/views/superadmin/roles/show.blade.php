@extends('superadmin.layout.app')

@section('title', 'Role: ' . $role->name . ' | SolveKit')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm font-medium text-zinc-500">Administration</p>
            <h1 class="mt-1 text-3xl font-semibold">{{ ucfirst($role->name) }}</h1>
        </div>
        <flux:button href="{{ route('admin.roles.index') }}" variant="outline">Back to roles</flux:button>
    </div>

    <div data-tab-group class="mt-8 max-w-5xl">
        <nav class="flex gap-7 border-b border-zinc-200 dark:border-zinc-800" aria-label="Role sections">
            <button type="button" data-tab-target="overview" aria-selected="true" class="border-b-2 border-primary-600 px-1 pb-3 text-sm font-medium text-primary-600">Overview</button>
            <button type="button" data-tab-target="permissions" aria-selected="false" class="border-b-2 border-transparent px-1 pb-3 text-sm font-medium text-zinc-500">Permissions</button>
            <button type="button" data-tab-target="users" aria-selected="false" class="border-b-2 border-transparent px-1 pb-3 text-sm font-medium text-zinc-500">Users</button>
        </nav>

        <div data-tab-panel="overview" class="grid gap-8 py-8 lg:grid-cols-3">
                <div class="border-l-2 border-primary-600 pl-4">
                    <p class="text-sm text-zinc-500">Role name</p>
                    <p class="mt-2 text-2xl font-semibold">{{ ucfirst($role->name) }}</p>
                </div>
                <div class="border-l-2 border-zinc-300 pl-4 dark:border-zinc-700">
                    <p class="text-sm text-zinc-500">Permission count</p>
                    <p class="mt-2 text-2xl font-semibold">{{ $role->permissions()->count() }}</p>
                </div>
                <div class="border-l-2 border-zinc-300 pl-4 dark:border-zinc-700">
                    <p class="text-sm text-zinc-500">Assigned users</p>
                    <p class="mt-2 text-2xl font-semibold">{{ $role->users()->count() }}</p>
                </div>
        </div>

        <div data-tab-panel="permissions" class="py-8" hidden>
                <div class="mb-4 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                    <h2 class="text-lg font-semibold">Permissions</h2>
                    <span class="text-sm text-zinc-500">{{ $permissions->total() }} total</span>
                </div>

                <div class="divide-y divide-zinc-200 border-y border-zinc-200 dark:divide-zinc-800 dark:border-zinc-800">
                    @php($rolePermissionNames = $permissions->pluck('name')->all())
                    @if($permissions->isEmpty())
                        <p class="py-5 text-sm text-zinc-500">No permissions assigned to this role yet.</p>
                    @else
                    @foreach($permissionGroups as $module => $group)
                        @php($modulePermissions = collect($group['permissions'])->filter(fn (array $permission, string $name): bool => in_array($name, $rolePermissionNames, true)))
                        @if($modulePermissions->isNotEmpty())
                            <div class="py-5">
                                <h3 class="font-medium capitalize">{{ $module }}</h3>
                                <p class="mt-1 text-sm text-zinc-500">{{ $group['description'] }}</p>
                                <div class="mt-3 space-y-3">
                                    @foreach($modulePermissions as $permissionName => $permission)
                                        <div class="flex flex-wrap items-start justify-between gap-3 text-sm">
                                            <div>
                                                <p class="text-zinc-700 dark:text-zinc-200">{{ ucfirst($permissionName) }}</p>
                                                <p class="mt-1 text-xs text-zinc-500">{{ $permission['description'] }}</p>
                                            </div>
                                            <span class="text-[10px] font-semibold uppercase tracking-wide text-zinc-400">{{ $permission['scope'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @endif
                </div>

                @if($permissions->hasPages())
                    <div class="mt-5">
                        {{ $permissions->links() }}
                    </div>
                @endif
        </div>

        <div data-tab-panel="users" class="py-8" hidden>
                <div class="mb-4 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                    <h2 class="text-lg font-semibold">Users with this role</h2>
                    <span class="text-sm text-zinc-500">{{ $users->total() }} total</span>
                </div>

                <div class="divide-y divide-zinc-200 border-y border-zinc-200 dark:divide-zinc-800 dark:border-zinc-800">
                    @forelse($users as $user)
                        <div class="flex items-center justify-between gap-4 py-3">
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</p>
                                <p class="text-sm text-zinc-500">{{ $user->email }}</p>
                            </div>
                            <span class="text-xs font-medium text-zinc-500">
                                {{ ucfirst($user->status ?? 'active') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-500">No users currently assigned to this role.</p>
                    @endforelse
                </div>

                @if($users->hasPages())
                    <div class="mt-5">
                        {{ $users->links() }}
                    </div>
                @endif
        </div>
    </div>
@endsection
