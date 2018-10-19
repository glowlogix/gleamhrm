@extends('layouts.admin')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b>Create new User</b>
    </div>
    <div class="panel-body">
        <form action="{{route('user.store')}}" method="Post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Enter Name here" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Enter Name email Address" class="form-control">
            </div>
            <div class="form-group">
                <label for="admin">Admin</label>
                <br>
                <input type="hidden" name="admin" value="0" />
                
                <input type="checkbox" name="admin" value="1" />
            </div>
            <div class="form-group">
                <label for="email">Password</label>
                <input type="password" name="password" placeholder="Enter password here" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-success center-block" type="submit"> Create User</button>
            </div>
        </form>
    </div>
</div>
@stop