@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Teams</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('teams') }}">People Management</a></li>
          <li class="breadcrumb-item active">Teams</li>
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
                            <button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#create" title="Add Team"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Team</span></button>
                        </div>

                        <hr>
                        
                        <div class="table-responsive">
                            <table id="teams" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Team Name</th>
                                        <th>Department Name</th>
                                        <th class="text-center">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $key => $team)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$team->name}}</td>
                                            <td>{{isset($team->department_id) ? $team->department->department_name : ''}}</td>
                                            <td class="text-center">
                                                @if($team->status==1)
                                                    <div class="text-white badge badge-success font-weight-bold">Active</div>
                                                @else
                                                    <div class="text-white badge badge-danger font-weight-bold">InActive</div>
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <span data-toggle="tooltip" title="Click To Add Team Member"><a class="btn btn-info btn-sm" data-toggle="modal" data-target="#add{{$team->id}}"> <i class="fas fa-plus text-white"></i></a></span>
                                                <span data-toggle="tooltip" title="View Team members"><a class="btn btn-success btn-sm" href="{{route('team_member.edit',['id'=>$team->id])}}" title="View Team Members" > <i class="fas fa-eye text-white"></i></a></span>
                                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $team->id }}"   title="Edit Team"><i class="fas fa-pencil-alt text-white"></i></a>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $team->id }}"  title="Delete Team"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="confirm-delete{{ $team->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('team.delete' , $team->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Team</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete Team "{{ $team->name}}"?
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-danger btn-ok" title="Delete Team"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="edit{{ $team->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="updateTeamForm{{$team->id}}" action="{{route('team.update',['id'=>$team->id])}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Team</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-12 pl-0 pr-0">
                                                                <div class="form-group">
                                                                    <label class="control-label">Team Name<span class="text-danger">*</span></label>
                                                                    <input  type="text" name="name" id="team_name{{$team->id}}" value="{{old('team-name',$team->name)}}" placeholder="Enter Department name here" class="form-control" oninput="check('team_name'+{!! $team->id !!});">
                                                                    <span id="team_name-error{{$team->id}}" class="error invalid-feedback">Team name is required</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 pl-0 pr-0">
                                                                <div class="form-group">
                                                                    <label class="control-label">Department</label>
                                                                    <select  name="dept_id"  class="form-control">
                                                                        @foreach($departments as $department)
                                                                            <option value="{{$department->id}}" @if($team->department_id == $department->id ) selected @endif>{{$department->department_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 pl-0 pr-0">
                                                                <div class="form-group">
                                                                    <label class="control-label">Status</label>
                                                                    <select  name="status"  class="form-control">
                                                                        <option value="1" @if($team->status == 1) selected @endif>Active</option>
                                                                        <option value="0" @if($team->status == 0) selected @endif>InActive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <a onclick="validate({!! $team->id !!});" class="btn btn-primary btn-ok" title="Update Team"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="add{{$team->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('team_member.add')}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Add Employee to Team {{$team->name}}</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <input type="text" name="team_id" value="{{$team->id}}" hidden>
                                                        <div class="modal-body">
                                                            <div class="col-12 pl-0 pr-0">
                                                                <div class="form-group">
                                                                    <label class="control-label">Employee</label>
                                                                    <select  name="team_member"  class="form-control">
                                                                        @foreach($employees as $employee)
                                                                            <option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button  type="submit" class="btn btn-primary btn-ok" title="Add Employee To Team"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Employee To Team</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="createTeamForm" action="{{route('team.create')}}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-header">
                                            <h4 class="modal-title">Create Team</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-12 pl-0 pr-0">
                                                <div class="form-group">
                                                    <label class="control-label">Team Name<span class="text-danger">*</span></label>
                                                    <input  type="text" name="team_name" placeholder="Enter Team Name here" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 pl-0 pr-0">
                                                <div class="form-group">
                                                    <label class="control-label">Department</label>
                                                    <select  name="department_id"  class="form-control">
                                                        @foreach($departments as $department)
                                                        <option value="{{$department->id}}">{{$department->department_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 pl-0 pr-0">
                                                <div class="form-group">
                                                    <label class="control-label">Status</label>
                                                    <select  name="status"  class="form-control">
                                                        <option value="1">Active</option>
                                                        <option value="0">InActive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                            <button  type="submit" class="btn btn-primary btn-ok" title="Create Team"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        $('#teams').DataTable({
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
        $('#createTeamForm').validate({
            rules: {
                team_name: {
                    required: true,
                }
            },
            messages: {
                team_name: "Team name is required"
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
        if($("#team_name"+id).val() == '')
        {
            $('#team_name-error'+id).addClass('show');
            $('#team_name'+id).addClass('is-invalid');
        }
        else
        {
            $('#updateTeamForm'+id).submit();
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