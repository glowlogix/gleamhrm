@extends('layouts.admin')
@section('Heading')
	<button type="button" class="btn btn-info btn-rounded m-t-10 float-right" onclick="window.location.href='{{route('office_location.create')}}'">Add Office Location</button>
	<h3 class="text-themecolor">Office Location</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Offices</li>
	</ol>
@stop
@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h6 class="card-subtitle"></h6>

					<div class="table">
						<table id="demo-foo-addrow" class="table  m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
							<thead>
							<tr>
								<th> Name</th>
								<th> Address</th>
								<th> Timing Start</th>
								<th> Timing Off</th>
								<th> Contact No</th>
								<th> Actions</th>
							</tr>
							</thead>
							<tbody>
							@if($office_locations->count() > 0)
								@foreach($office_locations as $office_location)
							<tr>
								<td>{{$office_location->name}}</td>
								<td>{{$office_location->address}}</td>
								<td>{{Carbon\Carbon::parse($office_location->timing_start)->format('h:i a')}}</td>
								<td>{{Carbon\Carbon::parse($office_location->timing_off)->format('h:i a')}}</td>
								<td>{{$office_location->phone_number}}</td>
								<td class="text-nowrap">
									<a class="btn btn-info btn-sm" href="{{route('office_location.edit',['id'=>$office_location->id])}}"  data-original-title="Edit"> <i class="fas fa-pencil-alt text-white"></i></a>
									<a class="btn btn-danger btn-sm" href="{{route ('office_location.delete',['id'=>$office_location->id])}}" data-original-title="Close"> <i class="fas fa-window-close text-white  "></i> </a>
								</td>
							</tr>
								@endforeach @else
								<tr> No Branch Found</tr>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop