@extends('layouts.master')
@section('Heading')
	<h3 class="text-themecolor">Update Hierarchy</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">People-Management</li>
		<li class="breadcrumb-item active">Org Chart</li>
		<li class="breadcrumb-item active">Update</li>
	</ol>
@stop
@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Organization Hierarchy</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('organization_hierarchy') }}">People Management</a></li>
          <li class="breadcrumb-item"><a href="{{ url('organization_hierarchy') }}">Organization Hierarchy</a></li>
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
						<button type="button" class="btn btn-info" onclick="window.location.href='{{route('organization_hierarchy.index')}}'" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span></button>

                        <hr>

						<form  action="{{route('organization_hierarchy.update',[$organization_hierarchy->id])}}" method="post">
							<input name="_method" type="hidden" value="PUT">
							{{csrf_field()}}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Name</label>
										<select class="form-control custom-select" name="employee_id">
											@foreach ($employees as $employee)
												<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->employee_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Line Manager</label>
										<select class="form-control custom-select" name="line_manager_id">
											@foreach ($employees as $employee)
												<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->line_manager_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Parent Employee</label>
										<select class="form-control custom-select" name="parent_id">
											@foreach ($employees as $employee)
												<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->parent_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<hr>

							<button type="submit" class="btn btn-primary" title="Update Organization Hierarchy"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Update</span></button>
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







{{--<div class="panel panel-default">--}}
	{{--<div class="panel-heading text-center">--}}
		{{--<b> Edit Organize Employee</b>--}}
		{{--<span style="float: right;">--}}
            {{--<a href="{{route('organization_hierarchy.index')}}" class="btn btn-info btn-xs" align="right">--}}
                {{--<span class="glyphicon"></span> Back--}}
            {{--</a>--}}
        {{--</span>--}}
	{{--</div>--}}
	{{--<div class="panel-body">--}}

		{{--<form action="{{route('organization_hierarchy.update',['id' => $organization_hierarchy->id])}}" method="post">--}}
			{{--<input name="_method" type="hidden" value="PUT">--}}
			{{--{{csrf_field()}}--}}
			{{--<div class="form-group">--}}
				{{--<label for="name">Name</label>--}}
				{{--<select name="employee_id" class="form-control">--}}
					{{--@foreach ($employees as $employee)--}}
					{{--<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->employee_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>--}}
					{{--@endforeach--}}
				{{--</select>--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<label for="name">Line Manager</label>--}}
				{{--<select name="line_manager_id" class="form-control">--}}
					{{--@foreach ($employees as $employee)--}}
					{{--<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->line_manager_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>--}}
					{{--@endforeach--}}
				{{--</select>--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<label for="name">Parent Employee</label>--}}
				{{--<select name="parent_id" class="form-control">--}}
					{{--@foreach ($employees as $employee)--}}
					{{--<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->parent_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>--}}
					{{--@endforeach--}}
				{{--</select>--}}
			{{--</div>--}}
			{{--<div class="form-group">--}}
				{{--<a href="{{route('organization_hierarchy.index')}}" class="btn btn-default">Cancel</a>--}}
	            {{--<button class="btn btn-success center-block" style="display: inline; float: left; margin-right: 5px;" type="submit">Update</button>--}}
			{{--</div>--}}
		{{--</form>--}}
	{{--</div>--}}
{{--</div>--}}
{{--<script type="text/javascript">--}}
{{--$(document).ready(function () {--}}
    {{--$(function () {--}}
	    {{--$("#check_all").click(function(){--}}
		    {{--$('input:checkbox').not(this).prop('checked', this.checked);--}}
		{{--});--}}
		{{--$(".check_all_sub").click(function(){--}}
		    {{--$('div.'+ this.id +' input:checkbox').prop('checked', this.checked);--}}
		{{--});--}}
    {{--});--}}
{{--});--}}
{{--</script>--}}
{{--@stop--}}
