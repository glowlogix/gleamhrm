@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor"> Applcants</h3>
@stop
@section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
	</div>
	<div class="panel-body">

		<table class="table">
			<thead>
			<tr>
				<th> Image</th>
				<th> Name</th>
				<th> City</th>
				<th> Job Status </th>
				<th>Apllied for</th>
				<th> CV </th>
				<th>Actions</th>
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
					<td> {{$applicant->job_status}}</td>
					<td>abc</td>
					<td>
						<a href="{{ asset($applicant->cv) }}">Open the pdf!</a>
					</td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Actions</button>
							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>
									<a href="{{route('applicant.restore',['id'=>$applicant->id])}}">Restore</a>
								</li>
								<li>
									<a href="{{route ('applicant.kill',['id' =>$applicant->id])}}">Delete</a>
								</li>
							</ul>
						</div>
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