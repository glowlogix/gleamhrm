@extends('layouts.admin')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading text-center">
            <div><b style="text-align: center;">Create Attendance</b></div>
        </div>
        <div class="row">
            <div class="panel-body">
                <form action="{{route('attendance.store')}}" method='POST'>
                    {{csrf_field()}}
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Name:</label>
                                <select class="form-control nameselect2" name="employee_id">
                                    @foreach($employees as $employee)
                                        <option value={{$employee->id}}>{{$employee->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="datepick">Select Date</label></br>
                                <input type="date" name="datepick" id="datepick" class="datepickstyle">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style:"display:relative{ float:left; }, .clearBoth { clear:both; }" >
                                    <label for="delay">Delay</label>
                                    <input type="number" placeholder="0" class="form-control" name="delay">
                                </div>
                             </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <input type="checkbox" id="Checkbox" class="chk" name="Checkbox">
                        <label for="Checkbox" style="margin-top: 14px;">
                            <span class="label-name">CheckIn Time</span>
                            <div class="checkmark">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 125" enable-background="new 0 0 100 100" xml:space="preserve"><g><path d="M50,91C27.393,91,9,72.607,9,50S27.393,9,50,9s41,18.393,41,41S72.607,91,50,91z M50,16   c-18.748,0-34,15.252-34,34c0,18.748,15.252,34,34,34c18.748,0,34-15.252,34-34C84,31.252,68.748,16,50,16z"/></g><path d="M66.141,39.393c-1.367-1.366-3.582-1.366-4.949,0L47.403,53.182l-6.594-6.594  c-1.367-1.366-3.583-1.366-4.95,0c-1.367,1.367-1.367,3.583,0,4.95l9.066,9.066c0.001,0.001,0.001,0.002,0.002,0.003  c0.684,0.684,1.58,1.025,2.475,1.025l0,0c0,0,0,0,0,0c0.896,0,1.792-0.342,2.475-1.025c0.002-0.002,0.003-0.004,0.004-0.005  l16.258-16.258C67.508,42.976,67.508,40.76,66.141,39.393z"/></svg>
                            </div>
                        </label>
                    
                        <input type="checkbox" id="Checkbox2" class="chk"  name="Checkbox2">
                        <label for="Checkbox2">
                            <span class="label-name">CheckOut Time</span>
                            <div class="checkmark">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 125" enable-background="new 0 0 100 100" xml:space="preserve"><g><path d="M50,91C27.393,91,9,72.607,9,50S27.393,9,50,9s41,18.393,41,41S72.607,91,50,91z M50,16   c-18.748,0-34,15.252-34,34c0,18.748,15.252,34,34,34c18.748,0,34-15.252,34-34C84,31.252,68.748,16,50,16z"/></g><path d="M66.141,39.393c-1.367-1.366-3.582-1.366-4.949,0L47.403,53.182l-6.594-6.594  c-1.367-1.366-3.583-1.366-4.95,0c-1.367,1.367-1.367,3.583,0,4.95l9.066,9.066c0.001,0.001,0.001,0.002,0.002,0.003  c0.684,0.684,1.58,1.025,2.475,1.025l0,0c0,0,0,0,0,0c0.896,0,1.792-0.342,2.475-1.025c0.002-0.002,0.003-0.004,0.004-0.005  l16.258-16.258C67.508,42.976,67.508,40.76,66.141,39.393z"/></svg>
                            </div>
                        </label>
                        
                    </div>
                       
                    
                    <div class="container-fluid">
                        <div class="col-md-6">
                            <div class="form-group"  >
                                <label>Time</label>
                                <div class="input-group time" id="timepicker">
                                <input class="form-control" id="timepick" name="timepick"/>
                                <span class="input-group-addon" id="timepicker1">
                                    <i class="fa fa-clock-o" style="font-size:16px"></i>
                                </span>
                            </div>
                        </div>
                    </div>     
                    <div class="col-md-2"  >
                        <div class="form-group" style="padding-top: 12px;">
                            <button class="btn btn-success create-btn" id="add-btn"  type="submit" > Create</button>
                        </div>
                    </div>
                
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                
                $('.create-btn').click(function () {
                   
                });
                $('#timepicker1').click(function(){
                    $("#timepicker").datetimepicker({
                    format: "LT",
                    icons: {
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down"
                    }
                });

                });
            });
           
            $(document).ready(function(){
                $('.nameselect2').select2();
     
                $('input.chk').on('change', function() {
                $('input.chk').not(this).prop('checked', false);  
                });               
            });
            
        </script>
    </div>
@stop