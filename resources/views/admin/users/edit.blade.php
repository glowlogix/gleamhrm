@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Edit User</h3>
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b>Update User</b>
    </div>
    <div class="panel-body">
        <form action="{{route('user.update',['id'=>$user->id])}}" method="Post">
            {{csrf_field()}}        
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{$user->name}}" placeholder="Enter Name here" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email"  value="{{$user->email}}" placeholder="Enter Name email Address" class="form-control">
            </div>
            <div class="form-group">
                <label for="admin">is Admin</label>
                <br>
                
                @if($user->admin == "1")                
                <input type="checkbox" checked name="admin" value="1" />
                @else
                <input type="checkbox" name="admin" value="1" />
                @endif
            </div>
            <div class="form-group">
                <label for="email">Password</label>
                <input type="password" name="password" placeholder="Enter password here" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Enter confirm password here" class="form-control" required>
            </div>
            <div class="form-group">
                <button class="btn btn-success center-block" type="submit"> Update</button>
            </div>
        </form>
    </div>
</div>

@stop