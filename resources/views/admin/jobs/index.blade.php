@extends('layouts.admin')  @section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<div>
			<b style="text-align: center;">Jobs</b>
		</div>
		<div style="padding-left: 85%;">
			<a href="{{route('job.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Job
			</a>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">

		<table class="table">
			<thead>
				<th> Title</th>
				<th> City</th>
				<th> Editing </th>
				<th> Deleting </th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($jobs->count() > 0) @foreach($jobs as $job)
				<tr>
					<td>{{$job->title}}</td>
					<td>{{$job->city}}</td>
					<td>
						<a href="{{route('job.edit',['id'=>$job->id])}}">Edit</a>
					</td>
					<td>
						<a href="{{route ('job.delete',['id'=>$job->id])}}">Delete</a>
					</td>
				</tr>
				@endforeach @else
				<tr> No job found.</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop