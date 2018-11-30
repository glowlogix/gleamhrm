@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('applicants')}}'">Applicants</button>
	<h3 class="text-themecolor">Hired Applicant</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Applicant</li>
		<li class="breadcrumb-item active">Hired Applicant</li>
	</ol>
@stop
@section('content')
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table">
						@if($applicants->count() > 0)
							<thead>
							<tr>
								<th>Avatar</th>
								<th>Name</th>
								<th>City</th>
								<th>Job Status</th>
								<th>Applied For</th>
								<th>CV</th>
								<th>Actions</th>
							</tr>
							</thead>
							<tbody>
							@foreach($applicants as $applicant)
								<tr>
									<td><img src="{{asset($applicant->avatar)}}" alt="user" width="40" class="img-circle" /></td>
									<td>
										<a href="javascript:void(0)">{{$applicant->name}}</a>
									</td>
									<td>{{$applicant->city}}</td>
									<td>{{$applicant->job_status}}</td>
									<td>{{$applicant->job->title}}</td>
									<td><a target="_blank" href="{{asset($applicant->cv)}}" class="fas fa-file-alt text-inverse font-bold" style="font-size: 30px;">
										</a>
									</td>
									<td class="text-nowrap">
										<div class="dropdown">
											<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Action
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a href="{{route('applicant.retire',['id'=>$applicant->id])}}" class="dropdown-item">Retire</a>
												<a href="{{route ('applicant.delete',['id' =>$applicant->id])}}"  class="dropdown-item">Trash</a>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
							@else
								<p class="text-center" >No Hired Applicant Found</p>
							@endif
							</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@stop