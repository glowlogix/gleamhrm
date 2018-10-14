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
						@if($applicants->count() > 0) @foreach($applicants as $applicant)
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
							<tr> No Applicant found.</tr>
						@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>








@stop











{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<b> Applicants </b>--}}
	{{--</div>--}}
	{{--<div class="panel-body">--}}
		{{--<form action="/search" method="POST" role="search">--}}
			{{--{{ csrf_field() }}--}}
			{{--<div class="input-group">--}}
				{{--<input type="text" class="form-control" name="q" placeholder="Search Applicant by their City">--}}
				{{--<span class="input-group-btn">--}}
					{{--<button type="submit" class="btn btn-default">--}}
						{{--<span class="glyphicon glyphicon-search"></span>--}}
					{{--</button>--}}
				{{--</span>--}}
			{{--</div>--}}
		{{--</form>--}}

		{{--<table class="table">--}}
			{{--<thead>--}}
				{{--<th> Image</th>--}}
				{{--<th> Name</th>--}}
				{{--<th> City</th>--}}
				{{--<th> Job Status </th>--}}
				{{--<th>Apllied for</th>--}}
				{{--<th> CV </th>--}}
				{{--<th>Actions</th>--}}
			{{--</thead>--}}
			{{--<tbody class="table-bordered table-hover table-striped">--}}
				{{--@if($applicants->count() > 0) @foreach($applicants as $applicant)--}}
				{{--<tr>--}}
					{{--<td>--}}
						{{--<img src="/{{$applicant->avatar}}" alt="" width="50px" width="50px">--}}
					{{--</td>--}}
					{{--<td>{{$applicant->name}}</td>--}}
					{{--<td>{{$applicant->city}}</td>--}}
					{{--<td>{{$applicant->job_status}}</td>--}}
					{{--<td>{{$applicant->job_id}}</td>--}}
					{{--<td>--}}
						{{--<a href="/{{$applicant->cv}}">--}}
							{{--<img src="{{asset('uploads/applicants/cv/cv_icon.jpg') }}" alt="" height="50px" width="50px">--}}
						{{--</a>--}}
					{{--</td>--}}
					{{--<td>--}}
						{{--<div class="btn-group">--}}
							{{--<button type="button" class="btn btn-primary">Actions</button>--}}
							{{--<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">--}}
								{{--<span class="caret"></span>--}}
							{{--</button>--}}
							{{--<ul class="dropdown-menu" role="menu">--}}
								{{--<li>View</li>--}}
								{{--<li>--}}
									{{--<a href="{{route('applicant.hire',['id'=>$applicant->id])}}">Hire</a>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<a href="{{route ('applicant.delete',['id' =>$applicant->id])}}">Trash</a>--}}
								{{--</li>--}}
							{{--</ul>--}}
						{{--</div>--}}
					{{--</td>--}}

				{{--</tr>--}}
				{{--@endforeach @else--}}
				{{--<tr> No Applicant found.</tr>--}}
				{{--@endif--}}

			{{--</tbody>--}}
		{{--</table>--}}
	{{--</div>--}}
{{--</div>--}}
{{--@stop--}}