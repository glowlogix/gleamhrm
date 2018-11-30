@extends('layouts.admin')
@section('Heading')
	<h3 class="text-themecolor">Create Role</h3>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
		<li class="breadcrumb-item active">Roles Permission</li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
@stop
@section('content')

	<div class="row">
		<div class="col-lg-12">
			<div class="card card-outline-info">
				<div style="margin-top:10px; margin-right: 10px;">
					<a class="btn btn-info float-right" href="{{route('roles_permissions')}}"> Back</a>
				</div>
				<div class="card-body">
					<form  action="{{route('roles_permissions.store')}}" method="post" enctype="multipart/form-data">
						{{csrf_field()}}
						<div class="form-body">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Name</label>
									<input  type="text" name="name" placeholder="Enter name here" class="form-control" value="{{old('name')}}">
									<input type="hidden" name="status" value="1">
								</div>
							</div>
						<hr>
							<input type="checkbox" id="check_all"/>
							<label for="check_all">Select All</label>
							<br>
							<br>
							<div class="form-group row">
								@foreach ($all_controllers as $key => $row)
									<div class="col-md-4">
									<hr>
									<input type="checkbox" class="check_all_sub" id="{{$key}}">
									<label for="{{$key}}"><b>{{$key}} :</b></label>
									<br>
									<div class="{{$key}}">
										@foreach ($row as $route)
											<div class="col-md-6">
											<input type="checkbox" id="{{$key}}:{{$route}}" name="permissions[]" value="web:{{$key}}:{{$route}}">
											<label for="{{$key}}:{{$route}}">{{$route}}</label>
											</div>
										@endforeach
									</div>
									</div>
								@endforeach
						</div>
						</div>
						<div class="form-actions">
							&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Create Role</button>
							<button type="button" onclick="window.location.href='{{route('roles_permissions')}}'" class="btn btn-inverse">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@push('scripts')
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
@endpush
@stop
