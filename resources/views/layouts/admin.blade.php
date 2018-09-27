<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>
        @if(!empty($title))
        {{ config('app.name', 'HRM') }}|{{$title}}
        @endif
    </title>
   
    <!-- Styles -->
    <link href="{{asset('css/data.css') }}" rel="stylesheet">
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />--}}

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
    

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>--}}


    <!-- full calendar -->

    <link href='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.print.css' rel='stylesheet' media='print' />

    <link href='https://fullcalendar.io/releases/fullcalendar-scheduler/1.9.4/scheduler.min.css' rel='stylesheet' />

   <script src='https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.js'></script>
    <script src='https://fullcalendar.io/releases/fullcalendar-scheduler/1.9.4/scheduler.min.js'></script>

    <!-- full calendar -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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
                            <a href="{{ route('login') }}">Administrator Login</a>
                        </li>
                        {{--
                        <li>
                            <a href="{{ route('register') }}">Register</a>
                        </li> --}} @else
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
                        <li class="list-group-item" {{ request()->is('admin/dashboard') ? 'id=active1' : ''}}>
                            <a href="{{route('admin.dashboard')}}">Dashboard</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('applicants')}}">Applicants</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('jobs')}}">Jobs</a>
                        </li> {{--
                        <li class="list-group-item">
                            <a href="{{route('applicants')}}">Applicants</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('applicants.hired')}}">Hired Applicants</a>
                        </li> --}} {{--
                        <li class="list-group-item">
                            <a href="{{route('applicant.trashed')}}">Trashed</a>
                        </li> --}}
                        <li class="list-group-item" {{ request()->is('admin/users') ? 'id=active1' : ''}}>
                            <a href="{{route('users')}}">Users</a>
                        </li>
                        <li class="list-group-item" {{ request()->is('admin/upload/docs') ? 'id=active1' : ''}}>
                            <a href="{{ route('documents.upload') }}">Documents</a>
                        </li>
                        <li class="list-group-item" {{ request()->is('admin/employees') ? 'id=active1' : ''}}>
                            <a href="{{route('employees')}}">Employees</a>
                        </li>
                        <li class="list-group-item" >
                            <a href="{{route('attendance')}}" {{ request()->is('admin/attendance') ? 'id=active1' : ''}}>Attendance</a>
                            <ul>
                                <li>
                                    <a href="{{route('timeline')}}" {{ request()->is('admin/leave') ? 'id=active1' : ''}}>Timeline</a>
                                </li>
                                <li>
                                    <a href="{{route('leaves')}}" {{ request()->is('admin/leave') ? 'id=active1' : ''}}>Leaves</a>
                                </li>
                                <li>
                                    <a href="{{route('salary.show')}}" {{ request()->is('admin/salary') ? 'id=active1' : '' }} >Salary</a>
                                </li>
                                <?php
                                $month = date('m');
                                $monthee= "2018_".$month;
                                ?>
                                <li>
                                    <a href="{{route('attendance.sheet',['id'=>$monthee])}}" {{ request()->is('admin/sheet') ? 'id=active1' : ''}}>Sheet</a>
                                </li>

                            </ul>

                        </li>

                    </ul>
                </div>
                <div class="col-lg-9">
                    @include('admin.includes.errors') @if(Session::has('success'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> {{Session::get('success')}}
                    </div>
                    @endif
                    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> {{Session::get('error')}}
                    </div>
                    @endif @yield('content')
                </div>

            </div>
        </div>


    </div>

    <!-- Scripts -->
    {{--
    <script src="{{ asset('js/app.js') }}"></script> --}}
    @yield('scripts')
    @stack('scripts')

</body>

</html>
