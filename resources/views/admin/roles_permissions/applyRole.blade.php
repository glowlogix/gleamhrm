@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Apply Role</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Roles Permission</li>
		<li class="breadcrumb-item active">Apply</li>
	</ol>
@stop
@section('content')
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b>Apply Role to Employee</b>
		<span style="float: right;">
            <a href="{{route('roles_permissions')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Back
            </a>
        </span>
	</div>
	<div class="panel-body">

		<form action="{{route('roles_permissions.applyrolepost')}}" method="post">
			{{csrf_field()}}
			<div class="form-group">
				<label for="role_id">Role</label>
				<select name="role_id" id="role_id" class="form-control">
				@foreach ($roles as $role)
				<option value="{{$role->id}}">
					{{$role->name}}
				</option>
				@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="employee_id">Employee</label>
				<select name="employee_id" id="employee_id" class="form-control">
				@foreach ($employees as $employee)
					<option value="{{$employee->id}}">
						{{$employee->firstname}} {{$employee->lastname}}
					</option>
				@endforeach
				</select>
			</div>
			<div class="form-group">
				<a href="{{route('roles_permissions')}}" class="btn btn-default">Cancel</a>
	            <button class="btn btn-success center-block" style="display: inline; float: left; margin-right: 5px;" type="submit">Apply</button>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $(function () {
	    $("#check_all").click(function(){
		    $('input:checkbox').not(this).prop('checked', this.checked);
		});
		$(".check_all_sub").click(function(){
		    $('div.'+ this.id +' input:checkbox').prop('checked', this.checked);
		});
    });
});
</script>
@stop
