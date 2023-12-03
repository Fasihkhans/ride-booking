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
        @vite([
                'resources/css/app.css',
                'resources/css/dartcars.css',
                'resources/css/assets/vendor/nucleo/css/nucleo.css',
                'resources/css/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css',
                'resources/js/app.js'
            ])
    </head>
    <body class="antialiased g-sidenav-show g-sidenav-pinned">
            <livewire:layout.navigation />
            <div class=" main-content">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow row col-12 dark:bg-gray-700">
                        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                <!-- Page Content -->
                <main class="main-content">
                    {{ $slot }}
                </main>
            </div>
    </body>
</html>
