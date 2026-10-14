@extends('superadmin.layout.app')

@section('title', 'Edit ' . ucfirst($role->name) . ' | SolveKit')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4 border-b border-zinc-200 pb-5 dark:border-zinc-800">
        <div>
            <p class="text-sm font-medium text-zinc-500">Administration / Roles</p>
            <h1 class="mt-1 text-3xl font-semibold">Edit {{ ucfirst($role->name) }}</h1>
        </div>
        <flux:button href="{{ route('admin.roles.index') }}" variant="outline">Back to roles</flux:button>
    </div>

    <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="mt-8 max-w-4xl">
        @csrf
        @method('PUT')

        <div class="grid gap-6 border-b border-zinc-200 pb-8 dark:border-zinc-800 lg:grid-cols-[14rem_1fr]">
            <div>
                <h2 class="font-semibold">Role details</h2>
                <p class="mt-1 text-sm text-zinc-500">Update the role name and access permissions.</p>
            </div>
            <div class="max-w-xl">
                <flux:input name="name" label="Role name" value="{{ $role->name }}" placeholder="e.g. Support manager" required />
            </div>
        </div>

        <div class="grid gap-6 border-b border-zinc-200 py-8 dark:border-zinc-800 lg:grid-cols-[14rem_1fr]">
            <div>
                <h2 class="font-semibold">Permissions</h2>
                <p class="mt-1 text-sm text-zinc-500">Choose the capabilities assigned to this role.</p>
            </div>
            <div class="divide-y divide-zinc-200 border-y border-zinc-200 dark:divide-zinc-800 dark:border-zinc-800">
                @foreach($permissionGroups as $module => $group)
                    <div class="py-5 first:pt-0 last:pb-0">
                        <h3 class="font-medium capitalize">{{ $module }}</h3>
                        <p class="mt-1 text-sm text-zinc-500">{{ $group['description'] }}</p>
                        <div class="mt-3 divide-y divide-zinc-100 dark:divide-zinc-800/80">
                            @foreach($group['permissions'] as $permissionName => $permission)
                                <label class="flex cursor-pointer items-start justify-between gap-4 py-3 text-sm hover:bg-zinc-50 dark:hover:bg-zinc-900">
                                    <span>
                                        <span class="block text-zinc-700 dark:text-zinc-200">{{ ucfirst($permissionName) }}</span>
                                        <span class="mt-1 block text-xs text-zinc-500">{{ $permission['description'] }}</span>
                                    </span>
                                    <span class="flex shrink-0 items-center gap-3">
                                        <span class="text-[10px] font-semibold uppercase tracking-wide text-zinc-400">{{ $permission['scope'] }}</span>
                                        <input type="checkbox" name="permissions[]" value="{{ $permissionName }}" @checked($role->hasPermissionTo($permissionName)) class="size-4 rounded-sm border-zinc-300 text-primary-600 focus:ring-primary-600">
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6">
            <flux:button href="{{ route('admin.roles.index') }}" variant="ghost">Cancel</flux:button>
            <flux:button type="submit" variant="primary">Save changes</flux:button>
        </div>
    </form>
@endsection
