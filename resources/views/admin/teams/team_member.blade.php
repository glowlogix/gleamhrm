@extends('layouts.admin')
@section('Heading')
    {{--<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('team_member.create')}}'"><span class="fas fa-plus"></span> Add Team Members</button>--}}
    <h3 class="text-themecolor">Team Members</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">People Management</li>
        <li class="breadcrumb-item active">Team Members</li>
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
                                    <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>{{$team->name}}</td>
                                    <td class="text-nowrap">
                                        <span data-toggle="tooltip"  data-original-title="Click To Add Member To Team"><a class="btn btn-info btn-sm" data-toggle="modal" data-target="#add{{$team->id}}"> <i class="fas fa-plus text-white"></i></a></span>
                                        <span data-toggle="tooltip"  data-original-title="Edit Team members"><a class="btn btn-info btn-sm" href="{{route('team_member.edit',['id'=>$team->id])}}" title="Edit Team" > <i class="fas fa-pencil-alt text-white"></i></a></span>
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
                                                                    <option value="{{$employee->id}}">{{$employee->firstname}}</option>
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
                                    </td>
                                </tr>
                            @endforeach @else
                                <tr> No Vendor found.</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop