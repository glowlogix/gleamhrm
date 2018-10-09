@extends('layouts.admin') @section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		<b> Update Office Location</b>
		<span style="float: right;">
            <a href="{{route('offices')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon"></span> Back
            </a>
        </span>
	</div>
	<div class="panel-body">

		<form action="{{route('roles_permissions.update',['id'=>$role->id])}}" method="post">
			{{csrf_field()}}
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" placeholder="Enter name here" class="form-control" value="{{$role->name}}">
				<input type="hidden" name="status" value="1">
			</div>

			<div class="form-group">
				<input type="checkbox" id="check_all" value="">Select All
			</div>

			<div class="form-group">
				@foreach ($all_controllers as $key => $row)
				<label for="name">{{$key}}</label>
			 	<br>
				@foreach ($row as $route)
				<input type="checkbox" name="permissions[]" value="web:{{$key}}:{{$route}}"> {{$route}}<br>
				@endforeach
				@endforeach
			</div>
			
			<div class="form-group">
				<a href="{{route('roles_permissions')}}" class="btn btn-default">Cancel</a>
	            <button class="btn btn-success center-block" style="display: inline; float: left; margin-right: 5px;" type="submit">Create</button>
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
    });
});
</script>
@stop
