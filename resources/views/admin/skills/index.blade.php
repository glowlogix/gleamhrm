@extends('layouts.admin')
@section('Heading')
    <button type="button" class="btn btn-info btn-rounded m-t-10 float-right" data-toggle="modal" data-target="#create"><span class="fas fa-plus"></span> Add Skill</button>
    <h3 class="text-themecolor">Skills</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
        <li class="breadcrumb-item active">Skills</li>
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
                            @if($skills->count() > 0)
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
                                        <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $skill->id }}"   data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $skill->id }}"  data-original-title="Close"> <i class="fas fa-window-close text-white  "></i> </a>
                                        <div class="modal fade" id="confirm-delete{{ $skill->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('skill.delete' , $skill->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Are you sure you want to delete this Skill?
                                                        </div>
                                                        <div class="modal-header">
                                                            <h4>{{ $skill->skill_name}}</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <span data-toggle="tooltip"  data-original-title="Click To Assign Skill To Employee"><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add{{$skill->id}}"> <i class="fas fa-plus text-white"></i></a></span>
                                        <span data-toggle="tooltip"  data-original-title="View/Edit This Skilled Employees"><a class="btn btn-success btn-sm" href="{{route('skill_assign.edit',['id'=>$skill->id])}}"> <i class="fas fa-eye text-white"></i></a></span>
                                        <div class="modal fade" id="add{{$skill->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('skill.assign')}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Assign Skill " {{$skill->skill_name}} " To
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <input type="text" name="skill_id" value="{{$skill->id}}" hidden>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label class="control-label">Employee</label>
                                                                <select  name="employee_id"  class="form-control">
                                                                    @foreach($employees as $employee)
                                                                        <option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button  type="submit" class="btn btn-success btn-ok">Assign</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="edit{{ $skill->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{route('skill.update',['id'=>$skill->id])}}" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="modal-header">
                                                        Update Skill
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Skill Name</label>
                                                            <input  type="text" name="skill_name" value="{{old('skill_name',$skill->skill_name)}}" placeholder="Enter Skill Name Here" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Sattus</label>
                                                            <select  name="status"  class="form-control">
                                                                <option value="1" @if($skill->status == 1) selected @endif>Active</option>
                                                                <option value="0" @if($skill->status == 0) selected @endif>InActive</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Description</label>
                                                            <textarea  type="text" name="description" value="{{$skill->description}}" class="form-control">{{$skill->description}}</textarea>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button  type="submit" class="btn btn-success btn-ok">Update Skill</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach @else
                                <tr> No Skill Found</tr>
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
                <form action="{{route('skill.create')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        Create Skill
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Skill Name</label>
                            <input  type="text" name="skill_name" placeholder="Enter Skill Name here" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select  name="status"  class="form-control">
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea  type="text" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button  type="submit" class="btn btn-info btn-ok">Add Skill</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop