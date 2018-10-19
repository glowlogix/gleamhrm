@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Dashboad</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-md-8 col-xlg-9">
            <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-lg align-self-center round-info"><i class="ti-user"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">56</h3>
                                    <h5 class="text-muted m-b-0">Active Employees</h5></div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-lg align-self-center round-danger"><i class="ti-server"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-lgiht">70</h3>
                                    <h5 class="text-muted m-b-0">Payroll Processed</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-laptop"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-lgiht">100</h3>
                                    <h5 class="text-muted m-b-0">Hiring Applicants</h5></div>
                            </div>
                    </div>
                </div>
                </div>
            </div>
                <!-- Column -->
            <!-- Row -->
            <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <h4 class="card-title">Attendence</h4>
                            </div>
                            <div class="attendance" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <h4 class="card-title">Employee Chart</h4>
                            </div>
                            <div class="Employee-Count" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                {{--<div class="col-lg-6 col-md-6">--}}
                    {{--<div class="card">--}}
                        {{--<div class="card-body">--}}

                            {{--Hello--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                <!-- Column -->
                <div class="col-lg-6 col-md-6">
                    {{--<div class="card card-inverse card-success">--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="d-flex">--}}
                                {{--<div class="m-r-20 align-self-center">--}}
                                    {{--<h1 class="text-white"><i class="icon-cloud-download"></i></h1></div>--}}
                                {{--<div>--}}
                                    {{--<h3 class="card-title">Download count</h3>--}}
                                    {{--<h6 class="card-subtitle">March  2017</h6> </div>--}}
                            {{--</div>--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-4 align-self-center">--}}
                                    {{--<h2 class="font-light text-white">35487</h2>--}}
                                {{--</div>--}}
                                {{--<div class="col-8 p-t-10 p-b-20 text-right">--}}
                                    {{--<div class="spark-count" style="height:65px"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card">--}}
                        {{--<img class="" src="../assets/images/background/weatherbg.jpg" alt="Card image cap">--}}
                        {{--<div class="card-img-overlay" style="height:110px;">--}}
                            {{--<h3 class="card-title text-white m-b-0 dl">New Delhi</h3>--}}
                            {{--<small class="card-text text-white font-light">Sunday 15 march</small>--}}
                        {{--</div>--}}
                        {{--<div class="card-body weather-small">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-8 b-r align-self-center">--}}
                                    {{--<div class="d-flex">--}}
                                        {{--<div class="display-6 text-info"><i class="wi wi-day-rain-wind"></i></div>--}}
                                        {{--<div class="m-l-20">--}}
                                            {{--<h1 class="font-light text-info m-b-0">32<sup>0</sup></h1>--}}
                                            {{--<small>Sunny Rainy day</small>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-center">--}}
                                    {{--<h1 class="font-light m-b-0">25<sup>0</sup></h1>--}}
                                    {{--<small>Tonight</small>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                <!-- Column -->

                <!-- Column -->
            </div>
        </div>
        <div class="col-md-4 col-xlg-3">
            <!-- Column -->
            <div class="card earning-widget">
                <div class="card-header">
                    <div class="card-actions">
                        <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                        <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                        <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                    </div>
                    <h4 class="card-title m-b-0">Recently Added Employee</h4>
                </div>
                <div class="card-body b-t collapse show">
                    <table class="table v-middle no-border">
                        <tbody>
                        <tr>
                            <td style="width:40px"><img src="../assets/images/users/1.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Andrew</td>
                            <td align="right"><span class="label label-light-danger">2 Months</span></td>
                        </tr>
                        <tr>
                            <td style="width:40px"><img src="../assets/images/users/1.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Andrew</td>
                            <td align="right"><span class="label label-light-danger">2 Months</span></td>
                        </tr>
                        <tr>
                            <td style="width:40px"><img src="../assets/images/users/1.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Andrew</td>
                            <td align="right"><span class="label label-light-danger">2 Months</span></td>
                        </tr>
                        <tr>
                            <td style="width:40px"><img src="../assets/images/users/1.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Andrew</td>
                            <td align="right"><span class="label label-light-danger">2 Months</span></td>
                        </tr>
                        <tr>
                            <td><img src="../assets/images/users/2.jpg" width="50" class="img-circle" alt="logo"></td>
                            <td>Kristeen</td>
                            <td align="right"><span class="label label-light-danger">1 Months</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Column -->
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                        <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                        <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                    </div>
                    <h4 class="card-title m-b-0">Gender Ratio</h4>
                </div>
                <div class="card-body collapse show b-t">
                    <div id="visitors" style="height:260px; width:100%;"></div>
                    <div>
                        <hr class="m-t-0 m-b-0">
                    </div>
                    <div class="card-body text-center ">
                        <ul class="list-inline m-b-0">
                            <li>
                                <h6 class="text-muted text-info"><i class="fa fa-circle font-10 m-r-10 "></i>Male</h6> </li>
                            <li>
                                <h6 class="text-muted  text-success"><i class="fa fa-circle font-10 m-r-10"></i>Female</h6> </li>
                        </ul>
                </div>
                </div>
            </div>

        </div>
    </div>

        @push('scripts')
        <!--stickey kit -->
        <script src="{{asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
        <script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
        <!--Custom JavaScript -->
        <script src="{{asset('js/custom.min.js')}}"></script>
        <!-- ============================================================== -->
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <!-- chartist chart -->
        <script src="{{asset('assets/plugins/chartist-js/dist/chartist.min.js')}}"></script>
        <script src="{{asset('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}"></script>
        <!--c3 JavaScript -->
        <script src="{{asset('assets/plugins/d3/d3.min.js')}}"></script>
        <script src="{{asset('assets/plugins/c3-master/c3.min.js')}}"></script>
        <!-- Chart JS -->
        <script src="{{asset('js/dashboard6.js')}}"></script>
        {{--///Gender Ratio Script///--}}
        <script>
            var chart = c3.generate({
                bindto: '#visitors',
                data: {
                    columns: [
                        ['Male', 30],
                        ['Female', 10],

                    ],

                    type : 'donut',
                    onclick: function (d, i) { console.log("onclick", d, i); },
                    onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                    onmouseout: function (d, i) { console.log("onmouseout", d, i); }
                },
                donut: {
                    label: {
                        show: false
                    },
                    title: "Gender Ratio",
                    width:20,
                },

                legend: {
                    hide: true
                    //or hide: 'data1'
                    //or hide: ['data1', 'data2']
                },
                color: {
                    pattern: ['#1e88e5','#26c6da' ]
                }
            });

        </script>

        {{--//Attendence--}}
        <script>

            $(function () {
                "use strict";
                // ==============================================================
                // Total revenue chart
                // ==============================================================
                new Chartist.Bar('.attendance', {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept','Oct','Nov','Dec']
                    , series: [
                        [1,10 , 20, 30, 40, 50, 60, 70, 80,90,95,100]
                    ]
                }, {
                    high: 100
                    , low: 1
                    , fullWidth: true
                    , plugins: [
                        Chartist.plugins.tooltip()]
                    , stackBars: true

                    , axisX: {
                        showGrid: false
                    }
                    , axisY: {
                        labelInterpolationFnc: function (value) {
                            return (value) + '%';
                        }
                    }
                }).on('draw', function (data) {
                    if (data.type === 'bar') {
                        data.element.attr({
                            style: 'stroke-width: 10px'
                        });
                    }
                });
                // ==============================================================
                // sales difference
                // ==============================================================
                new Chartist.Pie('.ct-chart', {
                    series: [25, 10]
                }, {
                    donut: true
                    , donutWidth: 20
                    , startAngle: 0
                    , showLabel: false
                });
                // ==============================================================
                // world map
                // ==============================================================
                jQuery('#visitfromworld').vectorMap({
                    map: 'world_mill_en'
                    , backgroundColor: '#fff'
                    , borderColor: '#ccc'
                    , borderOpacity: 0.9
                    , borderWidth: 1
                    , zoomOnScroll : false
                    , color: '#ddd'
                    , regionStyle: {
                        initial: {
                            fill: '#fff'
                        }
                    }
                    , markerStyle: {
                        initial: {
                            r: 8
                            , 'fill': '#26c6da'
                            , 'fill-opacity': 1
                            , 'stroke': '#000'
                            , 'stroke-width': 0
                            , 'stroke-opacity': 1
                        }
                        , }
                    , enableZoom: true
                    , hoverColor: '#79e580'
                    , markers: [{
                        latLng: [21.00, 78.00]
                        , name: 'India : 9347'
                        , style: {fill: '#26c6da'}
                    },
                        {
                            latLng : [-33.00, 151.00],
                            name : 'Australia : 250'
                            , style: {fill: '#02b0c3'}
                        },
                        {
                            latLng : [36.77, -119.41],
                            name : 'USA : 250'
                            , style: {fill: '#11a0f8'}
                        },
                        {
                            latLng : [55.37, -3.41],
                            name : 'UK   : 250'
                            , style: {fill: '#745af2'}
                        },
                        {
                            latLng : [25.20, 55.27],
                            name : 'UAE : 250'
                            , style: {fill: '#ffbc34'}
                        }]
                    , hoverOpacity: null
                    , normalizeFunction: 'linear'
                    , scaleColors: ['#fff', '#ccc']
                    , selectedColor: '#c9dfaf'
                    , selectedRegions: []
                    , showTooltip: true
                    , onRegionClick: function (element, code, region) {
                        var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
                        alert(message);
                    }
                });
                $('#calendar').fullCalendar('option', 'height', 650);
                // ==============================================================
                // sparkline chart
                // ==============================================================
                var sparklineLogin = function() {


                    $("#spark1").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
                        type: 'line',
                        width: '100%',
                        height: '50',
                        lineColor: '#26c6da',
                        fillColor: '#26c6da',
                        maxSpotColor: '#26c6da',
                        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                        highlightSpotColor: '#26c6da'
                    });
                    $("#spark2").sparkline([0, 2, 8, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
                        type: 'line',
                        width: '100%',
                        height: '50',
                        lineColor: '#009efb',
                        fillColor: '#009efb',
                        minSpotColor: '#009efb',
                        maxSpotColor: '#009efb',
                        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                        highlightSpotColor: '#009efb'
                    });
                    $("#spark3").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
                        type: 'line',
                        width: '100%',
                        height: '50',
                        lineColor: '#7460ee',
                        fillColor: '#7460ee',
                        maxSpotColor: '#7460ee',
                        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                        highlightSpotColor: '#7460ee'
                    });
                    $("#spark4").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
                        type: 'line',
                        width: '100%',
                        height: '50',
                        lineColor: '#fff',
                        fillColor: '#7460ee',
                        maxSpotColor: '#7460ee',
                        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                        highlightSpotColor: '#7460ee'
                    });
                    $("#spark5").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
                        type: 'line',
                        width: '100%',
                        height: '50',
                        lineColor: '#fff',
                        fillColor: '#009efb',
                        maxSpotColor: '#009efb',
                        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                        highlightSpotColor: '#009efb'
                    });
                    $("#spark6").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
                        type: 'line',
                        width: '100%',
                        height: '50',
                        lineColor: '#fff',
                        fillColor: '#26c6da',
                        maxSpotColor: '#26c6da',
                        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                        highlightSpotColor: '#26c6da'
                    });
                    $("#spark7").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
                        type: 'line',
                        width: '100%',
                        height: '50',
                        lineColor: '#fff',
                        fillColor: '#ffbc34',
                        maxSpotColor: '#ffbc34',
                        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                        highlightSpotColor: '#ffbc34'
                    });
                    $('#spark8').sparkline([4, 5, 0, 10, 9, 12, 4, 9], {
                        type: 'bar',
                        width: '100%',
                        height: '70',
                        barWidth: '8',
                        resize: true,
                        barSpacing: '5',
                        barColor: '#26c6da'
                    });
                    $('#spark9').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                        type: 'bar',
                        width: '100%',
                        height: '70',
                        barWidth: '8',
                        resize: true,
                        barSpacing: '5',
                        barColor: '#7460ee'
                    });
                    $('#spark10').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                        type: 'bar',
                        width: '100%',
                        height: '70',
                        barWidth: '8',
                        resize: true,
                        barSpacing: '5',
                        barColor: '#03a9f3'
                    });
                    $('#spark11').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                        type: 'bar',
                        width: '100%',
                        height: '70',
                        barWidth: '8',
                        resize: true,
                        barSpacing: '5',
                        barColor: '#f62d51'
                    });
                    $('#sparklinedash').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                        type: 'bar',
                        height: '50',
                        barWidth: '2',
                        resize: true,
                        barSpacing: '5',
                        barColor: '#26c6da'
                    });
                    $('#sparklinedash2').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                        type: 'bar',
                        height: '50',
                        barWidth: '2',
                        resize: true,
                        barSpacing: '5',
                        barColor: '#7460ee'
                    });
                    $('#sparklinedash3').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                        type: 'bar',
                        height: '50',
                        barWidth: '2',
                        resize: true,
                        barSpacing: '5',
                        barColor: '#03a9f3'
                    });
                    $('#sparklinedash4').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                        type: 'bar',
                        height: '50',
                        barWidth: '2',
                        resize: true,
                        barSpacing: '5',
                        barColor: '#f62d51'
                    });

                };
                var sparkResize;

                $(window).resize(function(e) {
                    clearTimeout(sparkResize);
                    sparkResize = setTimeout(sparklineLogin, 500);
                });
                sparklineLogin();
            });
        </script>
{{--Employee Chart--}}
        <script>

            $(function () {
                "use strict";
                // ==============================================================
                // Total revenue chart
                // ==============================================================
                new Chartist.Bar('.Employee-Count', {
                    labels: ['Project Co-originator', 'Web Developer','Junior WebDeveloper','Front End Developer',
                        'Sales Officers','Sales Executives','Web Designer Lead']
                    , series: [
                        [1, 10,20,50,10,6,70]
                    ]
                }, {
                    high: 100
                    , low: 1
                    , fullWidth: true
                    , plugins: [
                        Chartist.plugins.tooltip()]
                    , stackBars: true

                    , axisX: {
                        showGrid: false
                    }
                    , axisY: {
                        labelInterpolationFnc: function (value) {
                            return (value);
                        }
                    }
                }).on('draw', function (data) {
                    if (data.type === 'bar') {
                        data.element.attr({
                            style: 'stroke-width: 10px',

                        });
                    }
                });
            });

        </script>


        <!-- ============================================================== -->
        <!-- Style switcher -->
        <!-- ============================================================== -->
        <script src="{{asset('../assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
    @endpush
@endsection
