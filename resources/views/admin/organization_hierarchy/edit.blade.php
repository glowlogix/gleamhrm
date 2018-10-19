@extends('layouts.admin')
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
	<div class="row">
		<div class="col-lg-8" style="margin-left:200px" >
			<div class="card card-outline-info">
				<h6 class="card-subtitle"><button type="button" style="margin-right: 10px; margin-top:15px;" class="btn btn-info  m-t-10 float-right" onclick="window.location.href='{{route('organization_hierarchy.index')}}'">Back</button></h6>

				<div class="card-body">
					<form  action="{{route('organization_hierarchy.update',['id' => $organization_hierarchy->id])}}" method="post">
						<input name="_method" type="hidden" value="PUT">
						{{csrf_field()}}
						<div class="form-body">
							<div class="col-md-10">
								<div class="form-group">
									<label class="control-label">Name</label>
									<select class="form-control custom-select" name="employee_id">
										@foreach ($employees as $employee)
											<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->employee_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
										@endforeach
									</select>
								</div>
							</div>
								<div class="col-md-10">
									<div class="form-group">
										<label class="control-label">Line Manager</label>
										<select class="form-control custom-select" name="line_manager_id">
											@foreach ($employees as $employee)
												<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->line_manager_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-md-10">
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

						<div class="form-actions">
							<hr>
							&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Update</button>
							<button type="button" onclick="window.location.href='{{route('organization_hierarchy.index')}}'" class="btn btn-inverse">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
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
