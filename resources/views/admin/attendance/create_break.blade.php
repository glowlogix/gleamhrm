@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
@if(request()->is('attendance/create_break/*/*'))
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('attendance/today_timeline') }}">Attendance</a></li>
              <li class="breadcrumb-item"><a href="{{ url('attendance/today_timeline') }}">Today Timeline</a></li>
              <li class="breadcrumb-item active">Add Attendance</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
@endif
@if(request()->is('attendance/create_break'))
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('attendance/timeline') }}">Attendance</a></li>
              <li class="breadcrumb-item"><a href="{{ url('attendance/timeline') }}">Timeline</a></li>
              <li class="breadcrumb-item active">Add Attendance</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
@endif
@if(request()->is('add/attendance/*/*'))
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('my/attendance') }}">My Attendance</a></li>
              <li class="breadcrumb-item active">Add Attendance</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
@endif
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if(isset($attendance_summary) && Auth::user()->isAllowed('AttendanceController:Attendance_Summary_Delete'))
                                    <a data-toggle="modal" data-target="#confirm-delete{{$attendance_summary->id}}" class="btn btn-danger" title="Delete Attendance Summary"><span class=" d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline">Delete</span></a>
                                @endif
                                @if(Auth::user()->isAllowed('LeaveController:adminCreate'))
                                    <button type="button" title="Add Employee Leave" onclick="window.location.href='{{route('admin.createLeave')}}'" class="btn btn-info float-right" ><i class="fas fa-plus"></i> <span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline">Add Employee Leave</span></button>
                                @endif
                            </div>
                        </div>
                        @if(Auth::user()->isAllowed('LeaveController:adminCreate') || Auth::user()->isAllowed('AttendanceController:Attendance_Summary_Delete'))
                            <hr>
                        @endif
                        <h5 class="pt-3"><strong>Details</strong></h5>
                        <hr class="mt-0">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Is Delay? :</label>
                                    <div class="col-md-4 ">
                                        @if(isset($attendance_summary->is_delay)) {{$attendance_summary->is_delay}} @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Total Hours:</label>
                                    <div class="col-md-3 ">
                                        @if(isset($attendance_summary->total_time))
                                        {{gmdate('H:i', floor(number_format(($attendance_summary->total_time/60), 2, '.', '') * 3600))}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Total Checks:</label>
                                    <div class="col-md-4 ">
                                        @if($attendances->count()) {{$attendances->count()}} @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if(isset($attendance_summary))
                            <div class="modal fade" id="confirm-delete{{$attendance_summary->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('attendance.delete' ,$attendance_summary->id)}}" method="post">
                                            {{ csrf_field() }}
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Attendance Summary</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete Attendance of "@foreach($employees as $emp)
                                                @if($emp_id == $emp->id) {{$emp->firstname}} {{$emp->lastname}} @endif @endforeach"?
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" title="Cancel" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                <button  type="submit" class="btn btn-danger btn-ok" title="Delete Attendance Summary"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form id="createBreakForm" @if(Auth::user()->isAllowed('AttendanceController:storeAttendanceSummaryToday')) action="{{route('attendance.storeAttendanceSummaryToday')}}" @else action="{{route('store.attendance')}}" @endif method='POST'>
                            {{csrf_field()}}
                            <h5 class="pt-3"><strong>Create CheckIn/CheckOut</strong></h5>
                            <hr class="mt-0">
                            <div class="row">
                                @if(Auth::user()->isAllowed('AttendanceController:createBreak'))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Name Here<span class="text-danger">*</span></label>
                                            <select class="form-control custom-select" name="employee_id">
                                                <option value="">Select Employee</option>
                                                @foreach($employees as $emp)
                                                <option value="{{$emp->id}}" @if($emp_id==$emp->id) selected @endif >{{$emp->firstname}} {{$emp->lastname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Date</label>
                                            <input type="date" class="form-control date" name="date" value="{{$current_date}}"/>
                                        </div>
                                    </div>
                                @else
                                    <input type="text" name="employee_id" value="{{ Auth::user()->id }}" hidden>
                                    <input type="text" name="date" value="{{$current_date}}" hidden>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Time In</label>
                                        <input type="datetime-local" class="form-control" name="time_in" value="{{isset($attendance_summary['first_timestamp_in']) ? date('Y-m-d\TH:i',strtotime($attendance_summary['first_timestamp_in'])): ''}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Time Out</label>
                                        <input type="datetime-local" class="form-control" name="time_out" value="{{isset($attendance_summary['last_timestamp_out']) && $attendance_summary['last_timestamp_out']!=""  ? date('Y-m-d\TH:i',strtotime($attendance_summary['last_timestamp_out'])): '' }}"/>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary" title="Create Attendance" @if(!Auth::user()->isAllowed('AttendanceController:storeAttendanceSummaryToday') && isset($attendance_summary)) @if($attendance_summary->first_timestamp_in != '' && $attendance_summary->last_timestamp_out != '') disabled @endif @endif><i class="fas fa-check-circle d-lg-none d-md-none d-sm-block"></i><span class="d-none d-md-inline d-lg-inline">Create</span></button>
                            
                            <button type="button" class="btn btn-default" title="Cancel" @if(request()->is('attendance/create_break/*/*')) onclick="window.location.href='{{route('today_timeline')}}'" @endif @if(request()->is('attendance/create_break')) onclick="window.location.href='{{route('timeline')}}'" @endif @if(request()->is('add/attendance/*/*')) onclick="window.location.href='{{route('myAttendance')}}'" @endif><i class="fas fa-window-close d-lg-none d-md-none d-sm-block"></i><span class="d-none d-md-inline d-lg-inline">Cancel</span></button>
                            <div class="col-md-6"> </div>
                        </form>
                        <hr>
                        <h5 class="pt-3 row justify-content-between">
                            <strong class="ml-2 mr-1 pt-1">Breaks</strong>
                            @if(isset($attendance_summary))
                            <a class="btn btn-info text-white mr-2" data-toggle="modal" data-target="#popup" title="Add Break"> <i class="fas fa-plus"></i> <span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline">Add Break</span></a>
                            @endif
                        </h5>
                        <hr class="mt-0">
                        <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="addBreakForm" @if(Auth::user()->isAllowed('AttendanceController:storeAttendanceSummaryToday'))  action="{{route('attendance.storeBreak')}}" @else action="{{route('store.attendance.break')}}" @endif method='POST'>
                                        {{ csrf_field() }}
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Break</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <select class="form-control custom-select" name="employee_id" hidden>
                                                <option value="0">Select Employee</option>
                                                @foreach($employees as $emp)
                                                <option value="{{$emp->id}}" @if($emp_id==$emp->id) selected @endif >{{$emp->firstname}} {{$emp->lastname}}</option>
                                                @endforeach
                                            </select>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="date">Date<span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control date" name="date" value="{{$current_date}}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="time_in">Break Start<span class="text-danger">*</span></label>
                                                        <input type="datetime-local" class="form-control" name="break_start">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="time_out">Break End<span class="text-danger">*</span></label>
                                                        <input type="datetime-local" class="form-control" name="break_end">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="time_out">Comment</label>
                                                        <input type="text" class="form-control" name="comment" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" title="Cancel" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button  type="submit" class="btn btn-primary btn-ok" title="Create Break"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="break" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Break Start</th>
                                        <th>Break End</th>
                                        <th>Comment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $att)
                                        <tr>
                                            <td>
                                                @if($att->timestamp_break_start != '')
                                                {{ Carbon\Carbon::parse($att->timestamp_break_start)->format('h:i a')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($att->timestamp_break_end != '')
                                                {{ Carbon\Carbon::parse($att->timestamp_break_end)->format('h:i a') }}
                                                @endif
                                            </td>
                                            <td>{{$att->comment}}</td>
                                            <td class="text-nowrap">
                                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $att->id }}" title="Edit Break"> <i class="fas fa-pencil-alt text-white "></i></a>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $att->id }}" title="Delete Break"> <i class="fas fa-trash-alt text-white"></i></a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="edit{{ $att->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="addBreakForm" action="{{ route('attendance.updateBreak' , ['id'=>$att->id] )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Break</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="date">Date<span class="text-danger">*</span></label>
                                                                        <input type="date" class="form-control" name="date" value="{{$att->date}}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="time">Break Start<span class="text-danger">*</span></label>
                                                                        <input type="datetime-local" class="form-control" name="break_start" value="{{date('Y-m-d\TH:i',strtotime($att->timestamp_break_start))}}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="time">Break End<span class="text-danger">*</span></label>
                                                                        <input type="datetime-local" class="form-control" name="break_end" @if($att->timestamp_break_end!=null) value="{{date('Y-m-d\TH:i',strtotime($att->timestamp_break_end))}}" @endif />
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="time">Comment</label>
                                                                        <input type="text" class="form-control" name="comment" value="{{$att->comment}}"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" title="Cancel" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-primary btn-ok" title="Update Break"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="confirm-delete{{ $att->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('attendance.deleteBreakChecktime' , ['id' => $att->id] )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Break</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this Break from <strong>{{Carbon\Carbon::parse($att->timestamp_break_start)->format('h:i a')}}</strong> to <strong>{{Carbon\Carbon::parse($att->timestamp_break_end)->format('h:i a')}} </strong>on <strong>{{Carbon\Carbon::parse($att->timestamp_break_end)->format('d-m-Y')}}</strong>?
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" title="Cancel" data-dismiss="modal"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-danger btn-ok" title="Delete Break"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
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
<script>
    $(function () {
        $('#createBreakForm').validate({
            rules: {
                employee_id: {
                    required: true,
                }
            },
            messages: {
                employee_id: "Employee name is required"
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
        $('.addBreakForm').validate({
            rules: {
                date: {
                    required: true,
                },
                break_start: {
                    required: true,
                },
                break_end: {
                    required: true,
                },
            },
            messages: {
                date: "Date is required",
                break_start: "Break start time is required",
                break_end: "Break end time is required",
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
        $('#break').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    $(document).ready(function() {
        $('#delay').hide();
        $('.date').on("change", function(e) {
            @if($emp_id)
            var url = '{{route('attendance.createBreak')}}/{{$emp_id}}/' + $(this).val();
            @else
            var url = '{{route('attendance.createBreak')}}/0/' + $(this).val();
            @endif
            if (url) {
                window.location = url;
            }
            return false;
        });
        $(".custom-select").on('change', function(e) {
            if (this.value != '') {
                var url = '{{route('attendance.createBreak')}}/' + $(this).val() + '/{{$current_date}}';
                if (url) {
                    window.location = url;
                }
                return false;
            }
        });
    });
</script>
@stop