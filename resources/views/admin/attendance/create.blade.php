@extends('layouts.admin')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading text-center">
            <div><b style="text-align: center;">Create Attendance</b></div>
        </div>
        <div class="row">
            <div class="panel-body">
                <form action="{{route('attendance.store')}}" method='POST'>
                    {{csrf_field()}}
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Name:</label>
                                <select class="form-control nameselect2" name="employee_id">
                                    <option value="0">Select Employee</option>
                                    @foreach($employees as $emp)
                                    <option value="{{$emp->id}}" @if($emp_id == $emp->id) selected @endif >{{$emp->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date">Select Date</label></br>
                                <input type="date" name="date" id="date" class="datepickstyle" value="{{$current_date}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="time_in">Time In</label>
                        <div class="input-group time timepicker">
                            <input class="form-control time tp" name="time_in" value="{{$current_time}}" />
                            <span class="input-group-addon timepicker1">
                                <i class="fa fa-clock-o" style="font-size:16px"></i>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="time_out">Time Out</label>
                        <div class="input-group time timepicker">
                            <input class="form-control time tp" name="time_out" value="{{$current_time}}" />
                            <span class="input-group-addon timepicker1">
                                <i class="fa fa-clock-o" style="font-size:16px"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="container-fluid" id="totalhours">
                        <label for="delay">is Delay ?</label>
                        <div>
                            @if(isset($attendance_summary->is_delay)) {{$attendance_summary->is_delay}} @endif
                        </div>

                        <label for="name">Total hours</label>
                        <div>
                            @if(isset($attendance_summary->total_time)) {{$attendance_summary->total_time / 60}} @endif
                        </div>

                        <label for="name">Total Checks</label>
                        <div>
                            @if($attendances->count()) {{$attendances->count()}} @endif
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-success create-btn" id="add-btn"  type="submit" > Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </thead>
                    <tbody class="table-bordered table-hover table-striped">
                        @if($attendances->count() > 0) @foreach($attendances as $att)
                        <tr>
                            <td>
                                {{ Carbon\Carbon::parse($att->time_in)->format('h:i a') }}
                            </td>
                            <td>
                                @if ($att->time_out != '')
                                {{ Carbon\Carbon::parse($att->time_out)->format('h:i a') }}
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-default" data-toggle="modal" data-target="#edit{{ $att->id }}">Edit</button>

                                <div class="modal fade" id="edit{{ $att->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('attendance.update' , ['id'=>$att->id] )}}" method="post">
                                                {{ csrf_field() }}
                                                <div class="modal-header">
                                                    Edit Attendance
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <label for="date">Date</label>
                                                    <br>
                                                    <input type="date" name="date" id="date" class="datepickstyle" value="{{$current_date}}">
                                                    
                                                    <br>

                                                    <label for="time">Time In</label>
                                                    <div class="input-group time_in timepicker">
                                                        <input class="form-control time_in tp" name="time_in" value="{{Carbon\Carbon::parse($att->time_in)->format('h:i a')}}" />
                                                        <span class="input-group-addon timepicker1">
                                                            <i class="fa fa-clock-o" style="font-size:16px"></i>
                                                        </span>
                                                    </div>

                                                    <label for="time">Time Out</label>
                                                    <div class="input-group time_out timepicker">
                                                        <input class="form-control time_out tp" name="time_out" value="{{Carbon\Carbon::parse($att->time_out)->format('h:i a')}}" />
                                                        <span class="input-group-addon timepicker1">
                                                            <i class="fa fa-clock-o" style="font-size:16px"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <button  type="submit" class="btn btn-success btn-ok">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete{{ $att->id }}">Delete</button>
                                <div class="modal fade" id="confirm-delete{{ $att->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('attendance.deletechecktime' , ['id' => $att->id] )}}" method="post">
                                            {{ csrf_field() }}
                                            <div class="modal-header">
                                                Are you sure you want to delete this <strong>
                                                check {{ $att->in_out }} on {{Carbon\Carbon::parse($att->date .' '.$att->time)->format('Y-m-d h:i a')}} ? 
                                                </strong>
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
                            <td>
                                Time Not Added yet
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                // $('#totalhours').hide();
                $('#delay').hide();
  
                $('input.tp').datetimepicker({
                    format: "LT",
                    icons: {
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down"
                    }
                });

                $('#date').on('change', function (e) { 
                    console.log(e);
                    var url = '{{route('attendance')}}/create/{{$emp_id}}/' + $(this).val();
                    if (url) { 
                        window.location = url; 
                    }
                    return false;
                  });


                $('.timepicker1').click(function(){
                    $(this).parent().datetimepicker({
                        format: "LT",
                        icons: {
                            up: "fa fa-chevron-up",
                            down: "fa fa-chevron-down"
                        }
                    });
                });
            });
           
            $(document).ready(function(){
                $(".nameselect2").select2().on('change.select2', function(e){

                    var url = '{{route('attendance')}}/create/' + $(this).val() + '/{{$current_date}}';

                    if (url) { 
                        window.location = url; 
                    }
                    return false;
                });
            });
            
        </script>
    </div>
@stop