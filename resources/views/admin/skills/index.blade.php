@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Skills</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('skills') }}">Settings</a></li>
          <li class="breadcrumb-item active">Skills</li>
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
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#create" title="Add Skill"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Skill</span></button>
                        </div>

                        <hr>
                        
                        <div class="table-responsive">
                            <table id="skills" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> Skill Name</th>
                                        <th>Description</th>
                                        <th> Status</th>
                                        <th> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($skills as $key=>$skill)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$skill->skill_name}}</td>
                                            <td>{{$skill->description}}</td>
                                            <td>@if($skill->status==1)
                                                Active
                                                @else
                                                InActive
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#add{{$skill->id}}" title="Assign Skill To Employee"><i class="fas fa-plus text-white"></i></a>
                                                <a class="btn btn-success btn-sm" href="{{route('skill_assign.edit',['id'=>$skill->id])}}" title="Show Employees in Skill"> <i class="fas fa-eye text-white"></i></a>
                                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $skill->id }}" title="Edit Skill"> <i class="fas fa-pencil-alt text-white"></i></a>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $skill->id }}" title="Delete Skill"> <i class="fas fa-trash-alt text-white  "></i></a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="add{{$skill->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('skill.assign')}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Assign Skill "{{$skill->skill_name}}" To</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="text" name="skill_id" value="{{$skill->id}}" hidden>
                                                            <div class="form-group">
                                                                <label class="control-label">Employee</label>
                                                                <select  name="employee_id"  class="form-control">
                                                                    @foreach($employees as $employee)
                                                                        <option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-primary btn-ok" title="Assign Skill To Employee"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Assign</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="edit{{ $skill->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="editSkillForm{{$skill->id}}" action="{{route('skill.update',['id'=>$skill->id])}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Skill</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="control-label">Skill Name<span class="text-danger">*</span></label>
                                                                <input  type="text" name="skill_name" value="{{old('skill_name',$skill->skill_name)}}" placeholder="Enter Skill Name" class="form-control" id="skill_name{{$skill->id}}" oninput="check('skill_name'+{!! $skill->id !!});">
                                                                <span id="skill_name-error{{$skill->id}}" class="error invalid-feedback">Skill name is required</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Sattus</label>
                                                                <select  name="status"  class="form-control">
                                                                    <option value="1" @if($skill->status == 1) selected @endif>Active</option>
                                                                    <option value="0" @if($skill->status == 0) selected @endif>InActive</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Description<span class="text-danger">*</span></label>
                                                                <textarea  type="text" name="description" value="{{$skill->description}}" class="form-control" placeholder="Enter Description" id="description{{$skill->id}}" oninput="check('description'+{!! $skill->id !!});">{{$skill->description}}</textarea>
                                                                <span id="description-error{{$skill->id}}" class="error invalid-feedback">Description is required</span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button type="button" onclick="validate({!! $skill->id !!});" class="btn btn-primary btn-ok" title="Update Skill"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="confirm-delete{{ $skill->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('skill.delete' , $skill->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Skill</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete Skill "{{ $skill->skill_name}}"?
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-danger btn-ok" title="Delete Skill"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
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
                <form id="createSkillForm" action="{{route('skill.create')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h4 class="modal-title">Create Skill</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Skill Name<span class="text-danger">*</span></label>
                            <input  type="text" name="skill_name" placeholder="Enter Skill Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select  name="status"  class="form-control">
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description<span class="text-danger">*</span></label>
                            <textarea  type="text" name="description" class="form-control" placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                        <button  type="submit" class="btn btn-primary btn-ok" title="Create Skill"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
    $(document).ready(function () {
        $('#skills').DataTable({
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
        $('#createSkillForm').validate({
            rules: {
                skill_name: {
                    required: true
                },
                description: {
                    required: true
                }
            },
            messages: {
                skill_name: "Skill name is required",
                description: "Description is required",
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
        if($("#skill_name"+id).val() == '')
        {
            $('#skill_name-error'+id).addClass('show');
            $('#skill_name'+id).addClass('is-invalid');
        }
        if($("#description"+id).val() == '')
        {
            $('#description-error'+id).addClass('show');
            $('#description'+id).addClass('is-invalid');
        }
        if($("#description"+id).val() != '' && $("#skill_name"+id).val() != '')
        {
            $('#editSkillForm'+id).submit();
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