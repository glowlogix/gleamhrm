@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Update Document</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
        <li class="breadcrumb-item active">Document</li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-body">
                <form  action="{{route('documents.update',['id'=>$document->id])}}" method="post">
                    {{csrf_field()}}
                    <div class="form-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" value="{{$document->name}}"  name="document_name" class="form-control" placeholder="Enter Title">
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label">Status</label>
                                {{ csrf_field() }}
                                <select name="upload_status" class="form-control custom-select">
                                    @if($document->status == 1)
                                        <option selected value="1">Enable</option>
                                        <option value="0">Disable</option>
                                    @else
                                        <option value="1">Enable</option>
                                        <option selected value="0">Disable</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        &nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Update Document </button>
                        <button type="button" onclick="window.location.href='{{url('documents')}}'" class="btn btn-inverse">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop