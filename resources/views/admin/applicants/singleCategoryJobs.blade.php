@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Applcants</h3>
@stop
@section('content')
<div class="panel panel-default">

	<div class="panel-body">

		<table class="table">
			<thead>
			<tr>
				<th> Image</th>
				<th> Name</th>
				<th> City</th>
				<th> Job Status </th>
				<th> CV </th>
			</tr>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($applicants->count() > 0) @foreach($applicants as $applicant)
				<tr>
					<td>
						<img src="/{{$applicant->avatar}}" alt="" width="50px">
					</td>
					<td>{{$applicant->name}}</td>
					<td>{{$applicant->city}}</td>
					<td>
						<i class="fal fa-file"></i>{{$applicant->job_status}}</td>
					<td>
						<a href="{{ asset($applicant->cv) }}">Open the pdf!</a>
					</td>
				</tr>
				@endforeach @else
				<tr> No Applicant found.</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop