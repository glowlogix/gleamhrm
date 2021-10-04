@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Branch</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('branch') }}">Settings</a></li>
          <li class="breadcrumb-item"><a href="{{ url('branch') }}">Branches</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
						<form id="editBranchForm" action="{{route('branch.update',[$office_location->id])}}" method="post" enctype="multipart/form-data">
							<input name="_method" type="hidden" value="PUT">
							{{csrf_field()}}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Name<span class="text-danger">*</span></label>
										<input  type="text" name="name" placeholder="Enter name here" class="form-control"  value="{{old('name', $office_location->name)}}">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group has-success">
										<label class="control-label">Status<span class="text-danger">*</span></label>
										{{ csrf_field() }}
										<select name="status" id="status" class="form-control custom-select" >
											<option value="">Select Status</option>
											<option value="1"@if($office_location->status == 1) selected @endif>Active</option>
											<option value="2"@if($office_location->status == 2) selected @endif>Inactive</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Timing Start<span class="text-danger">*</span></label>
										<input class="form-control " type="time" name="timing_start" placeholder="Enter Timing Start here" id="timing_start" value="{{old('timing_start', Carbon\Carbon::parse($office_location->timing_start)->isoFormat('HH:mm'))}}">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Timing OFF<span class="text-danger">*</span></label>
										<input class="form-control" type="time" name="timing_off" placeholder="Enter Timing Off here"  value="{{old('timing_off', Carbon\Carbon::parse($office_location->timing_off)->isoFormat('HH:mm'))}}" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Address<span class="text-danger">*</span></label>
										<input type="text" name="address" class="form-control" placeholder="Enter Address here" value="{{old('address', $office_location->address)}}">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Phone#<span class="text-danger">*</span></label>
										<input type="number" name="phone_number" class="form-control" placeholder="Enter Phone Number here" value="{{old('phone_number', $office_location->phone_number)}}">
									</div>
								</div>	
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label">Select Weekend</label>
										<select multiple class="form-control custom-select" data-placeholder="Choose Skills" tabindex="1" name="weekend[]">
											@foreach($weekDays as $weekDay)
												<option value="{{$weekDay}}" @if($office_location->weekend!=null)@foreach(json_decode($office_location->weekend) as $key) @if($weekDay == $key) selected @endif @endforeach @endif>{{$weekDay}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<hr>

							<button type="submit" class="btn btn-primary"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle" title="Update Branch"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
							<button type="button" onclick="window.location.href='{{route('branch.index')}}'" class="btn btn-default" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->

<script type="text/javascript">
$(function () {
	  	$('#editBranchForm').validate({
		    rules: {
		    	name: {
		        	required: true
		     	},
		     	status: {
		        	required: true
		     	},
				timing_start: {
		        	required: true
		     	},
				timing_off: {
		        	required: true
		     	},
				address: {
		        	required: true
		     	},
				phone_number: {
		        	required: true
		     	}
		    },
		    messages: {
		    	name: "Name is required",
		    	status: "Status is required",
				timing_start: "Start time is required",
				timing_off: "Off time is required",
				address: "Address is required",
				phone_number: "Phone number is required"
		    },
		    errorElement: 'span',
		    errorPlacement: function (error, element) {
		      	error.addClass('invalid-feedback');
		      	element.closest('.form-group').append(error);
		    },
		    highlight: function (element, errorClass, validClass) {
		      	$(element).addClass('is-invalid');
		    },
		    unhighlight: function (element, errorClass, validClass) {
		      	$(element).removeClass('is-invalid');
		    }
	  	});
	});
</script>
@stop