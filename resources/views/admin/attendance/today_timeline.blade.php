@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Today Attendance Timeline</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('attendance/today_timeline') }}">Attendance</a></li>
          <li class="breadcrumb-item active">Today Timeline</li>
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
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-calendar-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Present</span>
                        <span class="info-box-number">{{$present}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-calendar-times"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Absent</span>
                        <span class="info-box-number">{{$absent}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Delays</span>
                        <span class="info-box-number">{{$delays}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-calendar-times"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Leaves</span>
                        <span class="info-box-number">{{$leavesCount}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
  <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <span><input id="selectDate" value="{{$today}}" class="form-control col-3" type="date" name="date"/></span>
                        <hr>
                        <div class="table-responsive">
                            <table id="today_timeline" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Branch</th>
                                    <th>Time in</th>
                                    <th>Time Out</th>
                                    <th>Total Time</th>
                                    <th>Delay</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td>{{$employee['firstname']}} {{$employee['lastname']}}</td>
                                            <td>{{$employee['designation']}}</td>
                                            <td>{{isset($employee['branch']) ? $employee['branch']['name'] : ''}}</td>
                                            <td>
                                                @if(isset($employee['attendanceSummary'][0]) && $employee['attendanceSummary'][0]['first_timestamp_in'] != '')
                                                    {{isset($employee['attendanceSummary'][0]) ? Carbon\Carbon::parse($employee['attendanceSummary'][0]['first_timestamp_in'])->format('h:i a') : ''}}
                                                @endif

                                                @foreach($employeeLeave as $key=>$leave)
                                                    @if( $employee->id==$key)
                                                        <p class="text-white badge badge-warning font-weight-bold">On Leave</p>
                                                    @endif
                                                @endforeach

                                                @if(!isset($employee['attendanceSummary'][0]) && !in_array($employee->id,$employeeLeave))
                                                    <p class="text-white badge badge-danger font-weight-bold">Absent</p>
                                                @endif

                                            </td>

                                            <td>
                                                @if(isset($employee['attendanceSummary'][0]) && $employee['attendanceSummary'][0]['last_timestamp_out'] != '')
                                                    {{Carbon\Carbon::parse($employee['attendanceSummary'][0]['last_timestamp_out'])->format('h:i a')}}
                                                @else
                                                @endif
                                            </td>

                                            <td>
                                                @if(isset($employee['attendanceSummary'][0]) && $employee['attendanceSummary'][0]['last_timestamp_out'] != '')
                                                    {{isset($employee['attendanceSummary'][0]) ? gmdate('H:i', floor(number_format(($employee['attendanceSummary'][0]['total_time'] / 60), 2, '.', '') * 3600))  : ''}}
                                                @endif
                                            </td>
                                            <td>{{isset($employee['attendanceSummary'][0]) ? $employee['attendanceSummary'][0]['is_delay'] : ''}}</td>
                                            
                                            <td class="text-nowrap">
                                                <a class="btn btn-info btn-sm" href="{{route('attendance.createBreak', $employee['id'])}}/{{$today}}" title="Add Attendance"> <i class="fas fa-plus text-white"></i></a>
                                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#popup{{ $employee['id'] }}" title="Edit Attendance"> <i class="fas fa-pencil-alt text-white"></i></a>
                                                @if($attendance_corrections != '[]' && isset($employee['attendanceSummary'][0]))
                                                    @foreach($attendance_corrections as $attendance_correction)
                                                        @if($attendance_correction->date == $employee['attendanceSummary'][0]->date && $attendance_correction->employee_id == $employee['attendanceSummary'][0]->employee_id && $attendance_correction->status == '')
                                                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#change{{ $employee['attendanceSummary'][0]->id }}" title="Attendance Change Request"><i class="fas fa-clock text-white"></i></a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        @if(isset($employee['attendanceSummary'][0]))
                                            <div class="modal fade" @if($employee['attendanceSummary'] != '[]') id="change{{ $employee['attendanceSummary'][0]->id }}" @endif tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form id="decisionForm{{ $employee['attendanceSummary'][0]->id }}" action="{{route('update.attendance.correction')}}" method='POST'>
                                                            {{ csrf_field() }}
                                                            <input type="text" name="email" value="@if(isset($platform->hr_email)) {{$platform->hr_email}} @else @if(isset($platform->email)) {{$platform->email}} @else noreply@email.com @endif @endif" hidden>

                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Change Attendance</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                Following changes are requested against this Attendance:
                                                                <br><br>
                                                                @if($attendance_corrections != '[]')
                                                                    @foreach($attendance_corrections as $attendance_correction)
                                                                        @if($attendance_correction->date == $employee['attendanceSummary'][0]->date && $attendance_correction->employee_id == $employee['attendanceSummary'][0]->employee_id)

                                                                            <input type="hidden" name="employee_id" value="{{$attendance_correction->employee_id}}"/>
                                                                            <input type="hidden" name="correction_id" value="{{$attendance_correction->id}}"/>
                                                                            <input type="hidden" name="summary_id" value="{{$employee['attendanceSummary'][0]->id}}"/>
                                                                            <input type="hidden" name="date" value="{{$attendance_correction->date}}"/>

                                                                            @if($attendance_correction->time_in != '')
                                                                                <b>Time In:</b> {{$attendance_correction->time_in}}
                                                                                <br>
                                                                            @endif
                                                                            @if($attendance_correction->time_out != '')
                                                                                <b>Time Out:</b> {{$attendance_correction->time_out}}
                                                                                <br>
                                                                            @endif
                                                                            @if($attendance_correction->break_start != '')
                                                                                <b>Break Start:</b> {{$attendance_correction->break_start}}
                                                                                <br>
                                                                            @endif
                                                                            @if($attendance_correction->break_end != '')
                                                                                <b>Break End:</b> {{$attendance_correction->break_end}}
                                                                                <br>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Decision<span class="text-danger">*</span></label>
                                                                            <select class="form-control custom-select" data-placeholder="Select Decision" tabindex="1" name="decision" id="decision{{ $employee['attendanceSummary'][0]->id }}" onchange="check('decision'+{!! $employee['attendanceSummary'][0]->id !!});">
                                                                                <option value="">Select Decision</option>
                                                                                <option value="Approved">Approve</option>
                                                                                <option value="Rejected">Reject</option>
                                                                            </select>
                                                                            <span id="decision-error{{$employee['attendanceSummary'][0]->id}}"  class="error invalid-feedback">Decision is required</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                                <a class="btn btn-primary create-btn" onclick="validate({!! $employee['attendanceSummary'][0]->id !!});"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="modal fade" id="popup{{ $employee['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('attendance.storeAttendanceSummaryToday')}}" method='POST'>
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="employee_id" value="{{$employee['id']}}"/>

                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Add/Update Attendance</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            Fill the form below to add/update Attendance of Employee "{{$employee['firstname']}} {{$employee['lastname']}}":
                                                            <div class="col-12 pt-2 pl-0 pr-0">
                                                                <div class="form-group">
                                                                    <label for="date">Today's Date</label>
                                                                    <input type="date" id="selectCurrentDate" class="form-control" name="date" value="{{isset($employee['attendanceSummary'][0]) ? $employee['attendanceSummary'][0]['date']: $today}}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 pl-0 pr-0">
                                                                <div class="form-group">
                                                                    <label for="date">Time In</label>
                                                                    <input type="datetime-local" class="form-control" name="time_in" value="{{isset($employee['attendanceSummary'][0]) ? date('Y-m-d\TH:i',strtotime($employee['attendanceSummary'][0]['first_timestamp_in'])) : ''}}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-12 pl-0 pr-0">
                                                                <div class="form-group">
                                                                    <label for="date">Time Out</label>
                                                                    <input type="datetime-local" class="form-control" name="time_out" value="{{isset($employee['attendanceSummary'][0]) && $employee['attendanceSummary'][0]['last_timestamp_out']!=""  ? date('Y-m-d\TH:i',strtotime($employee['attendanceSummary'][0]['last_timestamp_out'])) : ''}}" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button type="submit" class="btn btn-primary create-btn"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Present</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script src="{{asset('assets/backend/plugins/old-moment/moment.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#today_timeline').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    $("input.zoho").click(function (event) {
        if ($(this).is(":checked")) {
            $("#div_" + event.target.id).show();
        } 
        else {
            $("#div_" + event.target.id).hide();
        }
    });
    $("input.zoho").click(function (event) {
        if ($(this).is(":checked")) {
            $("#div_" + event.target.id).show();
        } else {
            $("#div_" + event.target.id).hide();
        }
    });
    $(document).ready(function () {
        $("#selectDate").change(function(e){
            var url = "{{route('today_timeline')}}/" + $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
    });
    $(document).ready(function () {
        $("#selectCurrentDate").change(function(e){
            var url = "{{route('today_timeline')}}/" + $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
    });

    function validate(id)
    {
        if($("#decision"+id).val() == '')
        {
            $('#decision-error'+id).addClass('show');
            $('#decision'+id).addClass('is-invalid');
        }
        else
        {
            $('#decisionForm'+id).submit();
        }
    }

    function check(id)
    {
        if($('#'+id).val() != '')
        {
            $('#'+id).removeClass('show');
            $('#'+id).removeClass('is-invalid');
        }
        else
        {
            $('#'+id).addClass('show');
            $('#'+id).addClass('is-invalid');
        }
    }
</script>
@stop