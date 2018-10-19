<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.PNG') }}">
    <title>HR|Glowlogix</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{{asset('assets/plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{asset('assets/plugins/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{asset('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="{{asset('assets/plugins/c3-master/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('css/style.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    {{--Calander --}}
    <link href="{{asset('assets/plugins/fullcalendar-3.9.0/fullcalendar.min.css')}}" rel='stylesheet' />
    <link href="{{asset('assets/plugins/fullcalendar-3.9.0/fullcalendar.print.css')}}" rel='stylesheet' media='print' />
    <link href="{{asset('assets/plugins/fullcalendar-3.9.0/scheduler.min.css')}}" rel='stylesheet' />
    <script src="{{asset('assets/plugins/fullcalendar-3.9.0/fullcalendar.min.js')}}"></script>
    <script src="{{asset('assets/plugins/fullcalendar-3.9.0/scheduler.min.js')}}"></script>
    {{--Old--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">

{{--Organisational Structure--}}
    <link rel="icon" href="{{asset('OH/img/logo.png')}}">
    <link rel="stylesheet" href="{{asset('OH/css/jquery.orgchart.css')}}">
    {{--Add ICON--}}
    <style type="text/css">
        .orgchart .second-menu-icon {
            transition: opacity .5s;
            opacity: 0;
            right: -5px;
            top: -5px;
            z-index: 2;
            color: rgba(68, 157, 68, 0.5);
            font-size: 18px;
            position: absolute;
            color: black;
        }
        .orgchart .second-menu-icon:hover { color:black; }
        .orgchart .node:hover .second-menu-icon { opacity: 1; }

    </style>

    {{--END Organisational Structure--}}
</head>