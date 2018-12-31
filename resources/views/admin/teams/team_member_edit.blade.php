@extends('layouts.admin')
@section('Heading')
    <button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('teams.index')}}'" >Back</button>
    <h3 class="text-themecolor">Departments</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Employee Mgmt</li>
        <li class="breadcrumb-item active">Teams</li>
        <li class="breadcrumb-item active">Team Members</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                       Member Of Team "{{$team_name->name}}"
                    </h3>
                    <div class="table">
                        <table id="demo-foo-addrow" class="table  m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
                            <thead>
                            @if($team_members->count() > 0)
                                <tr>
                                    <th>#</th>
                                    <th>Employee_Name</th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($team_members as $key=>$team_member)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td> {{isset($team_member->id) ? $team_member->employee->firstname . $team_member->employee->lastname : ''}}</td>
                                    <td class="text-nowrap">
                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $team_member->id }}"  data-original-title="Close"> <i class="fas fa-window-close text-white  "></i> </a>
                                        <div class="modal fade" id="confirm-delete{{ $team_member->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('team_member.delete' , $team_member->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Are you sure you want to delete this Employee Form Team?
                                                        </div>
                                                        <div class="modal-header">
                                                            <h4>{{isset($team_member->id) ? $team_member->employee->firstname : ''}}</h4>
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
                                </tr>
                            @endforeach @else
                                <tr> No Team Member Found</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop