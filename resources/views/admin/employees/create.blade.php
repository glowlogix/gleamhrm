@extends('layouts.admin') @section('content')

@if (Session::has('error'))
<div class="alert alert-warning" align="left">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>!</strong> {{Session::get('error')}}
</div>
@endif

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b>Create new employee</b>
    </div>
    <div class="panel-body">
        <form class="form-inline" action="{{route('employee.store')}}" method="post">
            {{csrf_field()}}
            <div class="form-group col-sm-4">
                <label for="firstname">First Name:</label>
<<<<<<< HEAD
                <input style="width: 250px;" type="text" class="form-control" id="firstname" placeholder="Enter First Name" name="firstname" required>
=======
                <input style="width: 250px;" type="text" class="form-control" id="firstname" placeholder="Enter First Name" name="firstname">
>>>>>>> c20c5e38d3ee97b490800e6067225edba3ee08cc
            </div>
            <div class="form-group col-sm-4">
                <label for="lastname">Last Name:</label>
<<<<<<< HEAD
                <input style="width: 250px;" type="text" class="form-control" id="lastname" placeholder="Enter Last Name" name="lastname" required>
=======
                <input style="width: 250px;" type="text" class="form-control" id="lastname" placeholder="Enter Last Name" name="lastname">
>>>>>>> c20c5e38d3ee97b490800e6067225edba3ee08cc
            </div>
            <div class="form-group col-sm-4">
                <label for="fullname">Full Name:</label>
                <input style="width: 250px;" type="text" class="form-control" id="fullname" placeholder="Enter Full Name" name="fullname" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="email">Email Address:</label>
                <input style="width: 250px;" type="email" class="form-control" id="email" placeholder="Enter Email Address" name="email" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="text">Salary:</label>
                <input style="width: 250px;" type="text" class="form-control" id="salary" placeholder="Enter Salary" name="salary">
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="contact">Contact#:</label>
                <input style="width: 250px;" type="Number" class="form-control" id="contact" placeholder="Enter Contact Number" name="contact" required>
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="emergency_contact">Emergency Contact#:</label>
                <input style="width: 250px;" type="Number" class="form-control" id="emergency_contact" placeholder="Enter Emergency Contact Number"
<<<<<<< HEAD
                    name="emergency_contact" required>
=======
                    name="emergency_contact">
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="emergency_contact">Emergency Contact Relationship:</label>
                <input style="width: 250px;" type="text" class="form-control" id="emergency_contact_relationship" placeholder="Enter Emergency Contact Relationship"
                    name="emergency_contact_relationship">
>>>>>>> c20c5e38d3ee97b490800e6067225edba3ee08cc
            </div>
            <div class="form-group col-sm-4">
                <br>
                <label for="org_email">Org Email:</label>
                <input style="width: 250px;" type="email" class="form-control" id="org_email" placeholder="Enter Organization Email" name="org_email" required>
                <br>
            </div>
            <br>
            <br>
            <br>
            <div class="form-group  col-sm-4" style="padding-left: 80px;">
                <br>
                <label>
                    <input type="hidden" name="asana" value="0" />
                    <input type="checkbox" class="asana" name="asana" value="1" /> Invite to Asana
                </label>
            </div>
            <div class="form-group  col-sm-4" style="padding-left: 80px;">
                <br>
                <label>
                    <input type="hidden" name="slack" value="0" />
                    <input type="checkbox" name="slack" value="1" /> Invite to Slack
                </label>
            </div>
            <div class="form-group  col-sm-4" style="margin-bottom: 20px;padding-left: 80px;">
                <br>
                <label>
                    <input type="hidden" name="zoho" value="0" />
                    <input type="checkbox" name="zoho" id="zoho" value="1" /> Invite to Zoho
                </label>
            </div>
            <div style="margin-bottom: 19px;">
                <br>
                <button type="submit" id="sub" class="btn  btn-primary center-block">Add User</button>
                <div class="col-md-5">
                    <ul id="asana_teams">
                    </ul>
                </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function () {
                var teams = $('#asana_teams');
                var count = 0;
                var orgId = '{{config('values.asanaWorkspaceId')}}';
                var token = '{{config('values.asanaToken')}}';

                $('#zoho').bind('click', function () {
                    if ($(this).is(':checked')) {
                        alert("No data added in zoho, because of API problem.")
                        this.checked= null;
                    }
                });
             
                $('.asana').bind('click', function () {
                    if ($(this).is(':checked')) {
                      
                        $.ajax({
                            url: "https://app.asana.com/api/1.0/organizations/"+orgId+"/teams",
                            type: 'GET',
                            cache: false,
                            dataType: 'json',
                            beforeSend: function (xhr) {
                                xhr.setRequestHeader('Authorization', 'Bearer '+token);
                            },
                            success: function (res) {
                                count++;
                                if (count == 1) {
                                    teams.append("<h3 class='head'>Teams in Asana</h3>");
                                    res.data.forEach(function (item, index) {
                                        teams.append("<li class='teams'>" + item.name +
                                            " <input name='teams[]' value='" +
                                            item.id + "' type='checkbox'></li>"
                                        );

                                    });

                                }
                                teams.show();

                            },
                            error:function(err){
                                console.log(err);
                            }

                        })
                    } else {
                        teams.hide();
                    }
                });

            });
        </script>
    </div>
</div>

@stop