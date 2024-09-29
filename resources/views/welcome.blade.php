<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel-11</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>
    <body>
        <div class="main_column">
            <div class="containerr">
                <div class="main">
                    <header class="header">
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    {{-- <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a> --}}
                                @else
                                    <a class="button-17"  href="{{ route('login') }}" >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a class="button-17" href="{{ route('register') }}" >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                        <h1>Nironjon roy</h1>
                    </header>
                    <div class="tree">
                        <canvas role="img" aria-label="A tree growing until it bears fruit, dropping its fruit, shrinking, and repeating the cycle"></canvas>
                    </div>
                </div>
                    <div id="stars"></div>
                    <div id="sun"></div>
                    <div id="earthOrbit">
                      <img src="http://www.pngall.com/wp-content/uploads/2016/06/Earth-Free-Download-PNG-180x180.png" alt="earth" height="80" width="80" id="earth">
                      <div id="moonOrbit">
                        <div id="moon"></div>
                      </div>

                    </div>

            </div>
        </div>
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>
