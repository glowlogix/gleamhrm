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

	<div class="panel panel-default">
		<div class="panel-heading text-center">
		<b>	Jobs </b>
		</div>
		<div class="panel-body">

			<table class="table">
				<thead>
				<th>Image</th>
				<th> Job Name</th>
				<th> Job Category</th>
				<th> Editing </th>
				<th> Deleting </th>
			</thead>
				<tbody class="table-bordered table-hover table-striped">
					@if($jobs->count() > 0)	
						@foreach($jobs as $job)
						<tr>
							<td><img src="/{{$job->featured}}" alt="{{$job->title}}" height="50px" width="50px"></td>
							<td>{{$job->title}}</td>
							<td>{{$job->category->name}}</td>
							<td> <a href="{{route('job.edit',['id'=>$job->id])}}">Edit</a></td>
							<td><a href="{{route ('job.delete',['id'=>$job->id])}}">Delete</a> </td>
						</tr>
						@endforeach
					@else
					<tr> No job found.</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>

@stop