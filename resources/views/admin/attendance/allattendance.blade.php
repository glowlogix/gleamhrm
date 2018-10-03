@extends('layouts.admin') @section('content')

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b style="text-align: center;">All Attendance</b>
        <span style="float: left;">
            <a href="{{route('attendance.create')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon glyphicon-plus"></span> Add Attendance
            </a>
        </span>
        <span style="float: right;">
            <a href="{{route('leaves')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon glyphicon-plus"></span> Add Leave
            </a>
        </span>
    </div>
    <div class="panel-body">
        <span style="float: right;">
            <select class="form-control" id="selectOffice">
                <option value="1" @if($office_location_id == 1) selected @endif>GlowLogix Islamabad</option>
                <option value="2" @if($office_location_id == 2) selected @endif>GlowLogix Gujrat</option>
            </select>
        </span>
        <div id="calender">
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Manage Attendance</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="leave_type">Choose Type</label>
                                    <select class="form-control" name="leave_type" id="leave_type">
                                        <option selected value="present">Present</option>
                                        <option value="Full Leave">Full Leave</option>
                                        <option value="Half Leave">Half Leave</option>
                                        <option value="Short Leave">Short Leave</option>
                                        <option value="Paid Leave">Paid Leave</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-7">
                                        <label for="datefrom">StartDate</label>
                                        <div class='input-group date' id='datefrompicker' name="datefrompicker">
                                            <input type='text' id='datefrom' class="form-control" name="datefrom" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar" id="cl1"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <p id="hello"></p>
                                <div class="form-group">
                                    <div class="col-md-7">
                                        <label for="dateto">EndDate</label>
                                        <div class='input-group date' id='datetopicker' name="datetopicker">
                                            <input type='text' id='dateto' class="form-control" name="dateto" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="form-group">
                                        <div class="col-md-7" style="position:relative;top:10px">
                                            <button type="submit" id="update" data-dismiss="modal" class="btn btn-primary">Update</button>
                                            <button type="submit" id="del" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="currentStartTime">
                                <input type="hidden" id="currentEndTime">
                                <input type="hidden" id="currentStatus">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div id="calendar"> </div>

    <script type="text/javascript">
    $(document).ready(function(){
        $('#calendar').fullCalendar({
            "header":{
                "left":"prev,next today",
                "center":"title",
                "right":"month,agendaWeek,agendaDay"
            },
            "eventLimit":true,
            "editable":1,
            "eventClick":function(event, jsEvent, view) {
                if (event.title.search('Birthday') != -1) {
                    // window.location = "{{route('employees')}}/"+event.resourceId + "/" + event.date;
                    // console.log('found');
                }
                if (event.title.search('present') != -1) {
                    window.location = "{{route('attendance.create')}}/"+event.resourceId + "/" + event.date;
                }
                if (event.title.search('Leave') != -1) {
                    window.location = "{{route('leaves')}}/show/"+event.resourceId;
                }
            },
            "events": {!! $events !!}
        });

        $("#selectOffice").change(function(e){
            var url = "{{route('attendance')}}/" + $(this).val();
            
            if (url) {
                window.location = url; 
            }
            return false;
        });

        $(function () {
            $('#datefrompicker').datetimepicker({
            });
            $('#datetopicker').datetimepicker({
            });

        });
    });

</script>
<style type="text/css">
@if($office_location_id == 1)
    .fc-sat { background-color:lightgrey;}
@endif
    .fc-sun { background-color:lightgrey;}
</style>
</div>
@stop