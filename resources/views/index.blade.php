<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Vue Laravel SPA') }}</title>

        <!-- Styles -->
        <title>{{ config('app.name') }}</title>

        @vite(['resources/js/app.js'])
        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
    </head>
    <body>
        <div id="app"></div>
        <!-- Scripts -->
        <script src="{{ mix('/js/app.js') }}" defer></script>
    </body>
</html>
