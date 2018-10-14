@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Jobs</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Hiring</li>
		<li class="breadcrumb-item active">Jobs</li>
	</ol>
@stop
@section('content')
<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6 class="card-subtitle"></h6>
					<button type="button"  onclick="window.location.href='{{route('job.create')}}'" class="btn btn-info btn-rounded m-t-10 float-right">Add Job</button>
					<div class="table">
						<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
							<thead>
							<tr>
								<th> Title</th>
								<th> City</th>
								<th> Actions </th>
							</tr>
							</thead>
							<tbody>
							@if($jobs->count() > 0) @foreach($jobs as $job)
							<tr>

								<td>{{$job->title}}</td>
								<td>{{$job->city}}</td>
								<td class="text-nowrap">
									<a class="btn btn-info btn-sm" href="{{route('job.edit',['id'=>$job->id])}}" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white "></i></a>
									<a class="btn btn-danger btn-sm" href="{{route ('job.delete',['id'=>$job->id])}}" data-toggle="tooltip" data-original-title="Close"> <i class="fas fa-window-close text-white"></i> </a>
								</td>

							</tr>
							@endforeach @else
								<tr> No job found.</tr>
							@endif

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop













{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<div>--}}
			{{--<b style="text-align: center;">Jobs</b>--}}
		{{--</div>--}}
		{{--<div style="padding-left: 85%;">--}}
			{{--<a href="{{route('job.create')}}" class="btn btn-info btn-xs" align="right">--}}
				{{--<span class="glyphicon glyphicon-plus"></span> Add Job--}}
			{{--</a>--}}
		{{--</div>--}}
	{{--</div>--}}
{{--</div>--}}
{{--<div class="panel panel-default">--}}
	{{--<div class="panel-body">--}}

		{{--<table class="table">--}}
			{{--<thead>--}}
				{{--<th> Title</th>--}}
				{{--<th> City</th>--}}
				{{--<th> Editing </th>--}}
				{{--<th> Deleting </th>--}}
			{{--</thead>--}}
			{{--<tbody class="table-bordered table-hover table-striped">--}}
				{{--@if($jobs->count() > 0) @foreach($jobs as $job)--}}
				{{--<tr>--}}
					{{--<td>{{$job->title}}</td>--}}
					{{--<td>{{$job->city}}</td>--}}
					{{--<td>--}}
						{{--<a href="{{route('job.edit',['id'=>$job->id])}}">Edit</a>--}}
					{{--</td>--}}
					{{--<td>--}}
						{{--<a href="{{route ('job.delete',['id'=>$job->id])}}">Delete</a>--}}
					{{--</td>--}}
				{{--</tr>--}}
				{{--@endforeach @else--}}
				{{--<tr> No job found.</tr>--}}
				{{--@endif--}}
			{{--</tbody>--}}
		{{--</table>--}}
	{{--</div>--}}
{{--</div>--}}

{{--@stop--}}