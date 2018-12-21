@extends('layouts.admin')
@section('Heading')
    @if(Auth::user()->isAllowed('LeaveController:adminCreate'))
    <button type="button"  onclick="window.location.href='{{route('admin.createLeave')}}'" class="btn btn-info btn-rounded m-t-10 float-right"><span class="fas fa-plus"></span> Add Employee Leave</button>
   @endif
    <h3 class="text-themecolor">Employee Leaves</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Attendance</li>
        <li class="breadcrumb-item active">Employee Leaves</li>
    </ol>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="float-right">
                <select class="form-control" id="filter">
                    <option>All</option>
                    <option @if($id=='Approved') selected @endif>Approved</option>
                    <option @if($id=='Declined') selected @endif >Declined</option>
                </select>
            </div>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                    @if(count($employees) > 0)
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Subject</th>
                            <th>Actions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        @if (empty($employee->id))
                            @continue
                        @endif
                        <tr>
                            <td>{{$employee->firstname}} {{$employee->lastname}}</td>
                            <td>{{$employee->leaveType->name}}</td>
                            <td>{{Carbon\Carbon::parse($employee->datefrom)->format('d-m-Y')}}</td>
                            <td>{{Carbon\Carbon::parse($employee->dateto)->format('d-m-Y')}}</td>
                            <td>{{$employee->leave_subject}}</td>
                            <td class="row">
                                @if(
                                    ($employee->leave_status == 'Pending' && $employee->leave_status == '')
                                )
                                    <form action="{{ route('leave.destroy' , $employee->employee_id )}}" method="post">
                                        {{ csrf_field() }}
                                        <button class=" btn btn-danger btn-sm " type="submit"><i class="fas fa-window-close text-white "></i></button>
                                    </form>
                                    &nbsp;
                                    <a class="btn btn-info btn-sm" href="{{route('leave.edit',['id'=>$employee->leave_id])}}" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white "></i></a>
                                @endif
                                &nbsp;
                                <a class="btn btn-info btn-sm" href="{{route('leave.show',['id'=>$employee->leave_id])}}" data-toggle="tooltip" data-original-title="Show"> <i class="fas fa-eye text-white "></i></a>
                            </td>
                            <td>
                                @if($employee->leave_status == '' || strtolower($employee->leave_status) == 'pending')
                                    @if(Auth::user()->id == 1 || (Auth::user()->id != $employee->id))
                                        <select class="update_status form-control" id="{{$employee->leave_id}}" style="width:160px;">
                                            <option value="">Update Status</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Declined">Declined</option>
                                        </select>
                                    @endif
                                @endif

                                @if(strtolower($employee->leave_status) == 'approved' || strtolower($employee->leave_status) == 'declined')
                                    {{$employee->leave_status}}
                                @endif
                            </td>
                        </tr>
                    @endforeach @else
                        <p style="text-align: center;">No Leave Found</p> @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
        $(document).ready(function () {
            $("#filter").change(function(e){
                    var url = "{{route('employeeleaves')}}/" + $(this).val();

                if (url) {
                    window.location = url;
                }
                return false;
            });
        });
    </script>
        <script type="text/javascript">
            $(".update_status").on('change', function (event) {
                if ($(this).val() !== '') {
                    location.href = "{{url('/')}}/leave/updateStatus/" + $(this).attr('id') + '/' + $(this).val();
                }
            });
        </script>
        <script>
            $(function () {
                $('#myTable').DataTable(
                    {

                        info: false,
                        ordering:false

                    }
                );

            });
        </script>
    @endpush
@stop