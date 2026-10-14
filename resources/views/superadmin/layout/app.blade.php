<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | SolveKit')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100">
    <div class="flex min-h-screen flex-col lg:flex-row">
        @include('superadmin.components.sidebar')

        <div class="flex min-h-screen flex-1 flex-col">
            <flux:header sticky class="lg:hidden">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" />
                <flux:spacer />
                <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
            </flux:header>

            <main class="min-h-screen w-full">
                <div class="mx-auto w-full max-w-[1600px] p-4 sm:p-6 lg:p-8">
                    @if(session('status'))
                        <flux:callout variant="success" icon="check-circle" class="mb-6">{{ session('status') }}</flux:callout>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <x-toast
        :message="session('toast.message', session('status'))"
        :type="session('toast.type', 'success')"
    />

    @fluxScripts
</body>
</html>
