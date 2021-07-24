<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>galeria</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <script src="{{ asset('js/uikit.js') }}" defer></script>
        <script src="{{ asset('js/uikit-icons.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/uikit.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    </head>
    <body>
        <div class="uk-container uk-height-viewport uk-width-viewport gradient-background uk-flex uk-flex-center uk-flex-middle uk-inline">
            @include('components.selector')
            @yield('content')
        </div>
    </body>
</html>
