@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">All Leaves</h3>
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b style="text-align: center;">All Leaves</b>
        <span style="float: left;">
            <a href="{{route('leaves')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon glyphicon-plus"></span> Add Leave
            </a>
        </span>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <div class="col-md-6">
                <label for="name">Total Leaves:</label> {{$employee->allowed_leaves}}
            </div>
            <div class="col-md-6">
                <label for="name">Consumed Leaves:</label> {{$consumed_leaves}}
            </div>
        </div>
        <table class="table">
            <thead>
                <th>Leave Type</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Subject</th>
                <th>Status</th>                
                @if(Auth::user()->admin)
                <th>Manage Leaves</th>
                @endif
            </thead>
            <tbody class="table-bordered table-hover table-striped">
                @if(count($leaves) > 0) @foreach($leaves as $leave)
                <tr>
                    <td>{{$leave->leave_type}}</td>
                    <td>{{Carbon\Carbon::parse($leave->datefrom)->format('Y-m-d')}}</td>
                    <td>{{Carbon\Carbon::parse($leave->dateto)->format('Y-m-d')}}</td>
                    <td>{{$leave->subject}}</td>
                    <td>{{($leave->status != '') ? $leave->status : 'Pending'}}</td>
                    <td>
                        @if(Auth::user()->admin)
                        @endif
                        <form action="{{ route('leave.destroy' , $leave->employee_id )}}" method="post">
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a class="btn btn-info btn-sm" href="{{route('leave.edit',['id'=>$leave->id])}}">Edit</a>
                    </td>
                </tr>
                @endforeach @else No leave found. @endif
            </tbody>
        </table>
    </div>
</div>

@stop