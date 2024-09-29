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
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
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
        <div class="main_column">
            <h1 class="text-center">Add New students</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="main_form">
                <div class="left_col">
                    <img src="images/Hamster-1.jpg" alt="" srcset="">
                </div>
                <div class="middle_col">
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="name">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="{{ old('name', $employee->name ?? '') }}">
                        </div>
                        <div class="father_mother">
                            <div class="fathers_name">
                                <label for="fathers_name">Father's Name:</label>
                                <input type="text" name="fathers_name" value="{{ old('fathers_name', $employee->fathers_name ?? '') }}">
                            </div>
                            <div class="mothers_name">
                                <label for="mothers_name">Mother's Name:</label>
                                <input type="text" name="mothers_name" value="{{ old('mothers_name', $employee->mothers_name ?? '') }}">
                            </div>
                        </div>

                        <div class="institute_name">
                            <label for="polytechnic_name">Polytechnic Name:</label>
                            <input type="text" name="polytechnic_name" value="{{ old('polytechnic_name', $employee->polytechnic_name ?? '') }}">
                        </div>
                        <div class="reg_roll">
                            <div class="roll">
                                <label for="roll">Roll Number:</label>
                                <input type="number" name="roll" value="{{ old('roll', $employee->roll ?? '') }}">
                            </div>
                            <div class="registration">
                                <label for="registration_number">Registration Number:</label>
                                <input type="text" name="registration_number" value="{{ old('registration_number', $employee->registration_number ?? '') }}">
                            </div>
                        </div>
                        <div class="image_active">
                            <div class="images">
                                <label for="image">Image:</label>
                                <input type="file" name="image" accept="image/*">
                                @if(isset($employee) && $employee->image)
                                    <img src="{{ asset('storage/' . $employee->image) }}" width="50" alt="Employee Image" class="mt-2">
                                @endif
                            </div>
                            <div class="status">
                                <label for="status">Status:</label>
                                <select name="status">
                                    <option value="1" {{ old('status', $employee->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $employee->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="button">
                            <button class="button_2" type="submit">Add Students</button>
                            <a class="button_2" href="{{ route('employees.index') }}" class="button">Back</a>
                        </div>
                    </form>
                </div>
                <div class="right_col">
                    <img src="images/hamster-2.png" alt="" srcset="">
                </div>
            </div>
        </div>
    </div>
</body>
</html>


