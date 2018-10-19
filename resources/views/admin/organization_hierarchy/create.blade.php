@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Create Hierarchy</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">People-Management</li>
		<li class="breadcrumb-item active">Org Chart</li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
@stop
@section('content')
	<div class="row">
		<div class="col-lg-8" style="margin-left: 200px;">
			<div class="card card-outline-info">
				<h6 class="card-subtitle"><button type="button" style="margin-right: 10px; margin-top:15px;" class="btn btn-info  m-t-10 float-right" onclick="window.location.href='{{route('organization_hierarchy.index')}}'">Back</button></h6>

				<div class="card-body">
					<form  action="{{route('organization_hierarchy.store')}}" method="post" enctype="multipart/form-data">
						{{csrf_field()}}
						<div class="form-body">
							<div class="col-md-8">
								<div class="form-group">
									<label class="control-label">Name</label>
									<select class="form-control custom-select" name="employee_id">
										@foreach ($employees as $employee)
											<option value="{{$employee->id}}" @if($employee->id == old('employee_id')) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
										@endforeach
									</select>
								</div>
							</div>
							@if($OrganizationHierarchyCnt > 0)
							<div class="col-md-8">
								<div class="form-group">
									<label class="control-label">Line Manager</label>
									<select class="form-control custom-select" name="line_manager_id">
										@foreach ($employees as $employee)
											<option value="{{$employee->id}}" @if($employee->id == old('employee_id')) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-group">
									<label class="control-label">Parent Employee</label>
									<select class="form-control custom-select" name="parent_id">
										@foreach ($employees as $employee)
											<option value="{{$employee->id}}" @if($employee->id == old('employee_id')) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
										@endforeach
									</select>
								</div>
							</div>
							@endif
						</div>

						<div class="form-actions">
							<hr>
							&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Create</button>
							<button type="button" onclick="window.location.href='{{route('organization_hierarchy.index')}}'" class="btn btn-inverse">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop
