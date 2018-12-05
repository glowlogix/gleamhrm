<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.PNG')}}">
	<title>HRM|Glowlogix</title>
	<!-- Bootstrap Core CSS -->
	<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}"  rel="stylesheet">
	<!-- Custom CSS -->
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<!-- You can change the theme colors from here -->
	<link href="{{ asset('css/colors/blue.css') }}" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
		hrml{


		}
		body{
			overflow:hidden auto !important;
			position: absolute !important;

		}
		@media(max-width:767px){
			.login-box{
				width: 370px !important;
			}
		}
		.login-box{

			width: 700px;
		}

	</style>
</head>

<body class="login-register" style="background-image:url({{ asset('assets/images/background/hiring.jpg') }});height: inherit; width:100%;background-size:cover;">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
	<svg class="circular" viewBox="25 25 50 50">
		<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle> </svg>
</div>

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
	<div >
		<div class="login-box">
			<div class=" card-body card">
				@include('admin.includes.errors')
				@if(Session::has('success'))
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Success!</strong> {{Session::get('success')}}
					</div>
				@endif
				@if (Session::has('error'))
					<div class="alert alert-warning" align="left">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>!</strong> {{Session::get('error')}}
					</div>
				@endif
				<h1> Apply for Job </h1>
				<form class="form" action="{{route('applicant.store')}}" method="post" enctype="multipart/form-data" class="form-horizontal ">
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
							<br>
							<div class="show" style="display: none">
								<br>
								Skill Required For This Job: &nbsp &nbsp
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
								<label>Select your avatar: </label>
								<input type="file"  name="avatar" accept="image/*" required  value="{{old('avatar')}}"/>
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="cv">
								<label >Resume:</label><br>
								<input type="file" name="cv" required value="{{old('cv')}}"/>
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
					<div class="form-group">
						<button class="btn btn-primary" type="submit" align="right"> Submit Application</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>
<script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/plugins/popper/popper.min.js')}}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- slimscrollbar scrollbar JavaScript -->
<script  src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('js/sidebarmenu.js')}}"></script>
<!--stickey kit -->
<script  src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('js/custom.min.js') }}"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="{{ asset('assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
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
                            $('#showSkills').append('<div class="btn btn-success" style="margin: 2px">'+value+'</div>');
                        });
                    }
                });
            }
        });
    });
</script>

