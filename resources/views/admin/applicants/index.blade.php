@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('applicants.hired')}}'"> Hired</button>
	<h3 class="text-themecolor">Applicants</h3>
	<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
	<li class="breadcrumb-item active">Applicants</li>
	</ol>
@stop
@section('content')
	{{--//////startt--}}
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
								<a>{{$applicant->name}}</a>
							</td>
							<td>{{$applicant->city}}</td>
							<td>{{$applicant->job_status}}</td>
							<td>{{$applicant->job->title}}</td>
							<td><a target="_blank" href="{{asset($applicant->cv)}}" class="fas fa-file-alt text-inverse font-bold" data-toggle="tooltip"  data-original-title="Click To Open CV" style="font-size: 30px">
								</a>
							</td>
							<td class="text-nowrap">
								<a href="{{route('applicant.hire',['id'=>$applicant->id])}}" data-toggle="tooltip"  data-original-title="Hire" class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt "></i></a>
								<a href="{{route ('applicant.delete',['id' =>$applicant->id])}}" data-toggle="tooltip"   data-original-title="Delete" class="btn btn-sm btn-danger"> <i class="fas fa-window-close"></i></a>
							</td>
						</tr>
						@endforeach
						@else
							<p class="text-center" >No New Applicant Found</p>
						@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop