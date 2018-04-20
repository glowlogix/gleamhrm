@extends('layouts.admin')
@section('title')
HRM|{{$title}}
@endsection
@section('content')

<div class="panel panel-default">
	<div class="panel-heading">

			<div style="padding-left: 359px"><b style="text-align: center;" >Users</b></div>
				@if(Auth::user()->admin)

       				<div style="padding-left: 91%;">	 <a href="{{route('user.create')}}" class="btn btn-info btn-xs" align="right">
          					<span class="glyphicon glyphicon-plus"></span> Add User 
      					 </a>
      				</div>	 
      			@endif			 
 					
 				
	</div>
	<div class="panel-body">
		<table class="table">
			<thead>
				<th> Name</th>
				<th> Permissions  </th>
				@if(Auth::user()->admin)
				<th>Activation</th>
				@endif
				<th> Delete </th>
			</thead>
			<tbody class="table-bordered table-hover table-striped">

			@if($users->count() > 0)
					@foreach($users as $user)
				<tr>
					<td>
					 	{{$user->name}}	
					</td>
					<td>
						@if(Auth::user()->admin)
						 	@if($user->admin)
						 		<a href="{{ route('user.not_admin',['id' => $user->id])}}" class="btn btn-xs btn-danger">Remove Permissions</a>
						 	@else
						 		<a href="{{ route('user.admin',['id' => $user->id])}}" class="btn btn-xs btn-success">Make admin</a>
						 	@endif
						@else
							{{$user->admin}}
						@endif	
					</td>
					@if(Auth::user()->admin)
					<td>
						@if($user->status)
						<a href="{{route('user.disable',['id'=>$user->id])}}" class="btn btn-xs btn-danger">Disable </a>
						@else
						<a href="{{route('user.activate',['id'=>$user->id])}}" class="btn btn-xs btn-success">Activate</a>
						@endif
					</td>
					@endif
					<td>
						@if(Auth::user()->admin)
					 	<a href="{{route('user.delete',['id'=>$user->id])}}" class="btn btn-danger">Delete</a> 
					 	@else
					 	delete
					 	@endif
					 </td>
				</tr>
				
					@endforeach
			@else
			 	<tr>
					<th colspan="5" class="text-center">No post found.</th>
				</tr>
					@endif
			</tbody>
		</table>
	</div>
</div>


@stop
