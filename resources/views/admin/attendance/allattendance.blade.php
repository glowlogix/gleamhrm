@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content')

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">All Attendance</b>
        </div>
        <div style="padding-left: 85%;">
                <a href="{{route('employee.create')}}" class="btn btn-info btn-xs" align="right">
                    <span class="glyphicon glyphicon-plus"></span> Add Attendance
                </a>
        </div>
    </div>
    <div class="panel-body">
        <div id="calender">

            {!! $calendar->calendar() !!}
            
            {!! $calendar->script() !!}

    </div>
</div>

</div>



@stop