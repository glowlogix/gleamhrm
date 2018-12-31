@extends('layouts.admin')
@section('Heading')
    <button type="button" class="btn btn-info btn-rounded m-t-10 float-right" data-toggle="modal" data-target="#create"><span class="fas fa-plus"></span> Add Team</button>
    <h3 class="text-themecolor">Teams</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Employee Mgmt</li>
        <li class="breadcrumb-item active">Teams</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle"></h6>
                    <div class="table">
                        <table id="demo-foo-addrow" class="table  m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
                            <thead>
                            @if($teams->count() > 0)
                                <tr>
                                    <th>#</th>
                                    <th>Team Name</th>
                                    <th>Department Name</th>
                                    <th>Status</th>
                                    <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($teams as $key => $team)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$team->name}}</td>
                                    <td>{{isset($team->department_id) ? $team->department->department_name : ''}}</td>
                                    <td>@if($team->status==1)
                                            Active
                                        @else
                                        InActive
                                            @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $team->id }}"   data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $team->id }}"  data-original-title="Close"> <i class="fas fa-window-close text-white  "></i> </a>
                                        <span data-toggle="tooltip"  data-original-title="Click To Add Member To Team"><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add{{$team->id}}"> <i class="fas fa-plus text-white"></i></a></span>
                                        <span data-toggle="tooltip"  data-original-title="View Team members"><a class="btn btn-success btn-sm" href="{{route('team_member.edit',['id'=>$team->id])}}" title="Edit Team" > <i class="fas fa-eye text-white"></i></a></span>
                                        <div class="modal fade" id="confirm-delete{{ $team->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('team.delete' , $team->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Are you sure you want to delete this Team?
                                                        </div>
                                                        <div class="modal-header">
                                                            <h4>{{ $team->name}}</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="edit{{ $team->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{route('team.update',['id'=>$team->id])}}" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="modal-header">
                                                        Update Team
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Team Name</label>
                                                            <input  type="text" name="name" value="{{old('team-name',$team->name)}}" placeholder="Enter Department name here" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Department</label>
                                                            <select  name="dept_id"  class="form-control">
                                                                @foreach($departments as $department)
                                                                    <option value="{{$department->id}}" @if($team->department_id == $department->id ) selected @endif>{{$department->department_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Status</label>
                                                            <select  name="status"  class="form-control">
                                                                <option value="1" @if($team->status == 1) selected @endif>Active</option>
                                                                <option value="0" @if($team->status == 0) selected @endif>InActive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button  type="submit" class="btn btn-success btn-ok">Update Team</button>
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
                                                        Add Employee to Team {{$team->name}}
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <input type="text" name="team_id" value="{{$team->id}}" hidden>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="control-label">Employee</label>
                                                            <select  name="team_member"  class="form-control">
                                                                @foreach($employees as $employee)
                                                                    <option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button  type="submit" class="btn btn-success btn-ok">Add Employee To Team</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach @else
                                <tr> No Teams Found</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('team.create')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        Create Team
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Team Name</label>
                            <input  type="text" name="team_name" placeholder="Enter Team Name here" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Department</label>
                            <select  name="department_id"  class="form-control">
                                @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->department_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select  name="status"  class="form-control">
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button  type="submit" class="btn btn-info btn-ok">Add Team</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop