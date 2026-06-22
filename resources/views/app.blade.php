<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="Mangasa - Système de Gestion EMASE"/>

        <title inertia>{{ config('app.name', 'Mangasa') }}</title>

        <!-- Google font -->
        <link rel="preconnect" href="https://fonts.googleapis.com"/>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"/>

        <!-- Riho Template CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}"/>
        <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}"/>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body>
        @inertia

        <!-- Riho Template JS -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
        <script src="{{ asset('assets/js/sidebar-pin.js') }}"></script>
    </body>
</html>
