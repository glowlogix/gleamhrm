@extends('layouts.admin')
@section('title')
{{ config('app.name', 'HRM') }}|{{$title}}
@endsection
@section('content')
@include('admin.includes.errors')
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<b>	Create new Category <b>
		</div>
	
		<div class="panel-body">
			<form action="{{route('category.store')}}" method="Post">
				{{csrf_field()}}
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" placeholder="Enter Name here" class="form-control">
				</div>
				<div class="form-group">
					<button class="btn btn-success center-block" type="submit"> Create Category</button>
				</div>
			</form>
		</div>
	</div>
@stop
