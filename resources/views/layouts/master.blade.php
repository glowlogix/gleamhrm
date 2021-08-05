<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.PNG')}}">
    <title>HR | Glowlogix</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/font-googleapis/font.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/themify-icons/themify-icons.css') }}">
    <!-- Material Design Icons -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/material-icons/css/materialdesignicons.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Navbar Start -->
      @include('layouts.partials.navbar')
      <!-- Navbar End -->

      <!-- Left Sidebar Container Start -->
      @include('layouts.partials.left-sidebar')
      <!-- Left Sidebar Container End -->

      <!-- Page Content Start -->
      <div class="content-wrapper">
        @yield('content')
      </div>
      <!-- Page Content End -->

      <!-- Right Sidebar Container Start -->
      @include('layouts.partials.right-sidebar')
      <!-- Right Sidebar Container End -->

      <!-- Main Footer Start -->
      @include('layouts.partials.footer')
      <!-- Main Footer End -->
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('assets/backend/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/backend/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('assets/backend/dist/js/pages/dashboard3.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  </body>
</html>
