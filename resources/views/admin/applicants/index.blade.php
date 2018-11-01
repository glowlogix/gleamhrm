@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Applicants</h3>
	<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
	<li class="breadcrumb-item active">Applicant</li>
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
							<td>
								<a href="javascript:void(0)"><img src="/{{$applicant->avatar}}" alt="user" width="40" class="img-circle" />{{$applicant->name}}</a>
							</td>
							<td>{{$applicant->city}}</td>
							<td>{{$applicant->job_status}}</td>
							<td>{{$applicant->job_id}}</td>
							<td><a href="/{{$applicant->cv}}">
									<img src="{{asset('uploads/applicants/cv/cv_icon.jpg') }}" alt="" height="50px" width="50px">
								</a>
							</td>
							<td class="text-nowrap">
								<a href="{{route('applicant.hire',['id'=>$applicant->id])}}" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-pencil-alt text-inverse m-r-10"></i></a>
								<a href="{{route ('applicant.delete',['id' =>$applicant->id])}}" data-toggle="tooltip" data-original-title="Close"> <i class="fas fa-window-close text-danger"></i> </a>
							</td>
						</tr>
						@endforeach
						@else
							<p class="text-center" >No Applicant found.</p>
						@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop