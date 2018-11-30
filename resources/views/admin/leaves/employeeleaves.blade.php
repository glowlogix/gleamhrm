@extends('layouts.admin')
@section('Heading')
    <h3 class="text-themecolor">Employee Leaves</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Attendance</li>
        <li class="breadcrumb-item active">Employee Leaves</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle"></h6>

                    <div class="table">
                        <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
                            <thead>
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
                                    <td>{{Carbon\Carbon::parse($employee->leave_datefrom)->format('Y-m-d')}}</td>
                                    <td>{{Carbon\Carbon::parse($employee->leave_dateto)->format('Y-m-d')}}</td>
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
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $(".update_status").on('change', function (event) {
                if ($(this).val() !== '') {
                    location.href = "{{url('/')}}/leave/updateStatus/" + $(this).attr('id') + '/' + $(this).val();
                }
            });
        </script>
    @endpush
@stop