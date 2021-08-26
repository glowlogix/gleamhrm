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

    <!-- Google Font: Source Sans Pro StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/font-googleapis/font.css') }}">

    <!-- Font Awesome Icons StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme  StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min.css') }}">

    <!-- jQuery Script -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
  </head>
  <body>
    
    @yield('content')

    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>
