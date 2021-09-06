
<input type="checkbox" id="check_all"/>
<label for="check_all">Select All</label>

<hr class="mt-0">

<div class="form-group row">
	@foreach ($all_controllers as $key => $row)
		<div class="col-md-12">
			<div class="row">
				<input type="checkbox" class="check_all_sub" id="{{$key}}">
				<label class="col-12" for="{{$key}}"><b>{{$key}}</b></label>
			</div>

			<hr class="mt-0">

			<div class="{{$key}} row">
				@foreach ($row as $route)
				<div class="col-lg-4 col-md-4 col-sm-4">
					<input type="hidden" name="permissions[]" value="{{$route->id}}" >

					@php $route_name = explode(':', $route->name); @endphp
					<input type="checkbox" id="perm{{$route->id}}" name="permissions_checked[]" value="{{$route->id}}" @if(in_array($route->id, $emp_permissions)) checked @endif>
					<label class="font-weight-normal col-12" for="perm{{$route->id}}">{{$route_name[1]}}</label>
				</div>
				@endforeach
			</div>
		</div>
	@endforeach
</div>