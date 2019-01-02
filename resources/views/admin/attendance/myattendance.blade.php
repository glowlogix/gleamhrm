@extends('layouts.admin')
@section('Heading')
    {{--<button type="button"  onclick="window.location.href='{{route('attendance.create')}}'" class="btn btn-info btn-rounded m-t-10 float-right"><span class="fas fa-plus" ></span> Add Attendance</button>--}}
    <h3 class="text-themecolor">My Attendance</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Attendance</li>
        <li class="breadcrumb-item active">My Attendance</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 col-xlg-12">
            <!-- Row -->
            <div class="row">
                        <!-- Column -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-md align-self-center round-info"><i class="far fa-calendar-alt"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">{{$averageAttendance}}%</h3>
                                    <h5 class="text-muted m-b-0">Average&nbspAttend</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-md align-self-center round-danger"><i class="far fa-calendar-plus"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">{{$averageArrival}}</h3>
                                    <h5 class="text-muted m-b-0">Average&nbspArrival</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-md align-self-center round-warning"><i class="far fa-clock"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">{{$averageHours}} HRS</h3>
                                    <h5 class="text-muted m-b-0">Average Hour</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-md align-self-center round-primary"><i class="far fa-calendar-check"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h5 class="m-b-0 ">{{$present}}&nbsp Present</h5>
                                    <h5 class="m-b-0 ">{{$leaveCount}}&nbsp Leaves</h5>
                                    <h5 class="m-b-0"> {{$absent}}&nbsp Absent</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    <div class="card">
        <div class="card-body">
                        <span style="float: right;">
                        @if(
                        Auth::user()->isAllowed('AttendanceController:showTimeline')
                        )
                        <select class="form-control" id="employee">
                            <option value={{Auth::user()->id}} @if(Auth::user()->type=='remote')Selected @endif>Select Employee</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}"  @if($employeeId==$employee->id) Selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
                            @endforeach
                        </select>
                        @endif
                        </span>
            <br></br>
            <div id="calendar">
            </div>
            <div id="calendarModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          Send Correction Message
                        </div>
                        <div class="modal-header">
                            <h4 id="modalTitle" class="modal-title"></h4>
                        </div>
                        <div >
                            <form action="{{route('correction_email')}}" method="post">
                            {{csrf_field()}}
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">To</label>
                                    <input  type="email" name="email" value="hr@glowlogix.com" class="form-control" hidden>
                                    <input  type="email" value="hr@glowlogix.com" class="form-control" disabled>
                                </div>
                                    <div class="form-group">
                                        <label class="control-label">CC to Line Manager</label>

                                    <select class="form-control" name="line_manager_email" @foreach($linemanagers as $linemanager) @if($linemanager->line_manager_id == null) disabled @endif @endforeach>
                                        @foreach($linemanagers as $linemanager)
                                            @if($linemanager->line_manager_id!=null)
                                                <option value="{{$linemanager->lineManager->official_email}}">{{$linemanager->lineManager->official_email}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    </div>
                                    <input id="date" type="text" name="date" hidden>
                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea  name="message" class="form-control"></textarea>
                                </div>
                            </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" >Send</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <link href="{{asset('assets/plugins/fullcalendar-3.9.0/fullcalendar.min.css')}}" rel='stylesheet' />
        <link href="{{asset('assets/plugins/fullcalendar-3.9.0/fullcalendar.print.css')}}" rel='stylesheet' media='print' />
        <link href="{{asset('assets/plugins/fullcalendar-3.9.0/scheduler.min.css')}}" rel='stylesheet' />
        <script src="{{asset('assets/plugins/fullcalendar-3.9.0/2.22.2-moment.min.js')}}"></script>
        <script src="{{asset('assets/plugins/fullcalendar-3.9.0/fullcalendar.min.js')}}"></script>
        <script src="{{asset('assets/plugins/fullcalendar-3.9.0/scheduler.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function () {

                $('#calendar').fullCalendar({

                    themeSystem: 'bootstrap4',
                    defaultView: 'month',
                    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                    displayEventTime: false,
                    businessHours: {
                        // days of week. an array of zero-based day of week integers (0=Sunday)
                        dow: [{{ $dow }}],
                    },
                    showNonCurrentDates: false,

                    firstDay: 1,
                    slotWidth :80,

                    eventClick:function(event, jsEvent, view) {
                        if (event.title.search('Absent') !== -1){
                            $('#modalTitle').html(event.title)
                            $('#modalTitle').append(event.date);
                            $('#date').val(event.date);
                            $('#calendarModal').modal();
                        }
                        },

                    events:{!! $events !!}

                });
                $("#employee").change(function(e){
                    var url = "{{route('myAttendance')}}/" + $(this).val();

                    if (url) {
                        window.location = url;
                    }
                    return false;
                });
            });
                $('.fc-other-month').html('');
        </script>
    @endpush
@stop