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
                                    <th> Team Name</th>
                                    <th> Department Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>{{$team->name}}</td>
                                    <td>{{isset($team->department_id) ? $team->department->department_name : ''}}</td>
                                    <td class="text-nowrap">
                                        <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $team->id }}"   data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $team->id }}"  data-original-title="Close"> <i class="fas fa-window-close text-white  "></i> </a>
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
                                                                <option value="{{$department->id}}" @if($team->department_id == $department->id) selected @endif>{{$department->department_name}}</option>
                                                            @endforeach
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
                                </tr>
                            @endforeach @else
                                <tr> No Department found.</tr>
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