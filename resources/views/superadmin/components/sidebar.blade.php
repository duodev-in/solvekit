<flux:sidebar sticky stashable class="min-w-0 overflow-x-hidden border-e border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header>
        <flux:sidebar.brand href="{{ route('admin.dashboard') }}" name="SolveKit Admin" />
        <flux:sidebar.collapse />
    </flux:sidebar.header>

    <flux:sidebar.nav>
        <flux:sidebar.item icon="home" href="{{ route('admin.dashboard') }}" :current="request()->routeIs('admin.dashboard')">Dashboard</flux:sidebar.item>
        <p class="px-3 pt-4 text-[10px] font-semibold uppercase tracking-[0.16em] text-zinc-400">Manage</p>
        @can('manage users')
            <flux:sidebar.item icon="users" href="{{ route('admin.users.index') }}" :current="request()->routeIs('admin.users.*')">Users</flux:sidebar.item>
        @endcan
        @can('manage roles')
            <flux:sidebar.item icon="shield-check" href="{{ route('admin.roles.index') }}" :current="request()->routeIs('admin.roles.*')">Roles</flux:sidebar.item>
        @endcan
        <p class="px-3 pt-4 text-[10px] font-semibold uppercase tracking-[0.16em] text-zinc-400">Review</p>
        @can('view audit logs')
            <flux:sidebar.item icon="clipboard-document-list" href="{{ route('admin.audit-logs.index') }}" :current="request()->routeIs('admin.audit-logs.*')">Audit logs</flux:sidebar.item>
        @endcan
        @can('manage feature requests')
            <flux:sidebar.item icon="sparkles" href="{{ route('admin.feature-requests.index') }}" :current="request()->routeIs('admin.feature-requests.*')">Feature requests</flux:sidebar.item>
        @endcan
        @can('view bug reports')
            <flux:sidebar.item icon="bug-ant" href="{{ route('admin.bug-reports.index') }}" :current="request()->routeIs('admin.bug-reports.*')">Bug reports</flux:sidebar.item>
        @endcan
        @can('view contact messages')
            <flux:sidebar.item icon="envelope" href="{{ route('admin.contact-messages.index') }}" :current="request()->routeIs('admin.contact-messages.*')">Contact messages</flux:sidebar.item>
        @endcan
    </flux:sidebar.nav>

    <flux:sidebar.spacer />

    <details class="group relative min-w-0">
        <summary class="list-none cursor-pointer rounded-sm border border-zinc-200 bg-zinc-50 p-3 transition hover:bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-950/70 dark:hover:bg-zinc-900">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-900 text-sm font-semibold text-white dark:bg-zinc-700">
                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-zinc-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </summary>
        <div class="absolute bottom-[calc(100%+0.5rem)] left-0 right-0 z-20 min-w-0 border border-zinc-200 bg-white p-1 shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
            <a href="{{ route('admin.profile.show') }}" class="block px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800">Profile settings</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="block w-full px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30">Log out</button>
            </form>
        </div>
    </details>

    <flux:sidebar.nav>
        <flux:sidebar.item icon="arrow-left" href="{{ url('/') }}">Back to calculator</flux:sidebar.item>
    </flux:sidebar.nav>
</flux:sidebar>
