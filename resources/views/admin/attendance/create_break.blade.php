@extends('layouts.admin')
@section('Heading')
    @if(Auth::user()->isAllowed('LeaveController:adminCreate'))
        <button type="button"  onclick="window.location.href='{{route('admin.createLeave')}}'" class="btn btn-info btn-rounded m-t-10 float-right"><span class="fas fa-plus"></span> Add Employee Leave</button>
    @endif
    <h3 class="text-themecolor">Add Attendance</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Attendance</li>
        <li class="breadcrumb-item active">Add Attendance</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div style="margin-top: 10px;margin-right: 10px">
                    <button type="button" class="btn  btn-info float-right" onclick="window.location.href='{{route('today_timeline')}}'">Back</button>
                    @if(isset($attendance_summary))
                    <a style="margin-left: 10px" data-toggle="modal" data-target="#confirm-delete{{ $department->id }}" class="btn btn-danger float-left text-white">Delete</a>
                    @endif
                </div>
                @if(isset($attendance_summary))
                <div class="modal fade" id="confirm-delete{{$attendance_summary->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('attendance.delete' ,$attendance_summary->id)}}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    Are you sure you want to delete Attendance Of?
                                </div>
                                <div class="modal-header">
                                    <h4> @foreach($employees as $emp)
                                            @if($emp_id == $emp->id) {{$emp->firstname}} {{$emp->lastname}} @endif
                                        @endforeach</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                <div class="card-body">
                    <form   class="form-horizontal" action="{{route('attendance.storeAttendanceSummaryToday')}}" method='POST'>
                        {{csrf_field()}}
                        <div class="form-body">
                            <h3 class="box-title">Create CheckIn/CheckOut</h3>
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Select Name Here</label>
                                        <div class="col-md-9">
                                            <select class="form-control custom-select" name="employee_id">
                                                <option value="0">Select Employee</option>
                                                @foreach($employees as $emp)
                                                    <option value="{{$emp->id}}" @if($emp_id == $emp->id) selected @endif >{{$emp->firstname}} {{$emp->lastname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Select Date</label>
                                        <div class="col-md-9" >
                                            <input type="date" class="form-control date" name="date" value="{{$current_date}}">
                                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Time In</label>
                                        <div class="col-md-9">
                                            <input type="datetime-local"  class="form-control" name="time_in" value="{{isset($attendance_summary['first_timestamp_in']) ? date('Y-m-d\TH:i',strtotime($attendance_summary['first_timestamp_in'])): ''}}">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row ">
                                        <label class="control-label text-right col-md-3">Time Out</label>
                                        <div class="col-md-9">
                                            <input type="datetime-local" class="form-control" name="time_out" value="{{isset($attendance_summary['last_timestamp_out']) && $attendance_summary['last_timestamp_out']!=""  ? date('Y-m-d\TH:i',strtotime($attendance_summary['last_timestamp_out'])): '' }}">
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                        </div>
                        <div class="form-actions">
                            <hr>
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-offset-3 col-md-12">
                                        <button type="submit" class="btn btn-info float-right">Create</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> </div>
                        </div>
                    </form>
                    <br>
                    <h3 class="box-title">Details</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-6">Is Delay? :</label>
                                <div class="col-md-4 ">
                                    @if(isset($attendance_summary->is_delay)) {{$attendance_summary->is_delay}} @endif
                                </div>
                            </div>
                        </div>

                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group row ">
                                <label class="control-label text-right col-md-6">Total Hours:</label>
                                <div class="col-md-3 ">
                                    @if(isset($attendance_summary->total_time))
                                        {{gmdate('H:i', floor(number_format(($attendance_summary->total_time/60), 2, '.', '') * 3600))}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group row ">
                                <label class="control-label text-right col-md-6">Total Checks:</label>
                                <div class="col-md-4 ">
                                    @if($attendances->count()) {{$attendances->count()}} @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <h3 class="box-title">Breaks<a class="btn btn-info text-white float-right" data-toggle="modal" data-target="#popup" data-original-title="Edit"> <i class="fas fa-plus text-white"></i> Add Break</a>
                    </h3>
                    <hr>
                    {{--///Dialog Box/// --}}
                <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{route('attendance.storeBreak')}}" method='POST'>
                                {{ csrf_field() }}
                                <div class="modal-header" style="margin-right: 20px;">
                                    Add Break
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                                <select class="form-control custom-select" name="employee_id" hidden>
                                                    <option value="0">Select Employee</option>
                                                    @foreach($employees as $emp)
                                                        <option value="{{$emp->id}}" @if($emp_id == $emp->id) selected @endif >{{$emp->firstname}} {{$emp->lastname}}</option>
                                                    @endforeach
                                                </select>
                                        <div class="col-md-14">
                                            <label for="date">Date</label><br>
                                            <div class="input-group date1">
                                                <input type="date" class="form-control date" name="date" value="{{$current_date}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="time_in">Break Start</label>
                                                <div class="input-group timepicker">
                                                    <input type="datetime-local"  class="form-control" name="break_start" value="{{$current_time}}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="time_out">Break End</label>
                                                <div class="input-group timepicker">
                                                    <input type="datetime-local" class="form-control" name="break_end" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="time_out">Comment</label>
                                                <div class="input-group timepicker">
                                                    <input type="text" class="form-control" name="comment" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success create-btn" id="add-btn" >Add Break</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <div class="col-md-push-12">
                                <div class="table">
                                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
                                        <thead>
                                        @if($attendances->count() > 0)
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
                                                    <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $att->id }}"> <i class="fas fa-pencil-alt text-white "></i></a>
                                                    <div class="modal fade" id="edit{{ $att->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('attendance.updateBreak' , ['id'=>$att->id] )}}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <div class="modal-header">
                                                                        Edit Break
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div>
                                                                            <label for="date">Date</label></br>
                                                                            <div class="input-group">
                                                                                <input type="date" class="form-control" name="date" value="{{$att->date}}" />
                                                                            </div>
                                                                        </div>

                                                                        <label for="time">Break Start</label>
                                                                        <div class="input-group">
                                                                            <input type="datetime-local" class="form-control" name="break_start"  value="{{date('Y-m-d\TH:i',strtotime($att->timestamp_break_start))}}" />
                                                                        </div>

                                                                        <label for="time">Break End</label>
                                                                        <div class="input-group">
                                                                            <input type="datetime-local" class="form-control" name="break_end" @if($att->timestamp_break_end!=null) value="{{date('Y-m-d\TH:i',strtotime($att->timestamp_break_end))}}" @endif />
                                                                        </div>
                                                                        <label for="time">Comment</label>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="comment" value="{{$att->comment}}">                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                        <button  type="submit" class="btn btn-success btn-ok">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--//Edit--}}
                                                    <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $att->id }}"> <i class="fas fa-window-close text-white"></i></a>

                                                    <div class="modal fade" id="confirm-delete{{ $att->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('attendance.deleteBreakChecktime' , ['id' => $att->id] )}}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <div class="modal-header">
                                                                        Are you sure you want to delete this Break check
                                                                    </div>
                                                                    <div class="modal-content">
                                                                        <strong>{{ $att->in_out }} on {{Carbon\Carbon::parse($att->timestamp_break_start)->format('Y-m-d h:i a')}} ?</strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                        <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach @else
                                            <tr>
                                                <p>
                                                    Time Not Added yet
                                                </p>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    @push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
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

            $(".custom-select").on('change', function(e){
                var url = '{{route('attendance.createBreak')}}/' + $(this).val() + '/{{$current_date}}';

                if (url) {
                    window.location = url;
                }
                return false;
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker2').datetimepicker({
                locale: 'ru'
            });
        });
    </script>
    @endpush
@stop
