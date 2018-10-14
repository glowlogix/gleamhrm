@extends('layouts.admin')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <b style="text-align: center;">Today Attendance</b>
        </div>
    </div>
    <div class="panel-body">
            <div id="calender">
                    {!! $calendar->calendar() !!}
                    
                    {!! $calendar->script() !!}
            </div>
    </div>
@endsection
