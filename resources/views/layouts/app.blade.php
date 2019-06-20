<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/1e64c547ae.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-grey-light">
    <div id="app">
        <nav class="bg-white">
            <div class="container mx-auto">
                <div class="flex justify-between items-center py-2">
                    <a class="navbar-brand" href="{{ route('projects.index') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="180px">
                    </a>

                    <div>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <a class="no-underline text-xl text-grey" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                    <a class="no-underline text-xl text-grey ml-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            @else
                                <div class="flex items-center">
                                    <span>
                                        <img src="{{ gravater_url(Auth::user()->email) }}"
                                               alt="{{ Auth::user()->name }}"
                                               class="rounded-full w-8 mr-2">
                                    </span>
                                    <span class="text-xl">{{ Auth::user()->name }}</span>

                                    <span>
                                        <a class="ml-3 no-underline text-xl text-red" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </a>
                                    </span>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container mx-auto py-4 section">
            @yield('content')
        </div>
    </div>
</body>
</html>
