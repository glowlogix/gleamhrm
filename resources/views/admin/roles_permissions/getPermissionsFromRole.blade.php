
<input type="checkbox" id="check_all"/>
<label for="check_all">Select All</label>
<br>
<br>

<div class="form-group row">
	@foreach ($all_controllers as $key => $row)

	<div class="col-md-4">
			<hr>
		<input type="checkbox" class="check_all_sub" id="{{$key}}">
		<label for="{{$key}}"><b>{{$key}}</b></label>
		<br>
		<div class="{{$key}}">
			@foreach ($row as $route)
			<div class="col-md-6">
				<input type="hidden" name="permissions[]" value="{{$route->id}}" >

				<input type="checkbox" id="perm{{$route->id}}"  name="permissions_checked[]" value="{{$route->id}}" @if(in_array($route->id, $emp_permissions)) checked @endif>

				<label for="perm{{$route->id}}">{{$route->name}}</label>
			</div>
			@endforeach
		</div>
	</div>
	@endforeach
</div>