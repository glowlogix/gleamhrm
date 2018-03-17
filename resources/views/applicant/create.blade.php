@extends('layouts.app')

@section('content')
<link href="{{ asset('css/applicantRegistration.css') }}" rel="stylesheet">
	
	<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="" type="text/css">
<div class="body-content">
  <div class="module">
    <h1> Apply for Job </h1>
    <form class="form" action="{{route('applicant.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
    	{{csrf_field()}}
      <label for="category">Select Category</label>
				<select name="category" id="category_id" type="select" class="category form-control">
					@foreach($categories as $categori)
					<option value="{{$categori->id}}">{{$categori->name}}</option>
					@endforeach
				</select>
	  <label for="job">Select job</label>
				<select name="job" id="job" class="job form-control">	
					<option>Please choose Category First</option>	
				</select>
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
	<div class="avatar">
	 	<label>Select your avatar: </label><input type="file" name="avatar" accept="image/*" required />
	</div>	
	<div class="cv">
				<label for="cv">Resume</label>
				<input type="file" name="cv" required/>
	</div>
	<div class="form-group">
				<label for="city">City</label>
				<input type="text" name="city" placeholder="Enter city here" class="form-control">
	</div>
	<div class="form-group  ">
				<label for="job_status" >Job status</label>
				<select name="job_status" id="job_status" class="form-control">
					<option value="Employed">Currently working</option>
					<option value="Unemployed">Currently not working</option>
				</select>
	</div>
	<div class="form-group">
				<button class="btn btn-primary" type="submit"  align="right"> Submit Application</button>
	</div>
    </form>
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
