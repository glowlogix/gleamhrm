@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Types</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('leave_types') }}">Settings</a></li>
          <li class="breadcrumb-item active">Leave Management</li>
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
                        <div class="text-right">
                            <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#create" title="Add Leave Type"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Leave Type</span></button>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table id="leave_types" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>Name</th>
                                        <th>Count</th>
                                        <th class="text-center">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leave_types as $key =>$leave_type)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$leave_type->name}}</td>
                                            <td>{{$leave_type->count}}</td>
                                            <td class="text-center">
                                                @if($leave_type->status==1)
                                                    <div class="text-white badge badge-success font-weight-bold">Active</div>
                                                @else
                                                    <div class="text-white badge badge-danger font-weight-bold">InActive</div>
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $leave_type->id }}" title="Edit Leave Type"><i class="fas fa-pencil-alt text-white"></i></a>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $leave_type->id }}" title="Delete Leave Type"><i class="fas fa-trash-alt text-white"></i></a>                                        
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="edit{{ $leave_type->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="updateLeaveTypeForm{{$leave_type->id}}" action="{{route('leave_type.update',['id'=>$leave_type->id])}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Leave Type</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="control-label">Name<span class="text-danger">*</span></label>
                                                                <input  type="text" name="name" value="{{old('name',$leave_type->name)}}" placeholder="Enter Name Here" class="form-control" id="leave_type_name{{$leave_type->id}}" oninput="check('leave_type_name'+{!! $leave_type->id !!});">
                                                                <span id="leave_type_name-error{{$leave_type->id}}" class="error invalid-feedback">Designation name is required</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Count<span class="text-danger">*</span></label>
                                                                <input  type="number" name="amount" value="{{old('count',$leave_type->count)}}" placeholder="Enter Amount Here" class="form-control" id="leave_type_amount{{$leave_type->id}}" oninput="check('leave_type_amount'+{!! $leave_type->id !!});">
                                                                <span id="leave_type_amount-error{{$leave_type->id}}" class="error invalid-feedback">Designation name is required</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Status</label>
                                                                <select  name="status"  class="form-control">
                                                                    <option value="1" @if($leave_type->status==1)Selected @endif>Active</option>
                                                                    <option value="0" @if($leave_type->status==0)Selected @endif>InActive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <a onclick="validate({!! $leave_type->id !!});" class="btn btn-primary btn-ok" title="Update Leave Type"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="confirm-delete{{ $leave_type->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('leave_type.delete' , $leave_type->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Leave Type</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete Leave Type {{ $leave_type->name }}?
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-danger btn-ok" title="Delete Leave Type"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
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
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="leaveTypeForm" action="{{route('leave_type.create')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Create Leave Type</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name<span class="text-danger">*</span></label>
                            <input  type="text" name="name" placeholder="Enter Name Here" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Count<span class="text-danger">*</span></label>
                            <input  type="number" name="amount" placeholder="Enter Amount Here" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">UnActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                        <button  type="submit" class="btn btn-primary btn-ok" title="Create Leave Type"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
    $(document).ready(function () {
        $('#leave_types').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    $(function () {
        $('#leaveTypeForm').validate({
            rules: {
                name: {
                    required: true
                },
                amount: {
                    required: true
                }
            },
            messages: {
                name: "Name is required",
                amount: "Count is required"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    function validate(id)
    {
        if($("#leave_type_name"+id).val() == '')
        {
            $('#leave_type_name-error'+id).addClass('show');
            $('#leave_type_name'+id).addClass('is-invalid');
        }
        else if($("#leave_type_amount"+id).val() == '')
        {
            $('#leave_type_amount-error'+id).addClass('show');
            $('#leave_type_amount'+id).addClass('is-invalid');
        }
        else
        {
            $('#updateLeaveTypeForm'+id).submit();
        }
    }

    function check(id)
    {
        if($('#'+id).val() != '')
        {
            $('#'+id).removeClass('show');
            $('#'+id).removeClass('is-invalid');
        }
        else
        {
            $('#'+id).addClass('show');
            $('#'+id).addClass('is-invalid');
        }
    }
</script>
@stop