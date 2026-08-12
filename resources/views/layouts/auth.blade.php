<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LibraLite') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-blue-50 to-white px-4 py-12 sm:px-6">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-lg font-bold text-white">
                    L
                </span>
                <span class="text-2xl font-semibold tracking-tight text-blue-950">
                    {{ config('app.name', 'LibraLite') }}
                </span>
            </a>

            <div class="mt-8 w-full max-w-md rounded-lg bg-white px-6 py-8 shadow-lg shadow-blue-900/5 ring-1 ring-blue-100 sm:px-8">
                {{ $slot }}
            </div>

            @flasher_render
        </div>
    </body>
</html>
