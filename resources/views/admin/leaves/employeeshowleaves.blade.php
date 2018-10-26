@extends('layouts.profile')
@section('content')
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
                        <form action="{{ route('leave.destroy' , $leave->employee_id )}}" method="post">
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
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