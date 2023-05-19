<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel_Vue_Chat</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
</head>

<body @if(Request::route()->getName() === 'login') class="guest-container-login"
    @elseif(Request::route()->getName() === 'register') class="guest-container-register"
    @elseif(Request::is('/')) class="guest-container-welcome"
    @endif>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm guest-container-nav">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav me-auto">
                        <h4 id="current-time" class="m-0"></h4>
                    </ul>
                    @endauth
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-white guest-button" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white guest-button" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown d-flex align-items-center justify-content-center">
                            <a class="nav-link text-white" href="#">
                                {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                            </a>
                            <img src="{{ asset('images/users/'. Auth::user()->image) }}" id="navbarDropdown" alt="Profile Image" class="navbar-profile-image dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <div class="d-flex">
                                    <label class="form-check-label dropdown-item" for="theme">Light Mode <i class="bi bi-sun"></i></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="theme" onclick="changeTheme()">
                                    </div>
                                </div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }} <i class="bi bi-door-closed-fill"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main @if(Request::route()->getName() !== 'register' || Request::route()->getName() !== '/' ) class="py-4" @endif>
            @yield('content')
        </main>
    </div>
    <script>
        "use strict";

        const currentTime = () => {
            const el = document.querySelector("#current-time");

            let date = new Date();
            let hh = date.getHours();
            let mm = date.getMinutes();
            let ss = date.getSeconds();

            hh = hh < 10 ? `0${hh}` : hh;
            mm = mm < 10 ? `0${mm}` : mm;
            ss = ss < 10 ? `0${ss}` : ss;

            let time = `${hh}:${mm}:${ss}`;

            el.innerText = time;
        };

        currentTime();
        setInterval(currentTime, 1000);

        function changeTheme() {
            const theme = document.querySelector("#theme");
            const body = document.querySelector("body");
            const nav = document.querySelector(".navbar");
            if (theme.checked) {
                // Attiva il tema chiaro
                body.classList.add("white-theme");
                nav.classList.add("new-nav");
            } else {
                // Attiva il tema scuro
                body.classList.remove("white-theme");
                nav.classList.remove("new-nav");
            }
        }
    </script>
</body>

</html>