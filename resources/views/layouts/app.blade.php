@props([
    'title' => 'SolveKit',
    'description' => '',
    'showFooter' => true,
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="author" content="SolveKit">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $description }}">
    <meta property="twitter:image" content="{{ asset('images/twitter-image.jpg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @stack('head')

    {{ $styles ?? '' }}
</head>
<body class="min-h-screen bg-gray-50">
    <x-navbar />

    <main>
        {{ $slot }}
    </main>

    @if($showFooter)
        <x-footer />
    @endif

    <x-toast
        :message="session('toast.message', session('status'))"
        :type="session('toast.type', 'success')"
    />

    @stack('scripts')

    {{ $scripts ?? '' }}
</body>
</html>