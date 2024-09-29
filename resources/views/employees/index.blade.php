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
            <div class="main_students_table">
                <div class="main_container">
                    <div class="heading">
                        <h2 class="text-center">Students List</h2>
                    </div>
                   <div class="stu_list_left_column">
                        <div class="button_heading">
                            <a class="button" href="{{ route('employees.create') }}" class="button">Add New students</a>
                            <a class="button" href="{{ route('home') }}" class="button">Back</a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Polytechnic Name</th>
                                    <th>Father's Name</th>
                                    <th>Mother's Name</th>
                                    <th>Roll</th>
                                    <th>Registration Number</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->polytechnic_name }}</td>
                                    <td>{{ $employee->fathers_name }}</td>
                                    <td>{{ $employee->mothers_name }}</td>
                                    <td>{{ $employee->roll }}</td>
                                    <td>{{ $employee->registration_number }}</td>
                                    <td>
                                        @if(isset($employee->image))
                                            <img src="{{ asset('storage/' . $employee->image) }}" width="50" alt="Employee Image">
                                        @endif

                                    </td>
                                    <td>{{ $employee->status ? 'Active' : 'Inactive' }}</td>
                                    <td class="main_edit_delete_button">
                                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                   </div>
                </div>
                <div class="stu_list_right_column">
                    <img src="images/hamster-2.png" alt="" srcset="">
               </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>


