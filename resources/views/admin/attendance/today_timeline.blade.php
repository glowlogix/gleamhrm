@extends('layouts.admin') @section('title') HRM|{{$title}} @endsection
@section('Heading')
    <h3 class="text-themecolor">Attendance</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Attendance</li>
        <li class="breadcrumb-item active">Today Attendance Timeline</li>
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
                                <div class="round round-md align-self-center round-primary"><i class="far fa-calendar-check"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h5 class="m-b-0 font-light">{{$present}}</h5>
                                    <h5 class="m-b-0">Present</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-md align-self-center round-danger"><i class="far fa-calendar-times"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h5 class="m-b-0 font-light"> {{$absent}}</h5>
                                    <h5 class="m-b-0">Absent</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-md align-self-center round-warning"><i class="far fa-clock"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">{{$delays}}</h3>
                                    <h5 class="text-muted m-b-0">Delays</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="round round-md align-self-center round-success"><i class="fas fa-calendar-times"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0 font-light">{{$leavesCount}}</h3>
                                    <h5 class="text-muted m-b-0">Leaves</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <span style="float: left;"><input id="selectDate" value="{{$today}}" class="form-control" type="date" name="date"></span>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                    @if(count($employees) > 0) @foreach($employees as $employee)

                        <tr>
                            <td>{{$employee['firstname']}} {{$employee['lastname']}}</td>
                            <td>{{$employee['designation']}}</td>
                            <td>{{isset($employee['branch']) ? $employee['branch']['name'] : ''}}</td>
                            <td>
                                @if(
                               isset($employee['attendanceSummary'][0]) &&
                               $employee['attendanceSummary'][0]['first_timestamp_in'] != ''
                                    )
                                {{isset($employee['attendanceSummary'][0]) ? Carbon\Carbon::parse($employee['attendanceSummary'][0]['first_timestamp_in'])->format('h:i a') : ''}}</td>
                                @endif
                                @foreach($employeeLeave as $key=>$leave)
                                @if( $employee->id==$key)
                                    <p class="text-white badge badge-warning  font-weight-bold">On Leave</p>
                                    @endif
                                @endforeach
                            @if(!isset($employee['attendanceSummary'][0]) && !in_array($employee->id,$employeeLeave))
                                <p class="text-white badge badge-danger  font-weight-bold">Absent</p>
                            @endif
                                <td>
                                @if(
                                    isset($employee['attendanceSummary'][0]) &&
                                    $employee['attendanceSummary'][0]['last_timestamp_out'] != ''
                                )
                                {{Carbon\Carbon::parse($employee['attendanceSummary'][0]['last_timestamp_out'])->format('h:i a')}}
                                    @else
                                 @endif
                            </td>

                            <td>
                                @if(
                                   isset($employee['attendanceSummary'][0]) &&
                                   $employee['attendanceSummary'][0]['last_timestamp_out'] != ''
                               )
                                    {{isset($employee['attendanceSummary'][0]) ? gmdate('H:i', floor(number_format(($employee['attendanceSummary'][0]['total_time'] / 60), 2, '.', '') * 3600))  : ''}}
                            @endif
                            </td>
                            <td>{{isset($employee['attendanceSummary'][0]) ? $employee['attendanceSummary'][0]['is_delay'] : ''}}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{route('attendance.createBreak', $employee['id'])}}/{{$today}}" data-original-title="Add"> <i class="fas fa-plus text-white"></i></a>
                                <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#popup{{ $employee['id'] }}" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
                                {{--///Dialog Box/// --}}
                                    <div class="modal fade" id="popup{{ $employee['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{route('attendance.storeAttendanceSummaryToday')}}" method='POST'>
                                                    {{ csrf_field() }}
                                                    <div class="modal-header" style="margin-right: 20px;">
                                                        Adding attendance for Employee:
                                                    </div>
                                                    <div class="modal-header">
                                                        <h4>{{$employee['firstname']}} {{$employee['lastname']}}</h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="col-md-14">
                                                                <label for="date">Today's Date</label><br>
                                                                <div class="input-group date1">
                                                                    <input type="hidden" name="employee_id" value="{{$employee['id']}}"/>
                                                                    <input type="date" id="selectCurrentDate" class="form-control" name="date" value="{{isset($employee['attendanceSummary'][0]) ? $employee['attendanceSummary'][0]['date']: $today}}"/>
                                                                    <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="time_in">Time In</label>
                                                                    <div class="input-group">
                                                                        <input type="datetime-local" class="form-control" name="time_in" value="{{isset($employee['attendanceSummary'][0]) ? date('Y-m-d\TH:i',strtotime($employee['attendanceSummary'][0]['first_timestamp_in'])) : ''}}" />
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-clock-o" style="font-size:16px"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <br>
                                                                    <label for="time_out">Time Out</label>
                                                                    <div class="input-group">
                                                                        <input type="datetime-local" class="form-control" name="time_out" value="{{isset($employee['attendanceSummary'][0]) && $employee['attendanceSummary'][0]['last_timestamp_out']!=""  ? date('Y-m-d\TH:i',strtotime($employee['attendanceSummary'][0]['last_timestamp_out'])) : ''}}" />
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-clock-o" style="font-size:16px"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success create-btn" id="add-btn" >Present</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                {{--///End Dialog Box///--}}
                            </td>
                        </tr>
                    @endforeach @else
                        <tr> No Employee Found.</tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@push('scripts')
<script type="text/javascript">
$("input.zoho").click(function (event) {
    if ($(this).is(":checked")) {
        $("#div_" + event.target.id).show();
    } 
    else {
        $("#div_" + event.target.id).hide();
    }
});
</script>

<script type="text/javascript">
    $("input.zoho").click(function (event) {
        if ($(this).is(":checked")) {
            $("#div_" + event.target.id).show();
        } else {
            $("#div_" + event.target.id).hide();
        }
    });
</script>
<script>
    $(function () {
        $(document).ready(function() {
            $('#myTable').DataTable({
                stateSave: true,
            });
        });
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
</script>
<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

@endpush
@stop