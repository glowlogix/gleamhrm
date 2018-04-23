<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{asset('css/data.css') }}" rel="stylesheet">
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
    @yield('styles')
    @yield('scripts2')
    
</head>

<body>
    <div id="app">

        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'HRM') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                        <li>
                            <a href="{{ route('employee.login') }}">Employee Login</a>
                        </li>

                        <li>
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">Register</a>
                        </li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                <li>
                                    <a href="{{ route('documents.upload') }}">Upload Documents</a>

                                </li>

                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{route('category.create')}}">Create New category</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('categories')}}">Categories</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('job.create')}}">Create new Job</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('jobs')}}">Jobs</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('applicants')}}">Applicants</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('applicants.hired')}}">Hired Applicants</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('applicant.trashed')}}">Trashed</a>
                        </li>

                        <li class="list-group-item">
                            <a href="{{route('users')}}">Users (administrator)</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('employees')}}">Employees</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('attendance')}}">Attendance</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('leaves')}}">Leaves</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9">
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> {{Session::get('success')}}
                    </div>
                    @endif @include('admin.includes.errors') 
                    
                    @yield('content')
                </div>

            </div>
        </div>


    </div>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    
    <script src="{{ asset('js/toastr.min.js')}}"></script>
    <script>
        @if(Session::has('success'))
        toastr.success("{{Session::get('success')}}")
        @endif
        @if(Session::has('info'))
        toastr.info("{{Session::get('info')}}")
        @endif
    </script>
    @yield('scripts')

</body>

</html>
