@extends('layouts.admin') @section('content')

<div class="panel panel-default">
    <div class="panel-heading text-center">
        <b style="text-align: center;">All Attendance</b>
        <span style="float: left;">
            <a href="{{route('attendance.create')}}" class="btn btn-info btn-xs" align="right">
                <span class="glyphicon glyphicon-plus"></span> Add Attendance
            </a>
        </span>
    </div>
    <div class="panel-body">
        <div id="calender">
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Manage Attendance</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <label for="leave_type">Choose Type</label>
                                    <select class="form-control" name="leave_type" id="leave_type">
                                        <option selected value="present">Present</option>
                                        <option value="Full Leave">Full Leave</option>
                                        <option value="Half Leave">Half Leave</option>
                                        <option value="Short Leave">Short Leave</option>
                                        <option value="Paid Leave">Paid Leave</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-7">
                                        <label for="datefrom">StartDate</label>
                                        <div class='input-group date' id='datefrompicker' name="datefrompicker">
                                            <input type='text' id='datefrom' class="form-control" name="datefrom" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar" id="cl1"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <p id="hello"></p>
                                <div class="form-group">
                                    <div class="col-md-7">
                                        <label for="dateto">EndDate</label>
                                        <div class='input-group date' id='datetopicker' name="datetopicker">
                                            <input type='text' id='dateto' class="form-control" name="dateto" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="form-group">
                                        <div class="col-md-7" style="position:relative;top:10px">

                                            <button type="submit" id="update" data-dismiss="modal" class="btn btn-primary">Update</button>

                                            <button type="submit" id="del" class="btn btn-danger">Delete</button>

                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" id="currentStartTime">
                                <input type="hidden" id="currentEndTime">
                                <input type="hidden" id="currentStatus">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {!! $calendar->calendar() !!} {!! $calendar->script() !!}
    <div id="calendar"></div>

<!--     <script type="text/javascript">
    $(document).ready(function(){
        $('#calendar').fullCalendar({
            "header":{
                "left":"prev,next today",
                "center":"title",
                "right":"month,agendaWeek,agendaDay"
            },
            "eventLimit":true,
            "editable":1,
            "eventClick":function(event) {
                var type = event.title.split("\n")[0];       
                $("#update").unbind("click");     
                $("#del").unbind("click"); 
                var type = $("#leave_type").val(type);
                jQuery("#myModal").modal({backdrop: "static", keyboard: false}, "show");
                
                if(type){
                    $.ajax({
                        type: "GET",                                  
                        url: "http://localhost/hrm/public/admin/attendance/getbyAjax", 
                        dataType : "json",   
                        data: {
                            "id" : event.id,
                            "type" : type.val(),
                             "date" : event.start._i
                        }, 
                        success: function(response){    
                            if(response[1]=="successAttendance"){                    
                            var checkin = $("#datefrom").val(response[0].checkintime);
                            var checkout = $("#dateto").val(response[0].checkouttime);
                            $("#currentStartTime").val(checkin.val());
                            $("#currentEndTime").val(checkout.val());
                            $("#currentStatus").val(response[0].status);

                            }else{
                                var checkin = $("#datefrom").val(response.datefrom);
                                var checkout = $("#dateto").val(response.dateto);
                                $("#currentStartTime").val(checkin.val());
                                $("#currentEndTime").val(checkout.val());
                                $("#currentStatus").val(response.status);
                                
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) { 
                            console.log(JSON.stringify(jqXHR));
                            console.log("AJAX error: " + textStatus + " : " + errorThrown);
                        }

                    });
                }

                $("#update").on("click",function(){
                    $.ajax({
                        type: "POST",                                  
                        url: "http://localhost/hrm/public/admin/attendance/update", 
                        dataType : "json",   
                        data: {
                            "id" : event.id,
                            "type" : $("#leave_type").val(),
                            "datefrom":$("#datefrom").val(),
                            "dateto" : $("#dateto").val(),
                            "currentStartDate" :  $("#currentStartTime").val(),
                            "currentEndDate" :  $("#currentEndTime").val(),  
                            "currentStatus" : $("#currentStatus").val(),
                            
                            "_token" : "iGiRZ8fq2AETFYQ1RxsFqHeS7r6vGNwkk3Az71MG"
                        }, 
                        success: function(response){ 
                            if(response.errors){
                                alert(response.errors[0]);                                    
                            }
                            if(response == "success"){
                                alert("Update Successfully");
                                window.location.reload();
                            }else if(response == "already-present"){
                                alert("Already Present First Remove that employee to make Full Leave");                                    
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) { 
                            console.log(JSON.stringify(jqXHR));
                            console.log("AJAX error: " + textStatus + " : " + errorThrown);
                        }
                    });

                });

                $("#del").on("click",function(){
                    var r = confirm("Are you sure you want to delete?");                  
                    if (r == true) {
                        $.ajax({
                            type: "POST",                                  
                            url: "http://localhost/hrm/public/admin/attendance/delete", 
                            dataType : "json",   
                            data: {
                                "id" : event.id,
                                "type" : $("#leave_type").val(),
                                "date" : event.start._i,
                                "_token" : "iGiRZ8fq2AETFYQ1RxsFqHeS7r6vGNwkk3Az71MG"
                            }, 
                            success: function(response){ 
                                if(response == "success"){
                                    alert("Delete Successfully");
                                    window.location.reload();
                                }

                            },
                            error: function(jqXHR, textStatus, errorThrown) { 
                                console.log(JSON.stringify(jqXHR));
                                console.log("AJAX error: " + textStatus + " : " + errorThrown);
                            }

                        });

                    } else {
                        jQuery("#myModal").modal("toggle");                            
                        
                    }
                });

            },
            "events":[]
        });
    });
    </script> -->

    <script type="text/javascript">
        $(document).ready(function () {
            $(function () {
                $('#datefrompicker').datetimepicker({
                });
                $('#datetopicker').datetimepicker({
                });

            });
        });
    </script>

</div>
@stop