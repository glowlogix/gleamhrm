@extends('layouts.admin')  @section('content')


<div class="panel panel-default">
    <div class="panel-heading text-center">
        <div>
            <b style="text-align: center;">Update Document</b>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{route('documents.docs.update',['id'=>$document->id])}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="documentname">Name</label>
                <input type="text" name="documentname" value="{{$document->name}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="url">Status</label>
                        {{ csrf_field() }}
                        <div>
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
                        <br>
                    <button class="btn btn-success center-block" type="submit"> Update</button>
            </div>
        </form>
    </div>
</div>
 @stop