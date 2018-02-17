@extends('layouts.admin')

@section('content')
	@include('admin.includes.errors')

<div class="panel panel-default">
	<div class="panel-heading text-center">
		Create new User
	</div>
	<div class="panel-body">
			<form class="form-inline" action="{{route('user.store')}}" method="Post">
				{{csrf_field()}}
                <div class="row">
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" placeholder="Enter first name here" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" placeholder="Enter last name here" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" name="fullname" placeholder="Enter Full name here" class="form-control">
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" placeholder="Enter Email here" class="form-control">
                    </div>

                     <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" placeholder="Enter Phone here" class="form-control">
                    </div>

				    <div class=" form-group">
					   <label for="admin">Admin</label>
    					  	<select>   
                              <option value="1">Admin</option>
                              <option value="audi">User</option>
                            </select>
				    </div>
                </div>
                <br>
                <div class="row">
                    <div class="checkbox">
                         <label><input type="checkbox" name="zoho"> Invite to Zoho</label>
                         <label><input type="checkbox" name="slack"> Invite to Slack</label>
                         <label><input type="checkbox" name="asana"> Invite to Asana</label>
                    </div>

                    <div class=" form-group">
                        <label for="password-confirm" class="control-label"> Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                </div>

				<div class="form-group" align="center-block">
					<button class="btn btn-success center-block" type="submit"> Create User</button>
				</div>
                </div>
			</form>
		</div>
</div>

@stop