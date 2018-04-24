@extends('layouts.admin') @section('title') {{ config('app.name', 'HRM') }}|{{$title}} @endsection @section('content')
@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

@endsection
@section('scripts2')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


@endsection
<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">All Attendance</b>
        </div>
    </div>
    <div class="panel-body">
        <table class="table">
            <thead>
                <th>Delays</th>
                <th>CheckinTime</th>
                <th>CheckoutTime</th>
                @if(Auth::user()->admin)
                <th>Manage Attendance</th>
                @endif
            </thead>
            <tbody class="table-bordered table-hover table-striped">
                @if(count($attendances) > 0) @foreach($attendances as $attendance)
                <tr>
                    <td>{{$attendance->delay}}</td>
                    <td>{{date('Y/m/d g:i A',strtotime($attendance->checkintime))}}</td>
                    <td>{{date('Y/m/d g:i A',strtotime($attendance->checkouttime))}}</td>
                    <td>
                        @if(Auth::user()->admin)
                        <form action="{{ route('attendance.destroy' , ['id' => $attendance->id] )}}" method="post">
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <br>
                        <a class="btn btn-info btn-sm" href="{{route('attendance.edit',['id'=>$attendance->id])}}">Edit</a>

                        @endif
                    </td>
                </tr>
                @endforeach @else No Attendance found. @endif

            </tbody>
        </table>
    </div>

</div>



@stop