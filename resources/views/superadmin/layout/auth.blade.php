<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin access | SolveKit')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="grid min-h-screen place-items-center bg-zinc-100 p-6 dark:bg-zinc-950">
    <main class="w-full max-w-md">@yield('content')</main>
    @fluxScripts
</body>
</html>
