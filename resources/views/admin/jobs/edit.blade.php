@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Update Job</h3>
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">

			<div class="card-body">
				<form action="{{route('job.update',['id'=>$job->id])}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-body">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Title</label>
								<input type="text" value="{{$job->title}}"  name="title" class="form-control" placeholder="Enter Title">
							</div>
						</div>

					</div>
					<div class="form-body">

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">City</label>
								<input type="text" value="{{$job->city}}"  name="city" class="form-control" placeholder="Enter City">
							</div>
						</div>

					</div>
					<div class="form-body">
						<div class="col-md-8" >
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea name="description"  rows="5" class="form-control " placeholder="Enter Description Here">{{$job->description}}</textarea>
							</div>
						</div>

					</div>

					<div class="form-actions">
						&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Update Job</button>
						<button type="button" onclick="window.location.href='{{route('jobs')}}'" class="btn btn-inverse">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>

@stop


{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<b> Update Job</b>--}}
	{{--</div>--}}
	{{--<div class="panel-body">--}}

		{{--<form action="{{route('job.update',['id'=>$job->id])}}" method="post" enctype="multipart/form-data">--}}
			{{--{{csrf_field()}}--}}
			{{--<div class="form-group">--}}
				{{--<label for="title">Title</label>--}}
				{{--<input type="text" name="title" value="{{$job->title}}" class="form-control">--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<label for="featured">City</label>--}}
				{{--<input type="text" name="city" class="form-control" value="{{$job->city}}">--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<label for="description">Description</label>--}}
				{{--<textarea name="description" id="" cols="5" rows="5" class="form-control">{{$job->description}}</textarea>--}}
			{{--</div>--}}

			{{--<div class="form-group">--}}
				{{--<button class="btn btn-success center-block" type="submit"> Update Job</button>--}}
			{{--</div>--}}
		{{--</form>--}}
	{{--</div>--}}

	{{--@stop @section('styles')--}}
	{{--<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet"> @stop @section('scripts')--}}
	{{--<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>--}}
	{{--<script>--}}
		{{--$(document).ready(function () {--}}
			{{--$('#summernote').summernote();--}}
		{{--});--}}
	{{--</script>--}}
{{--</div>--}}
{{--@stop--}}
