@extends('layouts.attendance')
@section('Heading')
    <h3 class="text-themecolor">All Attendance</h3>
@stop
@section('content') @foreach($data as $d)


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
                @if (\Session::has('emp_auth'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        {{ $d->firstname }}
                        <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('employee.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('employee.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{route('employee.profile')}}">Update Profile</a>

                </li>
                <li class="list-group-item">
                    <a href="{{route('documents.list')}}">Document links</a>

                </li>
                <li class="list-group-item">
                    <a href="{{route('employee.attendance')}}">Attendance</a>
                </li>
            </ul>
        </div>
        <div class="col-lg-9">

            @if(Session::has('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> {{Session::get('success')}}
            </div>
            @endif

            <div class="panel panel-default" id="calendar">
                <div class="panel-heading text-center">
                    <div>
                        <b style="text-align: center;">Attendance</b>
                    </div>
                </div>
                <div class="panel-body">
                    {!! $calendar->calendar() !!} {!! $calendar->script() !!}
                </div>
            </div>
            
        </div>
    </div>
</div>

@endforeach @endsection
