@props(['title' => config('app.name', 'Laravel'), 'noNav' => false])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Default Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Default App Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Extra head stack (optional per page) -->
    @stack('head')
</head>

<body class="font-sans antialiased bg-gray-50 min-h-screen">
    <div class="min-h-screen bg-gray-100">
        {{-- Optional Navigation --}}
        @unless($noNav)
            @include('layouts.navigation')
        @endunless

        {{-- Optional Page Header --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- Optional scripts --}}
    @stack('scripts')
</body>
</html>
