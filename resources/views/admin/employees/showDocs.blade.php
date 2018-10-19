<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HRM|{{ $title}}</title>

    <!-- Styles -->
    <link href="{{ asset('css/data.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}"> @yield('styles')

</head>

<body>
    <div id="app">
        @foreach($data as $d)

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

                @endforeach
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

                    </ul>
                </div>
                <div class="col-lg-9">
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> {{Session::get('success')}}
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <div>
                                <b style="text-align: center;">All Documents</b>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Application Name</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>

                                @if(count($files) > 0) @foreach($files as $file)

                                <tbody>
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset('storage/public/'.$file->filename)}}">{{ $file->filename }}</a>
                                        </td>
                                        <td>
                                            Enable
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach @else
                                <p class="text-center">No Documnets Found</p>
                                @endif
                            </table>
                        </div>
                    </div>


                <!-- Scripts -->
                <script src="{{ asset('js/app.js') }}"></script>
                <script src="{{ asset('js/toastr.min.js')}}"></script>
                <script>
                    @if(Session::has('success'))
                    toastr.success("{{Session::get('success')}}")
                    @endif
                    @if(Session::has('info'))
                    toastr.info("{{Session::get('info')}}")
                    @endif
                </script>
            </div>
        </div>
        </div>
    </div>
    @yield('scripts')

</body>

</html>
=======
@extends('layouts.docs') @section('content') @if(count($files) > 0) @foreach($files as $file)
<thead>
    <tr>
        <th>Document Name</th>
        <th>Document Url</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>
            <p>{{ $file->name }}</p>
        </td>
        <td>
            <a target="_blank" href="{{asset('storage/public/'.$file->url)}}">{{ $file->url }}</a>
        </td>
    </tr>
</tbody>
@endforeach @else
<p class="text-center">No Documnets Found</p>
@endif @stop
