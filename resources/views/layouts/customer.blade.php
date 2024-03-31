<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/7f4db50383.js" crossorigin="anonymous"></script>
        {{-- <script src="https://cdn.socket.io/4.3.2/socket.io.min.js" integrity="sha384-+qLXzUHURwIq9SFLC+I/chl4j8KKUi8x+UnjukT2BwLd9HobPBJxL8JjJ2FuW/ts" crossorigin="anonymous"></script> --}}
        <script src="{{ asset('assets/js/jQuery.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-screen overflow-hidden font-sans antialiased text-gray-900">

        <div class="absolute top-0 left-0 z-50 flex justify-between w-full p-2 bg-black h-14">
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center justify-center order-1 w-10 h-10 mx-2 text-sm align-middle bg-white rounded-lg invert text-white-500 hover:bg-gray-100 hover:invert-0 focus:outline-none focus:ring-2 focus:ring-gray-200"  aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>

            </button>
            <x-application-logo class="order-2 text-gray-500 w-50 fill-white h-50"  style="filter: invert(100)"/>
            <div class="order-3 p-2 invert hover:invert-0 ">
                <i class=" fa-solid fa-bell"></i>
            </div>
        </div>
        <div class="flex items-center justify-center h-full overflow-hidden bg-gray-100 bg-center bg-no-repeat bg-cover sm:justify-center " style="background-image: url('{{ asset('assets/svg/loginBg.svg') }}');">
                {{ $slot }}
        </div>
        @livewireScripts
    </body>
</html>
