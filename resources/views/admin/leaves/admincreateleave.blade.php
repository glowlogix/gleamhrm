@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Add Employee Leaves</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('employee_leaves') }}">Attendance</a></li>
          <li class="breadcrumb-item"><a href="{{ url('employee_leaves') }}">Employee Leaves</a></li>
          <li class="breadcrumb-item active">Add</li>
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
						<form id="addLeaveForm" action="{{route('leaves.adminStore')}}" method="post">
							{{csrf_field()}}
                            <input type="text" name="email" value="@if(isset($platform->hr_email)) {{$platform->hr_email}} @else @if(isset($platform->email)) {{$platform->email}} @else noreply@email.com @endif @endif" hidden>
							<div class="form-body">
								<h5><strong>Add Leave For Employee</strong></h5>
                        		<hr class="mt-0">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Select Employee<span class="text-danger">*</span></label>
											<select class="form-control custom-select" id="employee" name="employee" value="{{ old('employee') }}">
												<option value="">Select Employee</option>
												@foreach($employees as $employee)
													<option value="{{$employee->id}}" @if($selectedEmployee->id==$employee->id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Line Manager</label>
											<input type="hidden" name="line_manager" value="{{isset($line_manager->id) ? $line_manager->id : ''}}"/>
											<input type="text" class="form-control" value="{{isset($line_manager->id) ? $line_manager->firstname.'  '. $line_manager->lastname : ''}}" disabled>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Leave Type<span class="text-danger">*</span></label>
											<select class="form-control custom-select" name="leave_type" value="{{ old('leave_type') }}">
												<option value="">Select Leave Type</option>
												@foreach($leave_types as $leave_type)
													<option @if(old('leave_type') == $leave_type->id)selected @endif value="{{$leave_type->id}}">{{$leave_type->name}} ({{$leave_type->count}})</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Back up/ Point of Contact<span class="text-danger">*</span></label>
											<select class="form-control custom-select" name="point_of_contact" value="{{ old('point_of_contact') }}">
												<option value="">Select Backup Contact</option>
												@foreach($employees as $employee)
													@if(Auth::user()->id != $employee->id)
														<option  @if(old('employee_id') == $employee->id) selected @endif value={{$employee->id}}>{{$employee->firstname}} {{$employee->lastname}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">From Date<span class="text-danger">*</span></label>
											<input type="date" class="form-control" name="datefrom" value="{{ old('datefrom') }}"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">To Date<span class="text-danger">*</span></label>
											<input type="date" class="form-control" placeholder="dd/mm/yyyy" name="dateto" value="{{ old('dateto') }}"/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">CC To</label>
											<input type="email"  multiple="multiple" class="form-control" name="cc_to" id="cc_to" value="{{ old('cc_to') }}" placeholder="example@example.com" />
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Status<span class="text-danger">*</span></label>
											<select class="form-control custom-select" name="status" value="{{ old('status') }}">
												<option value="">Select Status</option>
												<option value="pending">Pending</option>
												<option value="Approved">Approved</option>
												<option value="Approved">Declined</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Subject<span class="text-danger">*</span></label>
											<input type="text" class="form-control" placeholder="Enter Subject Here" name="subject" value="{{ old('subject') }}"/>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Description<span class="text-danger">*</span></label>
											<textarea type="text" class="form-control" rows="3" name="description" placeholder="Enter Description Here">{{ old('description') }}</textarea>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<button type="submit" class="btn btn-primary" title="Create Employee Leave">Create</button>
												<a href="{{route('employeeleaves')}}" class="btn btn-default" title="Cancel">Cancel</a>
											</div>
										</div>
									</div>
									<div class="col-md-6"> </div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->

<script>
    $(document).ready(function () {
	    $("#employee").change(function(e){
	        var url = "{{route('admin.createLeave')}}/" + $(this).val();

	        if (url) {
	            window.location = url;
	        }
	        return false;
	    });
    });

    $(function () {
	  $('#addLeaveForm').validate({
	    rules: {
	    	leave_type: {
				required: true,
			},
			datefrom: {
				required: true,
			},
			dateto: {
				required: true,
			},
			point_of_contact: {
				required: true,
			},
			subject: {
				required: true,
			},
			description: {
				required: true,
			},
	    },
	    messages: {
	    	leave_type: "Leave type is required",
			datefrom: "Date-from is required",
			dateto: "Date-to is required",
			point_of_contact: "Backup contact is required",
			subject: "Subject is required",
			description: "Description is required",
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
