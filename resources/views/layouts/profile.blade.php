<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HRM') }}|{{$title}}</title>

    <!-- Styles -->

    @yield('styles')

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
                        @yield('messages2')
                        
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <div>
                                <b style="text-align: center;">Update Profile</b>
                            </div>
                        </div>
                        <div class="panel-body">

                            <form class="form-inline" action="{{route('employee.profile.update',['id'=>$d->id])}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group col-sm-4">
                                    <label for="fname">Firstname</label>
                                    <input style="width: 250px;" type="text" name="fname" value="{{$d->firstname}}" class="form-control">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="lname">Lastname</label>
                                    <input style="width: 250px;" type="text" name="lname" value="{{$d->lastname}}" class="form-control">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="contact">Contact</label>
                                    @if($d->contact)
                                    <input style="width: 250px;" type="text" name="contact" value="{{$d->contact}}" class="form-control"> @else
                                    <input style="width: 250px;" type="text" name="contact" placeholder="Please enter contact" class="form-control"> @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="password">Password</label>
                                    <input style="width: 250px;" type="password" name="password" value="{{$d->password}}" class="form-control">
                                </div>
                                <div class="form-group col-sm-4" style="margin-top: 20px;padding-left: 80px;">
                                    <button class="btn btn-success center-block" type="submit"> Update</button>

                                </div>
                                <div class="form-group" style="margin-top: 20px;">
                                    <button type="reset" class="btn btn-success center-block"> Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            @endforeach
        </div>

        <!-- Scripts -->
        @yield('scripts')
        @yield('messages')
        
</body>

</html>