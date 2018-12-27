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
        <div class="col-md-12 col-xlg-9">
            <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-lg align-self-center round-info"><i class="ti-user"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">{{count($totalemployees)}}</h3>
                                    <h5 class="text-muted m-b-0">Employees</h5></div>
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
                                    <h3 class="m-b-0 font-light">0</h3>
                                    <h5 class="text-muted m-b-0">Payroll&nbspProc</h5></div>
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
                                    <h3 class="m-b-0 font-light">{{$applicants}}</h3>
                                    <h5 class="text-muted m-b-0">Applicants</h5></div>
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
                    <div class="card card-view">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <h4 class="card-title">Employee Chart</h4>
                            </div>
                            <div class="Employee-Count" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                   <div class="col-lg-6 col-md-6">
                </div>
                <!-- Column -->

                <!-- Column -->
            </div>
        </div>
        <div class="col-md-6 col-xlg-3">
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
                        @foreach($employee as $employees)
                                <tr>
                                    <td style="width:40px"><img src="{{asset($employees->picture)}}" onerror="this.src='{{asset('assets/images/default.png')}}';" width="55" height="60" class="img-circle" alt="picture"></td>
                                    <td>{{$employees->firstname}}</td>
                                    <td align="right"><span class="label label-light-danger">{{ $diff = Carbon\Carbon::parse($employees->joining_date)->subMonth()->diffForHumans()}}</span></td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-4">
        <div class="card earning-widget">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                    <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                </div>
                <h4 class="card-title m-b-0">Gender Ratio</h4>
            </div>
            <div class="card-body collapse show b-t">
                <div id="visitors" ></div>
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
                        ['Male', {!! $male !!}],
                        ['Female', {!! $female !!}],

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
                    labels: {!! $chartMonths !!}
                    , series: [
                        {!! $averageAttendance !!}
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
                    labels: [{!! $DesignationName !!}]
                    , series: [
                        [{!! $designationSeries !!}]
                    ]
                }, {
                    high: {!! count($totalemployees) !!}
                    , low: 1
                    , fullWidth: true,
                    fullHeight:true
                    , plugins: [
                        Chartist.plugins.tooltip()]
                    , stackBars: true
                    , axisX: {
                        offset: 60,
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
    @endpush
@endsection
