<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.PNG')}}">
    <title>HRM|Glowlogix</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}"  rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('css/colors/blue.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle> </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background-image:url({{ asset('assets/images/background/login-register.jpg') }});">
        @yield('content')
    </div>
</section>

<script src="{{ mix('/js/app.js') }}"></script>
{{--<script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>--}}
{{--<!-- Bootstrap tether Core JavaScript -->--}}
{{--<script src="{{ asset('assets/plugins/popper/popper.min.js')}}"></script>--}}
{{--<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>--}}

<!-- slimscrollbar scrollbar JavaScript -->
{{--<script  src="{{ asset('js/jquery.slimscroll.js') }}"></script>--}}
<!--Wave Effects -->
{{--<script src="{{ asset('js/waves.js') }}"></script>--}}
<!--Menu sidebar -->
{{--<script src="{{ asset('js/sidebarmenu.js')}}"></script>--}}
<!--stickey kit -->
{{--<script  src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>--}}
{{--<script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>--}}
<!--Custom JavaScript -->
{{--<script src="{{ asset('js/custom.min.js') }}"></script>--}}
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
{{--<script src="{{ asset('assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>--}}
{{--<script>--}}
{{--    $(document).ready(function(){--}}
{{--        function store(name, val) {--}}
{{--            if (typeof (Storage) !== "undefined") {--}}
{{--                localStorage.setItem(name, val);--}}
{{--            } else {--}}
{{--                window.alert('Please use a modern browser to properly view this template!');--}}
{{--            }--}}
{{--        }--}}
{{--        $("*[data-theme]").click(function(e){--}}
{{--            e.preventDefault();--}}
{{--            var currentStyle = $(this).attr('data-theme');--}}
{{--            store('theme', currentStyle);--}}
{{--            $('#theme').attr({href: 'css/colors/'+currentStyle+'.css'})--}}
{{--        });--}}

{{--        // var currentTheme =  localStorage.getItem('theme');--}}
{{--        // if(currentTheme)--}}
{{--        // {--}}
{{--        //     $('#theme').attr({href: 'css/colors/'+currentTheme+'.css'});--}}
{{--        // }--}}
{{--        // // color selector--}}
{{--        // $('#themecolors').on('click', 'a', function(){--}}
{{--        //     $('#themecolors li a').removeClass('working');--}}
{{--        //     $(this).addClass('working')--}}
{{--        // });--}}
{{--    });--}}

{{--</script>--}}
</body>


