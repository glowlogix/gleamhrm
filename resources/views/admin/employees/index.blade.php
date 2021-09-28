@extends('layouts.master')

@section('content')
<!-- Breadcrumbs Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employees</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('employees') }}">People Management</a></li>
          <li class="breadcrumb-item active">Employees</li>
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
                        <h4 class="card-title pt-2"> {{$active_employees}}  Active / {{$employees->count()}} Employees</h4>
                        <div class="text-right">
                            <button type="button" onclick="window.location.href='{{route('employee.create')}}'" class="btn btn-info btn-rounded" data-toggle="tooltip" title="Add Employee"><i class="fas fa-plus"></i><span class="d-none d-xs-none d-sm-inline d-md-inline d-lg-inline"> Add Employee</span></button>
                        </div>

                        <hr>

                        <div class="form-group d-flex justify-content-between">
                            <div></div>
                            <select class="form-control mb-3 col-md-3" id="filter">
                                <option value="select">Select Employees</option>
                                @foreach($filters as $filter)
                                <option value="{{$filter}}" @if($filter==$selectedFilter) selected @endif>{{ucfirst(trans($filter))}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table id="employees" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    @if(count($employees) > 0)
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile </th>
                                    <th>Designation</th>
                                    <th>Branch</th>
                                    <th>Department</th>
                                    <th>Joining Date</th>
                                    <th>Employment Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employees as $employee)
                                <tr>
                                    <td>{{$employee->firstname}} {{$employee->lastname}}</td>
                                    <td>{{$employee->official_email}}</td>
                                    <td>{{$employee->contact_no}}</td>
                                    <td>{{ ucfirst(trans($employee->designation))}}</td>
                                    <td>{{isset($employee->branch) ? $employee->branch->name : ''}} ({{$employee->branch->address}})</td>
                                    <td>{{isset($employee->department) ? $employee->department->department_name : ''}}</td>
                                    <td>{{$employee->joining_date}}</td>
                                    <td>{{$employee->employment_status}}</td>
                                    <td class="text-nowrap">
                                        <a class="btn btn-warning btn-sm" href="{{route('employee.edit',['id'=>$employee->id])}}"  data-toggle="tooltip" title="Edit Employee"> <i class="fas fa-pencil-alt text-white"></i></a>
                                    </td>
                                </tr>
                                @endforeach @else
                                    <tr> No Employee Found</tr>
                                @endif
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
        $('#employees').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
    });

    $(document).ready(function () {
        $("#filter").change(function(e){
            if ($(this).val()=== "select" )
            {
                var url = "{{route('employees')}}/"
            }
            else
            {
                var url = "{{route('employees')}}/" + $(this).val();
            }

            if (url)
            {
                window.location = url;
            }
            return false;
        });
    });

    $("input.zoho").click(function (event) {
        if ($(this).is(":checked"))
        {
            $("#div_" + event.target.id).show();
        } 
        else
        {
            $("#div_" + event.target.id).hide();
        }
    });
</script>
@stop
