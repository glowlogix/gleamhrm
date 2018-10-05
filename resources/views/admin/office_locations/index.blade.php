@extends('layouts.admin')  @section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b style="text-align: center;">Offices Location</b>
			<span style="float: right;">
			<a href="{{route('office_location.create')}}" class="btn btn-info btn-xs" align="right">
				<span class="glyphicon glyphicon-plus"></span> Add Office Location
			</a>
        </span>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">

		<table class="table">
			<thead>
				<th> Name</th>
				<th> Address</th>
				<th> Timing Start</th>
				<th> Timing Off</th>
				<th> Contact No</th>
				<th> Editing </th>
				<th> Deleting </th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">
				@if($office_locations->count() > 0) 
				@foreach($office_locations as $office_location)
				<tr>
					<td>{{$office_location->name}}</td>
					<td>{{$office_location->address}}</td>
					<td>{{Carbon\Carbon::parse($office_location->timing_start)->format('h:i a')}}</td>
					<td>{{Carbon\Carbon::parse($office_location->timing_off)->format('h:i a')}}</td>
					<td>{{$office_location->phone_number}}</td>
					<td>
						<a href="{{route('office_location.edit',['id'=>$office_location->id])}}">Edit</a>
					</td>
					<td>
						<a href="{{route ('office_location.delete',['id'=>$office_location->id])}}">Delete</a>
					</td>
				</tr>
				@endforeach @else
				<tr> No Office Location found.</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

@stop