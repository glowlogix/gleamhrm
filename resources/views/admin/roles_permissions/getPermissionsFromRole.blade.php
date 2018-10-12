
<div class="form-group">
<input type="checkbox" id="check_all">Check All<br>
	@foreach ($permissions as $route)
	<input type="hidden" name="permissions[]" value="{{$route->id}}" >
	<input type="checkbox" name="permissions_checked[]" value="{{$route->id}}">{{$route->guard_name}}:{{$route->name}}<br>
	@endforeach
</div>

