@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Create Office Location</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</li>
		<li class="breadcrumb-item active">Branch</li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
@stop
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-body">
				<form  action="{{route('branch.store')}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-body">
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Name</label>
								<input  type="text" name="name" placeholder="Enter name here" class="form-control" value="{{old('name')}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Timing Start</label>
								<input class="form-control" type="time" name="timing_start" placeholder="Enter Timing Start here"  id="timing_start" value="{{old('timing_start')}}">
								<span class="input-group-addon">
                        		<i class="fa fa-clock-o" style="font-size:16px"></i>
                    </span>
							</div>
						</div>
						</div>
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Timing OFF</label>
								<input class="form-control" type="time" name="timing_off" placeholder="Enter Timing Off here"  id="timing_off" value="{{old('timing_off')}}" />
								<span class="input-group-addon">
                        <i class="fa fa-clock-o" style="font-size:16px"></i>
								</span>
						</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Address</label>
								<input type="text" name="address" class="form-control" placeholder="Enter Address here" value="{{old('address')}}">
							</div>
						</div>
						</div>
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Phone#</label>
								<input type="number" name="phone_number" class="form-control" placeholder="Enter Phone Number here" value="{{old('phone_number')}}">
							</div>
						</div>
							<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Weekend Days</label>
								<select multiple class="form-control custom-select" data-placeholder="Choose Skills" tabindex="1" name="weekend[]">
								@foreach($weekDays as $weekday)
									<option value="{{$weekday}}">{{$weekday}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					</div>
					<hr>
					<div class="form-actions">
						&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Create Location</button>
						<button type="button" onclick="window.location.href='{{route('branch.index')}}'" class="btn btn-inverse">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop