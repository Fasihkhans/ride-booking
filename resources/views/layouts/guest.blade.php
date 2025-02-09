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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
        <!-- Google tag (gtag.js) -->

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-113HWQKT6N"></script>

        <script>

        window.dataLayer = window.dataLayer || [];

        function gtag(){dataLayer.push(arguments);}

        gtag('js', new Date());



        gtag('config', 'G-113HWQKT6N');

        </script>
        <!-- Scripts -->
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-start min-h-screen pt-6 bg-gray-100 bg-center bg-no-repeat bg-cover sm:justify-center sm:pt-0 " style="background-image: url('{{ asset('assets/svg/loginBg.svg') }}');">

            <div class="w-full px-6 py-8 m-6 overflow-hidden bg-white shadow-md sm:max-w-xs  sm:rounded-[20px]">
                {{ $slot }}
            </div>
            <div class="inline-flex items-center w-full m-6 sm:max-w-xs sm:justify-center">
                <a href="/" wire:navigate>
                    <x-application-logo class="text-gray-500 w-50 fill-white h-50"  style="filter: invert(100)"/>
                </a>
            </div>
        </div>
    </body>
</html>
