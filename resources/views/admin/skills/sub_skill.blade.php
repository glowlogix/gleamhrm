@extends('layouts.admin')
@section('Heading')
    {{--<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('team_member.create')}}'"><span class="fas fa-plus"></span> Add Team Members</button>--}}
    <h3 class="text-themecolor">Sub Skill</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
        <li class="breadcrumb-item active">Sub Skill</li>
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
                                    <th> Skill Name</th>
                                    <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($skills as $skill)
                                <tr>
                                    <td>{{$skill->skill_name}}</td>
                                    <td class="text-nowrap">
                                        <span data-toggle="tooltip"  data-original-title="Click To Add Sub Skill"><a class="btn btn-info btn-sm" data-toggle="modal" data-target="#add{{$skill->id}}"> <i class="fas fa-plus text-white"></i></a></span>
                                        <span data-toggle="tooltip"  data-original-title="Edit Sub Skill"><a class="btn btn-info btn-sm" href="{{route('sub_skill.edit',['id'=>$skill->id])}}" title="Edit Team" > <i class="fas fa-pencil-alt text-white"></i></a></span>
                                        <div class="modal fade" id="add{{$skill->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('sub_skill.add')}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Add Sub Skill To Parent Skill  " {{$skill->skill_name}} "
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <input type="text" name="skill_id" value="{{$skill->id}}" hidden>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label class="control-label">Sub-Skill Name:</label>
                                                               <input class="form-control" type="text" name="sub_skill_name">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button  type="submit" class="btn btn-success btn-ok">Add Sub Skill</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
@stop