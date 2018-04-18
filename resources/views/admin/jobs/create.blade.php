@extends('layouts.admin')
@section('title')
HRM|Create Job
@endsection
@section('content')
@include('admin.includes.errors')
	
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<b>	Create new Job</b>
		</div>
		<div class="panel-body">
		
				<form action="{{route('job.store')}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label for="category">Select Category</label>
						<select name="category_id" id="category" class="form-control">
							@foreach($categories as $categori)
							<option value="{{$categori->id}}">{{$categori->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" placeholder="Enter title here" class="form-control">
					</div>
					<div class="form-group">
						<label for="featured" >Featured Image</label>
						<input type="file" name="featured" class="form-control">
					</div>
					<div class="form-group">
						<label for="description" >Description</label>
						<textarea name="description" id="summernote" cols="5" rows="5" class="form-control"></textarea>
					</div>
						

						<div class="form-group">
							<button class="btn btn-success center-block" type="submit"> Create Job</button>
						</div>
					</form>
		</div>

@stop

@section('styles')
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
@stop

@section('scripts')
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
	 <script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
  </script>
@stop
