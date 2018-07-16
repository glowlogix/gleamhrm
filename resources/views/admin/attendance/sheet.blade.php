@extends('layouts.admin')

@section('content')
<div class="panel-body">

	<table class="table" class="col-md-8">
		<thead>
             <th>Name</th>
            @for($i=1; $i<=31;$i++)
			    <th>{{$i}}</th>
            @endfor
		</thead>
        <tbody class="table-bordered table-hover table-striped">
        <?php
            foreach($employees as $employee){
                $atts[$employee->id][] =  DB::table('attandances')->select('status', 'checkintime')->where('employee_id', $employee->id)->get();
                echo"<pre>";
                print_r($atts);
                echo "</pre>";
                ?>
                <tr>
                 <td>{{$employee->firstname}}</td>
                    <?php foreach($atts as $att){
                        if (!empty($att)) {
                            $arg = explode("-",$att->checkintime); ?>
                            
                   
                    <?php
                            for($int = 1 ; $int <= 31 ; $int ++){
                                $date = explode(" ",$arg[2]);
                                if($int == $date[0]){ ?>
                                  <td>{{$att->status}}</td>
                               <?php }
                               else{ ?>
                                  <td>Absent</td>
                            <?php }
                            }
                       }
                       ?>
                       
                   <?php }
                   echo "</tr>" ?>
                    
         <?php   } ?>
		
        </tbody>
		


	</table>
</div>
@stop