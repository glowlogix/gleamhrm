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
            <b style="text-align: center;">All Leaves</b>
        </div>
    </div>
    <div class="panel-body">
        <table class="table">
            <thead>
                <th>Leave Type</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Reason</th>
                <th>Status</th>                
                @if(Auth::user()->admin)
                <th>Manage Leaves</th>
                @endif
            </thead>
            <tbody class="table-bordered table-hover table-striped">
                @if(count($leaves) > 0) @foreach($leaves as $leave)
                <tr>
                    <td>{{$leave->leave_type}}</td>
                    <td>{{$leave->datefrom}}</td>
                    <td>{{$leave->dateto}}</td>
                    <td>{{$leave->reason}}</td>
                    <td>{{$leave->status}}</td>
                    
                    <td>
                        @if(Auth::user()->admin)
                        <form action="{{ route('leave.destroy' , $leave->employee_id )}}" method="post">
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <br>
                        <a class="btn btn-info btn-sm" href="{{route('leave.edit',['id'=>$leave->id])}}">Edit</a>

                        @endif
                    </td>
                </tr>
                @endforeach @else No leave found. @endif

            </tbody>
        </table>
    </div>

</div>



@stop