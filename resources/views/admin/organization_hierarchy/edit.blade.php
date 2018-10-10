@extends('layouts.admin') @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b> Edit Organize Employee</b>
		<span style="float: right;">
            <a href="{{route('organization_hierarchy.index')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Back
            </a>
        </span>
	</div>
	<div class="panel-body">

		<form action="{{route('organization_hierarchy.update',['id' => $organization_hierarchy->id])}}" method="post">
			<input name="_method" type="hidden" value="PUT">
			{{csrf_field()}}
			<div class="form-group">
				<label for="name">Name</label>
				<select name="employee_id" class="form-control">
					@foreach ($employees as $employee)
					<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->employee_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="name">Line Manager</label>
				<select name="line_manager_id" class="form-control">
					@foreach ($employees as $employee)
					<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->line_manager_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="name">Parent Employee</label>
				<select name="parent_id" class="form-control">
					@foreach ($employees as $employee)
					<option value="{{$employee->id}}" @if($employee->id == $organization_hierarchy->parent_id) selected @endif>{{$employee->firstname}} {{$employee->lastname}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<a href="{{route('organization_hierarchy.index')}}" class="btn btn-default">Cancel</a>
	            <button class="btn btn-success center-block" style="display: inline; float: left; margin-right: 5px;" type="submit">Update</button>
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
