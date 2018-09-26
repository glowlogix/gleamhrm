@extends('layouts.admin') @section('content') 

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b> Update Job</b>
	</div>
	<div class="panel-body">

		<form action="{{route('job.update',['id'=>$job->id])}}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" name="title" value="{{$job->title}}" class="form-control">
			</div>
			<div class="form-group">
				<label for="featured">City</label>
				<input type="text" name="city" class="form-control" value="{{$job->city}}">
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" id="" cols="5" rows="5" class="form-control">{{$job->description}}</textarea>
			</div>

			<div class="form-group">
				<button class="btn btn-success center-block" type="submit"> Update Job</button>
			</div>
		</form>
	</div>

	@stop @section('styles')
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet"> @stop @section('scripts')
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
	<script>
		$(document).ready(function () {
			$('#summernote').summernote();
		});
	</script>
</div>
@stop
