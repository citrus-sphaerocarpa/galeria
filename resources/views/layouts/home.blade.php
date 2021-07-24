<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'galeria') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/uikit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div>
        <div id="app">

            <!-- Navbar -->
            <div uk-sticky="sel-target: .uk-navbar-container">  
                <nav class="uk-navbar-container uk-sticky" style="background-color: #fff;">
                    <div class="uk-navbar">
                        <div class="uk-navbar-left">
                            <div class="uk-navbar-item">
                                @yield('uk-navbar-left')
                            </div>
                        </div>

                        <div class="uk-navbar-center">
                            @yield('uk-navbar-center-title')
                        </div>

                        <div class="uk-navbar-right">
                            <div class="uk-navbar-item">
                                <ul class="uk-grid-small uk-grid" uk-grid="">
                                    <li class="uk-first-column">
                                        <a href="#offcanvas" class="uk-link-reset" uk-icon="icon: menu; ratio: 1.5" uk-toggle></a>

                                        <!-- Offcanvas -->
                                        <div id="offcanvas" uk-offcanvas="flip:true">
                                            <div class="uk-offcanvas-bar uk-flex uk-flex-column" class="gradient-background">

                                                <!-- Language Selector -->
                                                @include('components.selector')

                                                <ul class="uk-nav uk-nav-primary uk-nav-center uk-margin-auto-vertical">

                                                    <!-- Home Link -->
                                                    <h2 class="uk-h1">
                                                        <a class="uk-link-reset uk-link-heading logo" href="/home">galeria</a>
                                                    </h2>

                                                    <!-- Search Form -->
                                                    <form class="uk-search uk-search-default" action="/search" method="get" id="searchForm">
                                                        @csrf
                                                        <button class="uk-search-icon-flip" id="submitKeywords" uk-search-icon></button>
                                                        <input class="uk-search-input" type="search" id="keywords" name="keywords" value="{{ old('keywords') }}" placeholder="{{ __('Search')}}">
                                                    </form>
                                                    <div class="uk-margin-small-top">
                                                        @error('keywords')
                                                            <span class="uk-form-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror                
                                                    </div>

                                                    <!-- User Links -->
                                                    <ul class="uk-list uk-list-divider uk-text-left uk-margin-top">
                                                        @guest
                                                            @if (Route::has('login'))
                                                            <li><a href="{{ route('login') }}"><span class="uk-margin-small-right"></span>{{ __('Log in') }}</a></li>
                                                            @endif

                                                            @if (Route::has('register'))
                                                            <li><a href="{{ route('register') }}"><span class="uk-margin-small-right"></span>{{ __('Sign up') }}</a></li>
                                                            @endif
                                                        @else
                                                            <li><a href="/profile/{{ auth()->user()->username }}"><span class="uk-margin-small-right"></span>{{ __('My account') }}</a></li>
                                                            <li><a href="/settings"><span class="uk-margin-small-right"></span>{{ __('Settings') }}</a></li>
                                                            <li>
                                                                <a href="{{ route('logout') }}"
                                                                    onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                                    <span class="uk-margin-small-right"></span>{{ __('Log out') }}
                                                                </a>

                                                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                                                    @csrf
                                                                </form>
                                                            </li>
                                                        @endguest
                                                    </ul>

                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div> 

            <!-- Main -->
            <div class="home-background">
                @yield('content')  
            </div>

            <!-- Post Bar -->
            @yield('uk-navbar-bottom')
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ asset('js/uikit.js') }}" defer></script>
    <script src="{{ asset('js/uikit-icons.js') }}" defer></script>
</body>
</html>
