@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Members of Team "{{$team_name->name}}"</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('teams') }}">People Management</a></li>
          <li class="breadcrumb-item"><a href="{{ url('teams') }}">Teams</a></li>
          <li class="breadcrumb-item active">Team Members</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumbs End -->

<!-- Session Message Section Start -->
@include('layouts.partials.error-message')
<!-- Session Message Section End -->

<!-- Main Content Start -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-info btn-rounded" onclick="window.location.href='{{route('teams.index')}}'" title="Back"><i class="fas fa-chevron-left"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Back</span>
                        </button>

                        <hr>

                        <div class="table-responsive">
                            <table id="team_members" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee_Name</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($team_members as $key=>$team_member)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td> {{isset($team_member->id) ? $team_member->employee->firstname . $team_member->employee->lastname : ''}}</td>
                                            <td class="text-nowrap">
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $team_member->id }}" title="Delete Team Member"> <i class="fas fa-trash-alt text-white"></i> </a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="confirm-delete{{ $team_member->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('team_member.delete' , $team_member->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete "{{$team_name->name}}" Team Member</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete Team Member "{{isset($team_member->id) ? $team_member->employee->firstname : ''}}"?
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-window-close"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Cancel</span></button>
                                                            <button type="submit" class="btn btn-danger btn-ok" title="Delete Team Member"><span class="d-xs-inline d-sm-none d-md-none d-lg-none"><i class="fas fa-trash-alt"></i></span><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Delete</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content End -->

<script>
  $(document).ready(function () {
    $('#team_members').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@stop