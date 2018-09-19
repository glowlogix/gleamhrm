@extends('layouts.admin') @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b> Jobs </b>
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
				@if($jobs->count() > 0) @foreach($jobs as $job)
				<tr>
					<td>
						<img src="/{{$job->featured}}" alt="{{$job->title}}" height="50px" width="50px">
					</td>
					<td>{{$job->title}}</td>
					<td>{{$job->category->name}}</td>
					<td> Edit</td>
					<td> Delete</td>
				</tr>
				@endforeach @else
				<tr> No job found.</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop