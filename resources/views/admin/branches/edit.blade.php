@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Edit Branch</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</li>
		<li class="breadcrumb-item active">Branch</li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-body">
				<form  action="{{route('branch.update',['id'=>$office_location->id])}}" method="post" enctype="multipart/form-data">
					<input name="_method" type="hidden" value="PUT">
					{{csrf_field()}}
					<div class="form-body">
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Name</label>
								<input  type="text" name="name" placeholder="Enter name here" class="form-control"  value="{{old('name', $office_location->name)}}">
							</div>
						</div>
							<div class="col-md-6">
								<div class="form-group has-success">
									<label class="control-label">Status</label>
									{{ csrf_field() }}
									<select name="status" id="status" class="form-control custom-select" >
										<option value="1"@if($office_location->status == 1) selected @endif>Active</option>
										<option value="2"@if($office_location->status == 2) selected @endif>Inactive</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Timing Start</label>
								<input class="form-control " type="time" name="timing_start" placeholder="Enter Timing Start here"   id="timing_start" value="{{old('timing_start', Carbon\Carbon::parse($office_location->timing_start)->format('h:i'))}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Timing OFF</label>
								<input class="form-control" type="time" name="timing_off" placeholder="Enter Timing Off here"  value="{{old('timing_off', Carbon\Carbon::parse($office_location->timing_off)->format('h:i'))}}" />
							</div>
						</div>
						</div>
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Address</label>
								<input type="text" name="address" class="form-control" placeholder="Enter Address here" value="{{old('address', $office_location->address)}}">
						</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Phone#</label>
								<input type="number" name="phone_number" class="form-control" placeholder="Enter Phone Number here" value="{{old('phone_number', $office_location->phone_number)}}">
							</div>
						</div>	<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Select Weekend</label>
								<select multiple class="form-control custom-select" data-placeholder="Choose Skills" tabindex="1" name="weekend[]">
									@foreach($weekDays as $weekDay)
										<option value="{{$weekDay}}" @if($office_location->weekend!=null)@foreach(json_decode($office_location->weekend) as $key) @if($weekDay == $key) selected @endif
												@endforeach @endif>{{$weekDay}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions">
						&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Update Location</button>
						<button type="button" onclick="window.location.href='{{route('branch.index')}}'" class="btn btn-inverse">Cancel</button>
					</div>
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
$(document).ready(function () {
    $(function () {
		$("div.timepicker").on("click", function () {
	        $(this).datetimepicker({
	            format: "LT",
	            icons: {
	                up: "fa fa-chevron-up",
	                down: "fa fa-chevron-down"
	            }
	        });
	        console.log("O.K.");
		});

    });
});
</script>
@endpush
@stop