@extends('layouts.admin')
@section('Heading')
    <button type="button"  onclick="window.location.href='{{route('attendance.createBreak')}}'" class="btn btn-info btn-rounded m-t-10 float-right"><span class="fas fa-plus" ></span> Add Attendance</button>
    <h3 class="text-themecolor">Dashboad</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Attendance</a></li>
        <li class="breadcrumb-item active">TimeLine</li>
    </ol>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <span style="float: left;"><input id="myTextBox" value="{{ Carbon\Carbon::now()->toDateString()}}" class="form-control" type="date" name="date"></span>
            <span style="float: right;">
                <select class="form-control" id="selectOffice">
                    <option value="0" @if($branch_id == 0) selected @endif>All Offices</option>
                    @foreach($office_locations as $office_location)
                    <option value="{{$office_location->id}}" @if($branch_id == $office_location->id) selected @endif>{{$office_location->name}}</option>
                    @endforeach
                </select>
            </span>
        <br><br>
            <div class="card">
                <div class="card-body">
                    <div id="calendar">
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
            defaultView: 'timelineMonth',
            weekends: 'Boolean',
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            displayEventTime: false,
            dow: [ 1, 2, 3, 4, 5 ],
            header: {
                left: 'today prev,next',
                center: 'title',
                right: 'timelineDay,timelineWeek,timelineMonth,timelineYear'
            },
            contentHeight:500,
            firstDay: 1,
            slotWidth : 100,
            resourceAreaWidth:300,
            resourceColumns: [
                {
                    labelText: 'Employees',
                    field: 'firstname',
                },
                {
                    field: 'lastname',
                },
            ],
                    eventClick:function(event, jsEvent, view) {
                if (event.title.search('Birthday') !== -1) {
                    // window.location = "{{route('employees')}}/"+event.resourceId + "/" + event.date;
                    // console.log('found');
                }
                if (event.title.search('present') !== -1) {
                    window.location = "{{route('attendance.createBreak')}}/"+event.resourceId + "/" + event.date;
                }
                if (event.title.search('leave') !== -1) {
                    window.location = "{{route('leaves')}}/show/"+event.resourceId;
                }
            },
            resources:{!! $employees !!},
            events:{!! $events !!}
        });
        $("#selectOffice").change(function(e){
            var url = "{{route('timeline')}}/" + $(this).val();

            if (url) {
                window.location = url;
            }
            return false;
        });
    });
    $("#myTextBox").on("change paste keyup", function() {
        $('#calendar').fullCalendar('gotoDate', $(this).val());
    });
</script>
@endpush
@stop