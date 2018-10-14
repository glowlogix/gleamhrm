@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Hired Applicant</h3>
@stop
@section('content')
	<table class="table">
			<thead>
			<tr>
				<th>Image</th>
				<th>Name</th>
				<th>City</th>
				<th>Job Status </th>
				<th>Apllied for</th>
				<th>CV </th>
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
					<td>{{$applicant->job_status}}</td>
					<td>applicant job title goes here.</td>
					<td>
						<a href="/{{$applicant->cv}}">
							<img src="{{asset('uploads/applicants/cv/cv_icon.jpg')}}" alt="" height="50px" width="50px">
						</a>
					</td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Actions</button>
							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li>View</li>
								<li>
									<a href="{{route('applicant.retire',['id'=>$applicant->id])}}">retire</a>
								</li>
								<li>
									<a href="{{route ('applicant.delete',['id' =>$applicant->id])}}">Trash</a>
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
	@stop