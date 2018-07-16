@extends('layouts.admin')

@section('content')
<div class="panel-body">

	<table class="table" class="col-md-8">
		<thead>
             <th></th>
            @for($i=1; $i<=31;$i++)
			    <th>{{$i}}</th>
            @endfor
		</thead>
		
		<tbody class="table-bordered table-hover table-striped">
            @foreach($employee as $employees)
                <tr>
                    <td>
                        {{$employees->firstname}} {{$employees->lastname}}
                    </td>
                    @for($i=1; $i<=31;$i++)
                        <td>
                           <p> P</p>
                        </td>
                    @endfor
                </tr>
            @endforeach
		</tbody>
		


	</table>
</div>
@stop