@extends('layouts.admin')

@section('content')
@include('admin.includes.errors')
	
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<b>	Update Category <b>
		</div>
	
		<div class="panel-body">
			<form action="{{route('category.update',['id'=>$category->id])}}" method="Post">
				{{csrf_field()}}
				<div class="form-group">
					<label for="name" value="{{$category->name}}" >Name</label>
					<input type="text" name="name" value="{{$category->name}}" class="form-control">
				</div>
				<div class="form-group">
					<button class="btn btn-success center-block" type="submit"> Update Category</button>
				</div>
			</form>
		</div>
	</div>

@stop
