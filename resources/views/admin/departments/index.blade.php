@extends('layouts.admin')
@section('Heading')
    <button type="button" class="btn btn-info btn-rounded m-t-10 float-right" data-toggle="modal" data-target="#create">Add Department</button>
    <h3 class="text-themecolor">Departments</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
        <li class="breadcrumb-item active">Departments</li>
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
                            @if($departments->count() > 0)
                                <tr>
                                <td>#</td>
                                <th> Name</th>
                                <th> Status</th>
                                <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $key => $department)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$department->department_name}}</td>
                                        <td>{{$department->status}}</td>
                                        <td class="text-nowrap">
                                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{ $department->id }}"   data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
                                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $department->id }}"  data-original-title="Close"> <i class="fas fa-window-close text-white  "></i> </a>
                                            <div class="modal fade" id="confirm-delete{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('department.delete' , $department->id )}}" method="post">
                                                            {{ csrf_field() }}
                                                            <div class="modal-header">
                                                                Are you sure you want to delete this Department?
                                                            </div>
                                                            <div class="modal-header">
                                                                <h4>{{ $department->department_name }}</h4>
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
                                        <div class="modal fade" id="edit{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('department.update',['id'=>$department->id])}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Update Department
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Name</label>
                                                                <input  type="text" name="department_name" value="{{old('department_name',$department->department_name)}}" placeholder="Enter Department name here" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">status</label>
                                                                <select  name="status"  class="form-control">
                                                                    <option value="Active" @if($department->status == 'Active') selected @endif>Active</option>
                                                                    <option value="InActive" @if($department->status == 'InActive') selected @endif>InActive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button  type="submit" class="btn btn-success btn-ok">Update Department</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach @else
                                <tr> No Department Found</tr>
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
                <form action="{{route('department.create')}}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                       Create Department
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input  type="text" name="department_name" placeholder="Enter Department name here" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <select  name="status"  class="form-control">
                            <option value="Active">Active</option>
                            <option value="InActive">InActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button  type="submit" class="btn btn-info btn-ok">Add Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop