@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Sheet</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Attendance</li>
        <li class="breadcrumb-item active">Sheet</li>
    </ol>
@stop
@section('content')
<div class="panel-body" class="col-md-6">
            <div class="select-month">
                <!-- <lable style=" margin-top: 0px;">Select Month</lable> -->
            
                    <select name="attend-month" id="attend-month" class="soflow center-text" style=" margin-top: 0px;" >
                        <option class="center-text" >--Select Month--</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_1'])}}">January</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_2'])}}">February</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_3'])}}">March</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_4'])}}" >April</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_5'])}}">May</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_6'])}}">June</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_7'])}}" >July</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_8'])}}" >August</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_9'])}}">September</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_10'])}}">October</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_11'])}}">November</option>
                        <option class="center-text" value="{{route('attendance.sheet',['id'=>'2018_12'])}}" >December</option>
                    </select> 
            </div>
            <lable class="lable-month" style=" margin-top: 0px;">{{$name}}</lable>
            <?php
            if($date==1){$begin = new DateTime('2018-1-01');$end = new DateTime('2018-1-31');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==2){$begin = new DateTime('2018-2-01');$end = new DateTime('2018-2-28');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==3){$begin = new DateTime('2018-3-01');$end = new DateTime('2018-3-31');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==4){$begin = new DateTime('2018-4-01');$end = new DateTime('2018-4-30');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==5){$begin = new DateTime('2018-5-01');$end = new DateTime('2018-5-31');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==6){$begin = new DateTime('2018-6-01');$end = new DateTime('2018-6-30');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==7){$begin = new DateTime('2018-7-01');$end = new DateTime('2018-7-31');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==8){$begin = new DateTime('2018-8-01');$end = new DateTime('2018-8-31');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==9){$begin = new DateTime('2018-9-01');$end = new DateTime('2018-9-30');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==10){$begin = new DateTime('2018-10-01');$end = new DateTime('2018-10-31');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==11){$begin = new DateTime('2018-11-01');$end = new DateTime('2018-11-30');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            if($date==12){$begin = new DateTime('2018-12-01');$end = new DateTime('2018-12-31');
                while ($begin <= $end){ if($begin->format("D") == "Sun") 
                {$sunday[] = $begin->format("Y-m-d");}
                $begin->modify('+1 day');}
            }
            ?>
	<table class="table table-attendance col-sm-8" style=" margin-top: 0px;">
		<thead >
             <th colspan='2' style="background-color: #808080;">Name</th>
            @for($i=01; $i<=31;$i++)
			    <th style="background-color: #808080; padding: 5px; text-align: left; font-size: 10px;">{{$i}}</th>
            @endfor
		</thead>
        <tbody class="table-bordered table-hover table-striped">
        <?php
           
            $m =(int)$date;?>
            @foreach($employees as $employee)
              <?php  $status = "";
                $attendances =  DB::table('attendance_summaries')->select('status', 'first_time_in', 'date')->where('employee_id',$employee->id) ->orderBy('first_time_in', 'DESC')->get();
                $leaves =  DB::table('leaves')->select('leave_type', 'datefrom')->where('employee_id',$employee->id) ->orderBy('datefrom', 'DESC')->get();
               
                ?>
                <tr>
                 <td colspan='2' style=" border: 1px solid #ddd;font-size: 10px;">{{$employee->firstname}} {{$employee->lastname}}</td>
                    <?php
                   
                    for($int = 1 ; $int <=31 ; $int++){
                        // $status = ""; 
                        foreach($attendances as $attendance){

                          $date = $attendance->date;
                          $month = explode('-',$date);
                          $month = $month[1];

                          $val = explode('-',$attendance->first_time_in);

                          if($date == $int && $month==$m){
                                $status = $attendance->status;
                                if($status == "present")
                                $status="P";
                                break;
                            
                          }else{
                              $status = "";
                          }
                        }
                          foreach($leaves as $leave){
                            $val = explode('-',$leave->datefrom);
                            $date = explode(' ',$val[2]);
                            if($date[0] == $int && $val[1]==$m){
                                  $status = $leave->leave_type;
                                  if($status == "Full Leave")
                                  $status="L";
                                  else if($status == "Half Leave")
                                  $status="HL";
                                  else if($status == "Short Leave")
                                  $status="SL";
                                  else if($status == "Paid Leave")
                                  $status="PL";
                                  break;                            
                            }
                        }
                        $var = "";
                        foreach ($sunday as $sundays) {
                            $dt = explode("-",$sundays);
                            $datee = (int)$dt[2];
                            if( $datee==$int){
                                $var = "sunday";
                                ?>
                                <td style="background-color:yellow;"></td>
                                <?php
                                
                            }
                        }
                        if($var == "sunday"){
                            continue;
                        }
                        ?>
                        <td style=" border: 1px solid #ddd; font-size:70%;">{{$status}}</td>
                  <?php  } ?>
                    </tr>
            @endforeach		
        </tbody>
	</table>
    <script>
    $(document).ready(function () {
        jQuery('#attend-month').change(function() {
            var val = $(this).val();
            window.location.assign(val);
         });
    });
    </script>
    
</div>
@stop