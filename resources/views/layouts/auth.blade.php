<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($platform->logo))
      <link rel="icon" type="image/png" sizes="16x16" href="{{asset($platform->logo)}}">
    @else
      <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/company_logo.png')}}">
    @endif
    <title>HRM | @if(isset($platform->name)) {{$platform->name}} @else Company Name @endif</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('assets/backend/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-validation/additional-methods.min.js') }}"></script>
  </head>
  <body>
    <div class="row">
      <img class="d-none d-lg-block d-md-block d-sm-none col-md-8" src="{{ asset('assets/images/login-v2.svg') }}" style="max-height: 600px;">
      <div class="d-none d-lg-block d-md-block d-sm-none col-md-4 mt-auto mb-auto">
        @yield('content')
      </div>
    </div>
    <div class="card-primary card-outline d-lg-none d-md-none d-sm-block mx-auto">
        @yield('content')
    </div>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/backend/dist/js/adminlte.min.js') }}"></script>
  </body>
</html>