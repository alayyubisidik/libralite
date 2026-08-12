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
    <body class="font-sans antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center bg-gray-50 px-4 py-12 dark:bg-gray-900 sm:px-6">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2.5">
                <x-application-logo class="h-9 w-auto text-blue-600 dark:text-blue-400" />
                <span class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    {{ config('app.name', 'LibraLite') }}
                </span>
            </a>

            <div class="mt-8 w-full max-w-md rounded-lg bg-white px-6 py-8 shadow-sm ring-1 ring-gray-200 sm:px-8 dark:bg-gray-800 dark:ring-gray-700">
                {{ $slot }}
            </div>

            @flasher_render
        </div>
    </body>
</html>
