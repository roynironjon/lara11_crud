{{-- @extends('layouts.app')

@section('content') --}}
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- <div class="main_column">
    <div class="containerr">
        <div class="main">
            <header class="header">
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Dashboard
                            </a>
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
</div> --}}
{{-- <p>
    <span>
      nironjon roy
    </span>
</p>

@endsection --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="home_main">
        <nav class="navbar navbar-expand-md">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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
        <p class="animation_name">
            <span>
            nironjon roy
            </span>
        </p>
        <div class="main_column">
            <div class="main">
                <div class="left_column">
                    <img src="images/nironjon.jpg" alt="" srcset="">
                </div>
                <div class="right_column">
                    <strong>"শুধু স্বপ্ন দেখাই যথেষ্ট নয়। আমাদের এটাও জানতে হবে যে আমাদের কোথায় এবং কী কী সুযোগ এবং সংস্থান আছে। আবেগ এবং ধৈর্য উভয়ই থাকতে হবে। আপনার সাহস থাকতে হবে এবং আপনার আত্মবিশ্বাস থাকতে হবে। শুধুমাত্র আপনারই সম্ভাবনা আছে উন্নত বাংলাদেশ গড়ার চালিকাশক্তি।"
                    </strong>
                   <p>
                        <span>
                            European IT Solutions & Institute
                        </span>
                   </p>
                </div>
                <div class="button_create_button">
                    <a href="{{ route('employees.index') }}">Create st</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>

