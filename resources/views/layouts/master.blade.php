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

    <!-- Themify Icons StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/themify-icons/themify-icons.css') }}">

    <!-- Material Design Icons StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/material-icons/css/materialdesignicons.min.css') }}">

    <!-- IonIcons StyleSheet -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme  StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min.css') }}">

    <!-- Overlay Scrollbar StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- DataTables StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- jQuery Script -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Chart Script -->
    <script src="{{ asset('assets/backend/plugins/Chart.js/Chart.min.js') }}"></script>
    
    <!-- jquery-validation -->
    <script src="{{ asset('assets/backend/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-validation/additional-methods.min.js') }}"></script>
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

    <!-- Bootstrap Script -->
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AdminLTE Script -->
    <script src="{{ asset('assets/backend/dist/js/adminlte.js') }}"></script>

    <!-- Overlay Scrollbar Script -->
    <script src="{{ asset('assets/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- DataTables  & Plugins Script -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  </body>
</html>
