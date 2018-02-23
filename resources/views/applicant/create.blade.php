@extends('layouts.app')

@section('content')
	
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
	<div class="panel-body">
		
		<form action="{{route('applicant.store')}}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<div class="form-group">
				<label for="category">Select Category</label>
				<select name="category" id="category_id" class="category form-control">
					@foreach($categories as $categori)
					<option value="{{$categori->id}}">{{$categori->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="job">Select job</label>
				<select name="job" id="job" class="job form-control">	
					<option>Please choose Category First</option>	
				</select>
			</div>


			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" placeholder="Enter name here" class="form-control">
			</div>
			<div class="form-group">
				<label for="fname">Father Name</label>
				<input type="text" name="fname" placeholder="Enter name here" class="form-control">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" placeholder="Enter email here" class="form-control">
			</div>
			<div class="form-group">
				<label for="avatar" >Image</label>
				<input type="file" name="avatar" class="form-control">
			</div>
			<div class="form-group">
				<label for="cv">Resume</label>
				<input type="file" name="cv" placeholder="upload resumes" class="form-control">
			</div>
			<div class="form-group">
				<label for="city">City</label>
				<input type="text" name="city" placeholder="Enter city here" class="form-control">
			</div>
			<div class="form-group">
				<label for="job_status" >Job status</label>
				<select name="job_status" id="job_status" class="form-control">
					<option value="Employed">Currently working</option>
					<option value="Unemployed">Currently not working</option>
				</select>
			</div>
			

			<div class="form-group">
				<button class="btn btn-success center-block" type="submit"> Submit Application</button>
			</div>
		</form>
	 </div>
        </div>
    </div>
</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('change','.category',function(){
				var cat_id=$(this).val();
				var div=$(this).parent();
				$.ajax({
					type:'get',
					url:'/findjob',
					data:{'id':cat_id},
					success:function(data){
                		var model = $('#job');
            			model.empty();
            			$.each(data, function(i, item) {
               		 	 model.append("<option value='"+item.id+"'>" + item.title + "</option>");
                    	});
                }
			});
		});
	});
	</script>
	

@stop
