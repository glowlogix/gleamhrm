<div class="form-group row">
	@foreach ($all_controllers as $key => $row)
		<div class="col-md-12">
			<div class="row">
				<label class="col-12" for="{{$key}}"><input type="checkbox" class="check_all_sub mr-1" id="{{$key}}"><b>{{$key}}</b></label>
			</div>

			<hr class="mt-0">

			<div class="{{$key}} row">
				@foreach ($row as $route)
				<div class="col-lg-4 col-md-4 col-sm-4">
					<input type="hidden" name="permissions[]" value="{{$route->id}}" >

					@php $route_name = explode(':', $route->name); @endphp
					<label class="font-weight-normal col-12" for="perm{{$route->id}}"><input type="checkbox" id="perm{{$route->id}}" class="mr-1" name="permissions_checked[]" value="{{$route->id}}" @if(in_array($route->id, $emp_permissions)) checked @endif>{{$route_name[1]}}</label>
				</div>
				@endforeach
			</div>
			<br>
		</div>
	@endforeach
</div>
<script>
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