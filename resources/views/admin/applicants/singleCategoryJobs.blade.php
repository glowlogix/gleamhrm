@extends('layouts.admin') @section('content')
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
<div class="panel panel-default">
	<div class="panel-heading text-center">
		Applcants
	</div>
	<div class="panel-body">

		<table class="table">
			<thead>
				<th> Image</th>
				<th> Name</th>
				<th> City</th>
				<th> Job Status </th>
				<th> CV </th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($applicants->count() > 0) @foreach($applicants as $applicant)
				<tr>


					<td>
						<img src="/{{$applicant->avatar}}" alt="" width="50px" width="50px">
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