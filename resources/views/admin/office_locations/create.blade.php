@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Create Office Location</h3>
@stop
@section('content')


<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">

			<div class="card-body">
				<form  action="{{route('office_location.store')}}" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-body">

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
								<span class="input-group-addon timepicker1">
                        <i class="fa fa-clock-o" style="font-size:16px"></i>
                    </span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Timing OFF</label>
								<input class="form-control" type="time" name="timing_off" placeholder="Enter Timing Off here"  id="timing_off" value="{{old('timing_off')}}" />
								<span class="input-group-addon timepicker1">
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
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Phone#</label>
								<input type="number" name="phone_number" class="form-control" placeholder="Enter Phone Number here" value="{{old('phone_number')}}">
							</div>
						</div>

					</div>

					<div class="form-actions">
						&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Create Location</button>
						<button type="button" onclick="window.location.href='{{route('offices')}}'" class="btn btn-inverse">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>




{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<b> Create new Office Location</b>--}}
		{{--<span style="float: right;">--}}
            {{--<a href="{{route('offices')}}" class="btn btn-info btn-xs" align="right">--}}
                {{--<span class="glyphicon"></span> Back--}}
            {{--</a>--}}
        {{--</span>--}}
	{{--</div>--}}
	{{--<div class="panel-body">--}}

		{{--<form action="{{route('office_location.store')}}" method="post" enctype="multipart/form-data">--}}
			{{--{{csrf_field()}}--}}
			{{--<div class="form-group">--}}
				{{--<label for="name">Name</label>--}}
				{{--<input type="text" name="name" placeholder="Enter name here" class="form-control" value="{{old('name')}}">--}}
				{{--<input type="hidden" name="status" value="1">--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<label for="timing_start">Timing Start</label>--}}
                {{--<div class="input-group timepicker">--}}
                    {{--<input class="form-control" name="timing_start" placeholder="Enter Timing Start here"  id="timing_start" value="{{old('timing_start')}}" />--}}
                    {{--<span class="input-group-addon timepicker1">--}}
                        {{--<i class="fa fa-clock-o" style="font-size:16px"></i>--}}
                    {{--</span>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
				{{--<label for="timing_off">Timing Off</label>--}}
                {{--<div class="input-group timepicker">--}}
                    {{--<input class="form-control" name="timing_off" placeholder="Enter Timing Off here"  id="timing_off" value="{{old('timing_off')}}" />--}}
                    {{--<span class="input-group-addon timepicker1">--}}
                        {{--<i class="fa fa-clock-o" style="font-size:16px"></i>--}}
                    {{--</span>--}}
                {{--</div>--}}
            {{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<label for="address">Address</label>--}}
				{{--<input type="text" name="address" class="form-control" placeholder="Enter Address here" value="{{old('address')}}">--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<label for="phone_number">Phone Number</label>--}}
				{{--<input type="number" name="phone_number" class="form-control" placeholder="Enter Phone Number here" value="{{old('phone_number')}}">--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<a href="{{route('offices')}}" class="btn btn-default">--}}
	                 {{--Cancel--}}
	            {{--</a>--}}
	            {{--<button class="btn btn-success center-block" style="display: inline; float: left; margin-right: 5px;" type="submit"> Create</button>--}}
			{{--</div>--}}
		{{--</form>--}}
	{{--</div>--}}

{{--</div>--}}


@stop
