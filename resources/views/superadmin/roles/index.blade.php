@extends('superadmin.layout.app')

@section('title', 'Roles | SolveKit')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4 border-b border-zinc-200 pb-5 dark:border-zinc-800">
        <div>
            <p class="text-sm font-medium text-zinc-500">Administration</p>
            <h1 class="mt-1 text-3xl font-semibold">Roles</h1>
        </div>
        <flux:button href="{{ route('admin.roles.create') }}" variant="primary" icon="plus">Create role</flux:button>
    </div>

    <div class="mt-8 max-w-5xl">
        <div class="grid grid-cols-[minmax(0,1fr)_auto_auto] gap-4 border-b border-zinc-200 px-3 pb-3 text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:border-zinc-800">
            <span>Role</span>
            <span>Permissions</span>
            <span>Actions</span>
        </div>
        <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
            @foreach($roles as $role)
                <div class="grid grid-cols-[minmax(0,1fr)_auto_auto] items-center gap-4 px-3 py-4">
                    <div>
                        <p class="font-medium">{{ ucfirst($role->name) }}</p>
                        <p class="mt-1 text-sm text-zinc-500">{{ $role->users_count }} assigned users</p>
                    </div>
                    <span class="text-sm text-zinc-500">{{ $role->permissions->count() }}</span>
                    <div class="flex items-center gap-2">
                        <flux:button href="{{ route('admin.roles.show', $role) }}" variant="outline" size="sm">View</flux:button>
                        <flux:button href="{{ route('admin.roles.edit', $role) }}" variant="primary" size="sm">Edit</flux:button>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection
