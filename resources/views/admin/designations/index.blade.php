@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Designations</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('branch') }}">Settings</a></li>
          <li class="breadcrumb-item active">Designations</li>
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
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#create" title="Add Designation"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Designation</span></button>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table id="designations" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Designation Name</th>
                                        <th class="text-center">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($designations as $key=>$designation)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$designation->designation_name}}</td>
                                            <td class="text-center">
                                                @if($designation->status == 1)
                                                    <div class="text-white badge badge-success font-weight-bold">Enabled</div>
                                                @else
                                                    <div class="text-white badge badge-danger font-weight-bold">Disabled</div>
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $designation->id }}" title="Edit Designation"> <i class="fas fa-pencil-alt text-white"></i></a>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $designation->id }}" title="Delete Designation"> <i class="fas fa-trash-alt text-white"></i> </a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="confirm-delete{{ $designation->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('designation.delete' , $designation->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Designation</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete Designation "{{$designation->designation_name}}"?
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-danger btn-ok" title="Delete Designation"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="edit{{ $designation->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="editDesignationForm{{$designation->id}}" action="{{route('designation.update',['id'=>$designation->id])}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Designation</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="control-label">Designation Name<span class="text-danger">*</span></label>
                                                                <input  type="text" name="name" value="{{old('name',$designation->designation_name)}}" placeholder="Enter Designation Name" class="form-control" id="designation_name{{$designation->id}}" oninput="check('designation_name'+{!! $designation->id !!});">
                                                                <span id="designation_name-error{{$designation->id}}" class="error invalid-feedback">Designation name is required</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Status</label>
                                                                <select name="status" class="form-control">
                                                                   <option value="1" @if($designation->status==1) selected @endif>Enable</option>
                                                                    <option value="0" @if($designation->status==0) selected @endif>Disable</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button type="button" onclick="validate({!! $designation->id !!});" class="btn btn-primary btn-ok" title="Update Designation"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
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
                <form id="createDesignationForm" action="{{route('designation.create')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Create Designation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Designation Name<span class="text-danger">*</span></label>
                            <input  type="text" name="designation_name" placeholder="Enter Designation Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                        <button  type="submit" class="btn btn-primary btn-ok" title="Create Designation"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
    $(document).ready(function () {
        $('#designations').DataTable({
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
        $('#createDesignationForm').validate({
            rules: {
                designation_name: {
                    required: true
                }
            },
            messages: {
                designation_name: "Designation name is required"
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
        if($("#designation_name"+id).val() == '')
        {
            $('#designation_name-error'+id).addClass('show');
            $('#designation_name'+id).addClass('is-invalid');
        }
        else
        {
            $('#editDesignationForm'+id).submit();
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