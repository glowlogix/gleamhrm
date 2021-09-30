@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Leaves</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('employee_leaves') }}">Attendance</a></li>
          <li class="breadcrumb-item active">Leaves</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
  <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <select class="form-control col-2" id="filter">
                                <option>All</option>
                                <option @if($id=='Approved') selected @endif>Approved</option>
                                <option @if($id=='Declined') selected @endif >Declined</option>
                            </select>
                            @if(Auth::user()->isAllowed('LeaveController:adminCreate'))
                                <button type="button"  onclick="window.location.href='{{route('admin.createLeave')}}'" class="btn btn-info btn-rounded" title="Add Employee Leave"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Employee Leave</span></button>
                            @endif
                        </div>
                        
                        <hr>

                        <div class="table-responsive">
                            <table id="leaves" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Subject</th>
                                        <th class="text-center">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td>
                                            @foreach($leaveEmployees as $leaveEmployee)
                                                @if($leaveEmployee->id == $employee->employee_id)
                                                    {{$leaveEmployee->firstname}} {{$employee->lastname}} 
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$employee->leaveType->name}}</td>
                                        <td>{{Carbon\Carbon::parse($employee->datefrom)->format('d-m-Y')}}</td>
                                        <td>{{Carbon\Carbon::parse($employee->dateto)->format('d-m-Y')}}</td>
                                        <td>{{$employee->leave_subject}}</td>
                                        <td class="text-center">
                                            @if($employee->leave_status == '' || strtolower($employee->leave_status) == 'pending')
                                                @if(Auth::user()->id == 1 || (Auth::user()->id != $employee->id))
                                                    <form id="statusForm" action="/leave/updateStatus" method="post">
                                                        {{csrf_field()}}
                                                        <input type="text" name="id" value="{{$employee->leave_id}}" hidden>
                                                        <input type="text" name="email" value="@if(isset($platform->hr_email)) {{$platform->hr_email}} @else @if(isset($platform->email)) {{$platform->email}} @else noreply@email.com @endif @endif" hidden>
                                                        <select class="form-control" name="status" style="width:160px;" onchange="$('#statusForm').submit();">
                                                            <option value="">Update Status</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Declined">Declined</option>
                                                        </select>
                                                    </form>
                                                @endif
                                            @endif

                                            @if(strtolower($employee->leave_status) == 'approved')
                                                <div class="text-white badge badge-success font-weight-bold">{{$employee->leave_status}}</div>
                                            @endif
                                            @if(strtolower($employee->leave_status) == 'declined')
                                            <div class="text-white badge badge-danger font-weight-bold">{{$employee->leave_status}}</div>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            @if(
                                                ($employee->leave_status == 'Pending' && $employee->leave_status == '')
                                            )
                                            @endif
                                            <a class="btn btn-info btn-sm" href="{{route('leave.show',['id'=>$employee->leave_id])}}" title="Show Leave"> <i class="fas fa-eye text-white "></i></a>
                                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{$employee->leave_id }}" title="Delete Leave"><i class="fas fa-trash-alt text-white"></i></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="confirm-delete{{$employee->leave_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('leave.delete' , $employee->leave_id)}}" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Delete Leave</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this Leaves?
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                        <button  type="submit" class="btn btn-danger btn-ok" title="Delete Leave"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
    $(document).ready(function () {
        $("#filter").change(function(e){
                var url = "{{route('employeeleaves')}}/" + $(this).val();

            if (url) {
                window.location = url;
            }
            return false;
        });
    });

    $(document).ready(function () {
        $('#leaves').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
    });
</script>
@stop