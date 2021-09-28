@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Create Organization Hierarchy</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('organization_hierarchy') }}">People Management</a></li>
          <li class="breadcrumb-item"><a href="{{ url('organization_hierarchy') }}">Organization Hierarchy</a></li>
          <li class="breadcrumb-item active">Create</li>
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
						<button type="button" class="btn btn-info" onclick="window.location.href='{{route('organization_hierarchy.index')}}'" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span></button>

            <hr>

						<form  action="{{route('organization_hierarchy.store')}}" method="post" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="row">
								<div class="col-md-6">
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
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Line Manager</label>
											<select class="form-control custom-select" name="line_manager_id">
												@foreach ($employees as $employee)
													<option value="{{$employee->id}}" @if($employee->id == old('employee_id')) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-6">
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

							<hr>

							<button type="submit" class="btn btn-primary" title="Create Organization Hierarchy"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Create</span></button>
              <button type="button" onclick="window.location.href='{{route('organization_hierarchy.index')}}'" class="btn btn-default" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Main Content End -->
@stop
