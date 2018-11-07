@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('applicants')}}'">Applicants</button>
	<h3 class="text-themecolor">Hired Applicant</h3>
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
										<a href="javascript:void(0)">{{$applicant->name}}</a>
									</td>
									<td>{{$applicant->city}}</td>
									<td>{{$applicant->job_status}}</td>
									<td>{{$applicant->job->title}}</td>
									<td><a href="{{asset($applicant->cv)}}">
											<img src="{{asset('uploads/applicants/cv/cv_icon.jpg') }}" alt="" height="50px" width="50px">
										</a>
									</td>
									<td class="text-nowrap">
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
							@endforeach
							@else
								<p class="text-center" >No New Applicant found.</p>
							@endif
							</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@stop