@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Add Leave</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</li>
		<li class="breadcrumb-item active">Employee Leaves</li>
		<li class="breadcrumb-item active">Apply</li>
	</ol>
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-outline-info">
				<div style="margin:10px 10px">
					</h4>
				</div>
				<div class="card-body">
					<form class="form-horizontal" action="{{route('leaves.adminStore')}}" method="post">
						{{csrf_field()}}
						<div class="form-body">
							<h3 class="box-title">Add Leave For Employee
							</h3>
							<hr class="m-t-0 m-b-40">
							<!--/row-->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Select Employee</label>
										<div class="col-md-9">
											<select class="form-control custom-select" id="employee" name="employee">
												@foreach($employees as $employee)
													<option value="{{$employee->id}}" @if($selectedEmployee->id==$employee->id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Line Manager</label>
										<div class="col-md-9">
											<input type="hidden" name="line_manager" value="{{isset($line_manager->id) ? $line_manager->id : ''}}">
											<input type="text" class="form-control" value="{{isset($line_manager->id) ? $line_manager->firstname.'  '. $line_manager->lastname : ''}}" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Leave Type</label>
										<div class="col-md-9">
											<select class="form-control custom-select" name="leave_type">
												@foreach($leave_types as $leave_type)
													<option @if(old('leave_type') == $leave_type->id)selected @endif value="{{$leave_type->id}}">{{$leave_type->name}} ({{$leave_type->amount}})</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Back up/ Point of Contact:</label>
										<div class="col-md-9">
											<select class="form-control custom-select" name="point_of_contact">
												@foreach($employees as $employee)
													@if(Auth::user()->id != $employee->id)
														<option  @if(old('employee_id') == $employee->id) selected @endif value={{$employee->id}}>{{$employee->firstname}} {{$employee->lastname}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<!--/span-->
							</div>
							<!--/row-->
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">From Date</label>
										<div class="col-md-9">
											<input type="date" class="form-control"   name="datefrom" value="{{old('datefrom')}}">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">To Date</label>
										<div class="col-md-9">
											<input type="date" class="form-control" placeholder="dd/mm/yyyy" name="dateto" value="{{old('dateto')}}">
										</div>
									</div>
								</div>
							</div>
							<div class="row">

								<!--/span-->
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">CC To</label>
										<div class="col-md-9">
											<input type="email"  multiple="multiple" class="form-control" name="cc_to" id="cc_to" value="{{old('cc_to')}}">
										</div>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Status</label>
										<div class="col-md-9">
											<select class="form-control custom-select" name="status">
												<option value="pending">Pending</option>
												<option value="Approved">Approved</option>
												<option value="Approved">Declined</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Subject</label>
										<div class="col-md-9">
											<input type="text" class="form-control" placeholder="Enter Subject Here" name="subject" value="{{old('subject')}}">
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group row">
										<label class="control-label text-right col-md-3">Description</label>
										<div class="col-md-9">
											<textarea type="text" class="form-control" rows="3" name="description" placeholder="Enter Description Here">{{old('description')}}</textarea>
										</div>
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
											<button type="submit" class="btn btn-success">Add</button>
											<a href="{{route('employeeleaves')}}" class="btn btn-inverse">Cancel</a>
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
	@push('scripts')
	<script type="text/javascript">
        $(document).ready(function () {

        $("#employee").change(function(e){
            var url = "{{route('admin.createLeave')}}/" + $(this).val();

            if (url) {
                window.location = url;
            }
            return false;
        });

        });
	</script>
	@endpush
	@stop
