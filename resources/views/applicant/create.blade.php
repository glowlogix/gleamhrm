@extends('layouts.application-form')
@section('content')
<div class="preloader">
	<svg class="circular" viewBox="25 25 50 50">
		<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
	</svg>
</div>

<div class="card card-outline card-primary">
	<div class=" card-body">
		<h3>Apply for Job</h3>
		
		<hr>

		<!-- Session Message Section Start -->
		@include('layouts.partials.error-message')
		<!-- Session Message Section End -->

		<form id="applyForm" action="{{route('applicant.store')}}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
			<div class="row">
				<div class="form-group col-md-12">
					<label for="job_id">Select Position</label>
					<select name="position" id="job_id" type="select" class="job_id form-control select" >
						<option value="">Select Position</option>
						@foreach($jobs as $j)
							<option  value="{{$j->id}}" @if(old("job_id") == $j->id ) selected @endif>{{$j->title}}&nbsp({{isset($j->designation) ? $j->designation->designation_name : ''}})</option>
						@endforeach
					</select>
					<div class="show" style="display: none">
						<div  id="showSkills">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label for="name">Location</label>
					<select name="city" id="city" type="select" class="city form-control">
						<option value="Gujrat" @if(old("city") == "Gujrat") selected @endif>Gujrat</option>
						<option value="Islamabad" @if(old("city") == "Islamabad") selected @endif>Islamabad</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label for="name">Name</label>
					<input type="text" name="name" placeholder="Enter name here" class="form-control" value="{{old('name')}}">
				</div>
				<div class="form-group col-md-6">
					<label for="fname">Father Name</label>
					<input type="text" name="fname" placeholder="Enter name here" class="form-control" value="{{old('fname')}}">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<label for="email">Email</label>
					<input type="text" name="email" placeholder="Enter email here" class="form-control" value="{{old('email')}}">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<div >
						<label>Select your avatar:</label><br>
						<input type="file"  name="avatar" accept="image/*" value="{{old('avatar')}}"/>
					</div>
				</div>
				<div class="form-group col-md-6">
					<div >
						<label>Resume:</label><br>
						<input type="file" name="cv" value="{{old('cv')}}"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="job_status">Job status</label>
				<select name="job_status" id="job_status" class="form-control">
					<option value="Employed" @if(old("job_Status") == "Employed") selected @endif >Currently working</option>
					<option value="Unemployed" @if(old("job_Status") == "Unemployed") selected @endif >Currently not working</option>
				</select>
			</div>
			<hr>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" align="right" data-toggle="tooltip" title="Submit"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-check-circle"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Submit</span></button>
				<button type="button" onclick="window.location.href='{{ url('/') }}'" class="btn btn-default" data-toggle="tooltip" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
			</div>
		</form>
	</div>
</div>

<script>
	$(function () {
	  	$('#applyForm').validate({
		    rules: {
		    	position: {
		        	required: true,
		      	},
				name: {
		        	required: true,
		      	},
				fname: {
		        	required: true,
		      	},
				email: {
		        	required: true,
		      	},
				avatar: {
		        	required: true,
		      	},
				cv: {
		        	required: true,
		      	}
		    },
		    messages: {
		    	position: "Position is required",
				name: "Name is required",
				fname: "Father Name is required",
				email: "Email is required",
				avatar: "Picture is required",
				cv: "CV is required"
		    },
		    errorElement: 'span',
		    errorPlacement: function (error, element) {
		      	error.addClass('invalid-feedback');
		      	element.closest('.form-group').append(error);
		    },
		    highlight: function (element, errorClass, validClass) {
		      	$(element).addClass('is-invalid');
		    },
		    unhighlight: function (element, errorClass, validClass) {
		      	$(element).removeClass('is-invalid');
		    }
	  	});
	});

	$(document).ready(function () {
		$(document).on('change', '.category', function () {
			var cat_id = $(this).val();
			var div = $(this).parent();
			$.ajax({
				type: 'get',
				url: '/findjob',
				data: {
					'id': cat_id
				},
				success: function (data) {
					var model = $('#job');
					model.empty();
					$.each(data, function (i, item) {
						model.append("<option value='" + item.id + "'>" + item.title + "</option>");
					});
				}
			});
		});
	});

    jQuery(document).ready(function($) {

        $(".select").on('change', function() {
            $(".show").show();
            $('#showSkills').html('');
            var value = $(this).val();
            if(value){
                $.ajax ({
                    type: 'get',
                    url: "{{URL('/job/skill/')}}/"+value,
					success:function(res){
                        var obj = jQuery.parseJSON( res );
                        $.each(obj,function( index, value ) {
                            $('#showSkills').append('<br> Skill Required For This Job: <br><div class="btn btn-info mt-1">'+value+'</div>');
                        });
                    }
                });
            }
        });
    });
</script>
@endsection

