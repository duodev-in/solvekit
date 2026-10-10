@extends('superadmin.layout.app')

@section('title', $user->name . ' | SolveKit')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4 border-b border-zinc-200 pb-5 dark:border-zinc-800">
        <div>
            <p class="text-sm font-medium text-zinc-500">Administration / Users</p>
            <h1 class="mt-1 text-3xl font-semibold">{{ $user->name }}</h1>
            <p class="mt-1 text-sm text-zinc-500">{{ $user->email }}</p>
        </div>
        <div class="flex items-center gap-2">
            <flux:button href="{{ route('admin.users.edit', $user) }}" variant="primary">Edit user</flux:button>
            <flux:button href="{{ route('admin.users.index') }}" variant="outline">Back to users</flux:button>
        </div>
    </div>

    <div data-tab-group class="mt-8 max-w-5xl">
        <nav class="flex gap-7 border-b border-zinc-200 dark:border-zinc-800" aria-label="User sections">
            <button type="button" data-tab-target="summary" aria-selected="true" class="border-b-2 border-primary-600 px-1 pb-3 text-sm font-medium text-primary-600">Summary</button>
            <button type="button" data-tab-target="permissions" aria-selected="false" class="border-b-2 border-transparent px-1 pb-3 text-sm font-medium text-zinc-500">Permissions</button>
            <button type="button" data-tab-target="activities" aria-selected="false" class="border-b-2 border-transparent px-1 pb-3 text-sm font-medium text-zinc-500">Activities</button>
        </nav>

        <div data-tab-panel="summary" class="grid gap-8 py-8 lg:grid-cols-[1fr_18rem]">
            <div class="space-y-6">
                <div class="border-b border-zinc-200 pb-5 dark:border-zinc-800">
                    <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Account details</p>
                    <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm text-zinc-500">Name</dt>
                            <dd class="mt-1 font-medium">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-zinc-500">Email</dt>
                            <dd class="mt-1 font-medium">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-zinc-500">Email verified</dt>
                            <dd class="mt-1 font-medium">{{ $user->email_verified_at?->toFormattedDateString() ?? 'Not verified' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-zinc-500">Joined</dt>
                            <dd class="mt-1 font-medium">{{ $user->created_at?->toFormattedDateString() ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Roles</p>
                    <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm">
                        @forelse($user->roles as $role)
                            <a href="{{ route('admin.roles.show', $role) }}" class="text-primary-600 hover:text-primary-700">{{ ucfirst($role->name) }}</a>
                        @empty
                            <span class="text-zinc-500">No roles assigned.</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="border-l-2 border-primary-600 pl-4">
                <p class="text-sm text-zinc-500">Current status</p>
                <p class="mt-1 text-lg font-semibold">{{ ucfirst($user->status ?? 'active') }}</p>
                <form method="POST" action="{{ route('admin.users.status.update', $user) }}" class="mt-4 flex items-end gap-2">
                    @csrf
                    @method('PATCH')
                    <div class="min-w-0 flex-1">
                        <flux:select name="status" label="Change status">
                            @foreach(config('superadmin.statuses') as $status)
                                <option value="{{ $status }}" @selected($user->status === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                    <flux:button type="submit" variant="outline">Save</flux:button>
                </form>
            </div>
        </div>

        <div data-tab-panel="permissions" class="py-8" hidden>
            <div class="border-b border-zinc-200 pb-3 dark:border-zinc-800">
                <h2 class="text-lg font-semibold">Permissions</h2>
                <p class="mt-1 text-sm text-zinc-500">Permissions inherited from the user’s assigned roles.</p>
            </div>
            <div class="divide-y divide-zinc-200 border-b border-zinc-200 dark:divide-zinc-800 dark:border-zinc-800">
                @php($assignedPermissionNames = $permissions->pluck('name')->all())
                @if($permissions->isEmpty())
                    <p class="py-6 text-sm text-zinc-500">No permissions assigned.</p>
                @else
                @foreach($permissionGroups as $module => $group)
                    @php($modulePermissions = collect($group['permissions'])->filter(fn (array $permission, string $name): bool => in_array($name, $assignedPermissionNames, true)))
                    @if($modulePermissions->isNotEmpty())
                        <div class="py-5">
                            <h3 class="font-medium capitalize">{{ $module }}</h3>
                            <p class="mt-1 text-sm text-zinc-500">{{ $group['description'] }}</p>
                            <div class="mt-3 space-y-3">
                                @foreach($modulePermissions as $permissionName => $permission)
                                    <div class="flex flex-wrap items-start justify-between gap-3 text-sm">
                                        <div>
                                            <p>{{ ucfirst($permissionName) }}</p>
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
        </div>

        <div data-tab-panel="activities" class="py-8" hidden>
            <div class="border-b border-zinc-200 pb-3 dark:border-zinc-800">
                <h2 class="text-lg font-semibold">Activities</h2>
                <p class="mt-1 text-sm text-zinc-500">Actions performed by this user and changes made to this account.</p>
            </div>
            <div class="divide-y divide-zinc-200 border-b border-zinc-200 dark:divide-zinc-800">
                @forelse($activities as $activity)
                    <div class="flex flex-wrap items-start justify-between gap-3 py-4">
                        <div>
                            <p class="font-medium">{{ ucfirst($activity->event) }} {{ class_basename($activity->auditable_type) }}</p>
                            <p class="mt-1 text-sm text-zinc-500">Performed by {{ $activity->user?->name ?? 'System' }}</p>
                        </div>
                        <time class="text-sm text-zinc-500" datetime="{{ $activity->created_at?->toISOString() }}">{{ $activity->created_at?->diffForHumans() ?? '—' }}</time>
                    </div>
                @empty
                    <p class="py-6 text-sm text-zinc-500">No activity recorded for this user.</p>
                @endforelse
            </div>
            @if($activities->hasPages())
                <div class="mt-5">{{ $activities->links() }}</div>
            @endif
        </div>
    </div>
@endsection
