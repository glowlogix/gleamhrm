@extends('layouts.admin')
@section('Heading')
    <button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('sub_skill.index')}}'" >Back</button>
    <h3 class="text-themecolor">Sub Skill</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
        <li class="breadcrumb-item active">Sub Skills</li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        Sub-Skill Of Parent Skill "{{$skill_name->skill_name}}"
                    </h3>
                    <div class="table">
                        <table id="demo-foo-addrow" class="table  m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
                            <thead>
                            @if($sub_skills->count() > 0)
                                <tr>
                                    <th>Sub Skill Name</th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($sub_skills as $sub_skill)
                                <tr>
                                    <td> {{$sub_skill->sub_skill_name}}</td>
                                    <td class="text-nowrap">
                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $sub_skill->id }}"  data-original-title="Close"> <i class="fas fa-window-close text-white  "></i> </a>
                                        <div class="modal fade" id="confirm-delete{{ $sub_skill->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('sub_skill.delete' , $sub_skill->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Are you sure you want to delete this Sub-SKill?
                                                        </div>
                                                        <div class="modal-header">
                                                            <h4>{{$sub_skill->sub_skill_name}}</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $sub_skill->id }}"  data-original-title="Close"> <i class="fas fa-pencil-alt text-white"></i> </a>
                                        <div class="modal fade" id="edit{{ $sub_skill->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('sub_skill.sub_edit',$sub_skill->id)}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Update Skill
                                                        </div>
                                                        <br>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label class="control-label">Sub-Skill Name:</label>
                                                                <input class="form-control" type="text" name="sub_skill_name" value="{{old('sub_skill_name',$sub_skill->sub_skill_name)}}">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button  type="submit" class="btn btn-danger btn-ok">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach @else
                                <tr> No Sub-Skill Found</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop