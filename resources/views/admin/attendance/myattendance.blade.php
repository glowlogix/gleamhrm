@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">My Attendance</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('my/attendance') }}">Attendance</a></li>
          <li class="breadcrumb-item active">My Attendance</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span >Average Attendance</span>
                        <span class="info-box-number">{{$averageAttendance}}%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-calendar-plus"></i></span>
                    <div class="info-box-content">
                        <span>Average Arrival</span>
                        <span class="info-box-number">{{$averageArrival}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-clock"></i></span>
                    <div class="info-box-content">
                        <span>Average Hours</span>
                        <span class="info-box-number">{{$averageHours}} HRS</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="far fa-calendar-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>{{$present}}</b> Present</span>
                        <span class="info-box-text"><b>{{$leaveCount}}</b> Leaves</span>
                        <span class="info-box-text"><b>{{$absent}}</b> Absent</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between pl-2 pr-2">
                            <div>
                                @if(Auth::user()->isAllowed('AttendanceController:showTimeline'))
                                    <select class="form-control" id="employee">
                                        <option value={{Auth::user()->id}} @if(Auth::user()->type=='remote')Selected @endif>Select Employee</option>
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}"  @if($employeeId==$employee->id) Selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div>
                                @if(Auth::user()->isAllowed('AttendanceController:storeAttendanceSummaryToday') || $summaryDate == '')
                                    <a type="button" href="{{route('add.attendance', Auth::user()->id)}}/{{$today}}" class="btn btn-info btn-rounded ml-1" title="Add Attendance"><i class="fas fa-plus"></i> <span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline">Add Attendance</span></a>
                                @endif
                            </div>
                        </div>

                        @if(Auth::user()->isAllowed('AttendanceController:storeAttendanceSummaryToday') || $summaryDate == '')
                            <hr>
                        @endif

                        <div id="calendar"></div>

                        <div id="calendarModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="attendanceCorrectionForm" action="{{route('correction_email')}}" method="post">
                                    {{csrf_field()}}
                                        <div class="modal-header">
                                            <h4 class="modal-title">Send Attendance Correction Request</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 id="modalTitle" class="modal-title"></h6>
                                            <br>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">To</label>
                                                    <input  type="email" name="email" value="@if(isset($platform->hr_email)) {{$platform->hr_email}} @else @if(isset($platform->email)) {{$platform->email}} @else noreply@email.com @endif @endif" class="form-control" hidden>
                                                    <input  type="email" value="@if(isset($platform->hr_email)) {{$platform->hr_email}} @else @if(isset($platform->email)) {{$platform->email}} @else noreply@email.com @endif @endif" class="form-control" disabled>
                                                    @if(!isset($platform->hr_email) && !isset($platform->hr_email))
                                                        <span class="text-danger">Please set platform settings to receive email on your company email.</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-12">
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
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">Message<span class="text-danger">*</span></label>
                                                    <textarea  name="message" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" title="Cancel" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button  type="submit" class="btn btn-primary btn-ok" title="Delete Attendance Summary"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Send</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="timeCorrectionModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="attendanceTimeCorrectionForm" action="{{ route('attendance.correction') }}" method="post">
                                    {{csrf_field()}}
                                        <input id="timeDate" type="text" name="timeDate" hidden>
                                        <input type="text" name="email" value="@if(isset($platform->hr_email)) {{$platform->hr_email}} @else @if(isset($platform->email)) {{$platform->email}} @else noreply@email.com @endif @endif" hidden>
                                        
                                        <div class="modal-header">
                                            <h4 class="modal-title">Send Time Correction Request</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 id="timeModalTitle" class="modal-title"></h6>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Time In</label>
                                                        <input type="time" class="form-control" name="time_in" value=""/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Time Out</label>
                                                        <input type="time" class="form-control" name="time_out" value=""/>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="time_in">Break Start</label>
                                                        <input type="time" class="form-control" name="break_start" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="time_out">Break End</label>
                                                        <input type="time" class="form-control" name="break_end" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" title="Cancel" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button  type="submit" class="btn btn-primary btn-ok" title="Delete Attendance Summary"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Send</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<link href="{{asset('assets/backend/plugins/fullcalendar-3.9.0/fullcalendar.min.css')}}" rel='stylesheet'/>
<link href="{{asset('assets/backend/plugins/fullcalendar-3.9.0/fullcalendar.print.css')}}" rel='stylesheet' media='print'/>
<link href="{{asset('assets/backend/plugins/fullcalendar-3.9.0/scheduler.min.css')}}" rel='stylesheet'/>
<script src="{{asset('assets/backend/plugins/fullcalendar-3.9.0/2.22.2-moment.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/fullcalendar-3.9.0/fullcalendar.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/fullcalendar-3.9.0/scheduler.min.js')}}"></script>

<script>
    $(function () {
        $('#attendanceCorrectionForm').validate({
            rules: {
                message: {
                    required: true,
                }
            },
            messages: {
                message: "Message is required"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    
    $(function () {
        $('#attendanceTimeCorrectionForm').validate({
            rules: {
                time_in: {
                    required: true,
                },
                time_out: {
                    required: true,
                },
                break_start: {
                    required: true,
                },
                break_end: {
                    required: true,
                }
            },
            messages: {
                time_in: "In time is required",
                time_out: "Out time is required",
                break_start: "Break start is required",
                break_end: "Break end is required"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

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
                    $('#modalTitle').html('Your attendance was marked as <b>' + event.title + '</b> on date ');
                    $('#modalTitle').append('<b>' + event.date + '</b>. For correction please fill the form below:');
                    $('#date').val(event.date);
                    $('#calendarModal').modal();
                }

                arr = event.title.split('\n');
                title = arr[0];
                time = arr[1].split(' - ');
                time_in = time[0];
                time_out = time[1];
                hours = arr[2];
                if(title == 'present')
                {
                    $('#timeModalTitle').html('You attendance was marked from <b>' + time_in + '</b> to <b>' + time_out + '</b> for <b>' + hours + '</b> on ');
                    $('#timeModalTitle').append('<b>' + event.date + '</b>. For correction request plese fill the form below:');
                    $('#timeDate').val(event.date);
                    $('#timeCorrectionModal').modal();
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
@stop