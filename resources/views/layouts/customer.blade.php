<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/7f4db50383.js" crossorigin="anonymous"></script>
        {{-- <script src="https://cdn.socket.io/4.3.2/socket.io.min.js" integrity="sha384-+qLXzUHURwIq9SFLC+I/chl4j8KKUi8x+UnjukT2BwLd9HobPBJxL8JjJ2FuW/ts" crossorigin="anonymous"></script> --}}
        <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/jQuery.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            .side-drawer {
                position: fixed;
                left: 0;
                top: 0;
                width: 250px;
                height: 100%;
                background: #fff;
                box-shadow: 2px 0px 5px rgba(0,0,0,0.5);
                transform: translateX(-100%);
                transition: transform 0.3s ease-out;
                z-index: 9999;
            }

            .side-drawer.open {
                transform: translateX(0);
            }

        </style>
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
    <body class="h-screen overflow-hidden font-sans antialiased text-gray-900">

        <div class="absolute top-0 left-0 z-50 flex justify-between w-full p-2 bg-black h-14">
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center justify-center order-1 w-10 h-10 mx-2 text-sm align-middle bg-white rounded-lg invert text-white-500 hover:bg-gray-100 hover:invert-0 focus:outline-none focus:ring-2 focus:ring-gray-200 toggle-button"  aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <a href="{{ route('customer-home') }}" class="order-2"> <x-application-logo class="text-gray-500 w-50 fill-white h-50"  style="filter: invert(100)"></x-application-logo></a>
            <div class="order-3 p-2 invert hover:invert-0 ">
                <i class=" fa-solid fa-bell"></i>
            </div>
        </div>
        <div class="flex items-center justify-center h-full overflow-hidden bg-gray-100 bg-center bg-no-repeat bg-cover sm:justify-center " style="background-image: url('{{ asset('assets/svg/loginBg.svg') }}');">
                {{ $slot }}
        </div>
        <div id="navbar-sticky" class="overflow-hidden side-drawer">
            <!-- Close Button -->
            <button class="float-right w-8 h-8 m-4 text-white bg-black rounded-full close-button">&times;</button>
            <!-- Menu Content -->
            <div class="flex items-center w-full p-4 mt-10 bg-gray-200">
                <img class="mr-4 rounded-full h-14 w-14" src="{{ Auth::user()->profile_photo_path?Auth::user()->profile_photo_path:asset('assets/jpg/user-avatar.jpg') }}" alt="Rider Avatar">
                <div>
                  <div class="font-semibold text-gray-800">{{ Auth::user()->first_name." ".Auth::user()->last_name }}</div>
                  <div class="items-center text-xs">
                        {{ Auth::user()->email }}

                  </div>
                </div>
            </div>
            <nav class="m-4 ">
                <ul class="space-y-4">
                    <li class=""><a href="{{ route('user-profile') }}">Setting</a></li>
                    <li><livewire:customers.components.logout /></li>
                </ul>
            </nav>
        </div>
        @livewireScripts
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleButton = document.querySelector('.toggle-button');
                const sideDrawer = document.getElementById('navbar-sticky');
                const closeButton = sideDrawer.querySelector('.close-button');

                toggleButton.addEventListener('click', function() {
                    sideDrawer.classList.add('open');
                });

                closeButton.addEventListener('click', function() {
                    sideDrawer.classList.remove('open');
                });
            });
        </script>
    </body>
</html>
