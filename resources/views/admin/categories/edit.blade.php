@extends('layouts.admin')
@section('title')
{{ config('app.name', 'HRM') }}|{{$title}}
@endsection
@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

@endsection
@section('scripts2')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


@endsection
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
