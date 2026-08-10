<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

        @include('layouts.navigation')
    
        <div
            class="min-h-screen bg-gray-100"
            dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
        >
    
            <div class="admin-content">
    
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
    
                <!-- Page Content -->
                <main>
                   @yield('content')
                </main>
    
            </div>
    
        </div>
    
        <style>
            .admin-content {
                min-height: 100vh;
                margin-inline-start: 260px;
            }
    
            @media (max-width: 768px) {
                .admin-content {
                    margin-inline-start: 0;
                }
            }
        </style>
    
    </body>
</html>
