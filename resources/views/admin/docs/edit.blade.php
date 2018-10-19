@extends('layouts.admin')  @section('content')


<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Document</b>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{route('documents.update',['id'=>$document->id])}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="documentname">Name</label>
                <input type="text" name="document_name" value="{{$document->name}}" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="documents">Document:</label>
                <input type="file" class="" name="document" />
                {{$document->url}}
            </div>

            <div class="form-group">
                <label for="upload_status">Status</label>
                {{ csrf_field() }}
                <select name="upload_status" id="upload_status" class="form-control">
                    @if($document->status == 1)
                    <option selected value="1">Enable</option>
                    <option value="0">Disable</option>
                    @else
                    <option value="1">Enable</option>
                    <option selected value="0">Disable</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <a href="{{route('documents')}}" class="btn btn-success" align="right">Cancel</a>
                <button class="btn btn-success" type="submit"> Update</button>
            </div>
        </form>
    </div>
</div>
 @stop