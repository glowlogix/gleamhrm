@extends('layouts.admin') @section('content')

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b style="text-align: center;">All Attendance</b>
        <span style="float: right;">
            <a href="{{route('attendance.create')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon glyphicon-plus"></span> Add Attendance
            </a>
        </span>
    </div>
    <div class="panel-body">
        <div id="calendar">
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            defaultView: 'timelineMonth',
            weekends: 'Boolean, default: true',
            header: {
                left: 'today prev,next',
                center: 'title',
                right: 'timelineDay,timelineWeek,timelineMonth'
            },
            resourceLabelText: 'Employees',
            resourceColumns: [
                {
                    labelText: 'Employee',
                    field: 'firstname',
                    // title: 'firstname',
                    // title: 'firstname',
                },
            ],
            resources: {!! $employees !!},
            events: {!! $events !!}
        });
    });

</script>
<style type="text/css">
.fc-fri { color:blue; }
.fc-sat { color:red;  }
</style>
</div>
@stop