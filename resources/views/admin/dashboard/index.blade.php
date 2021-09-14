@extends('layouts.master')

@section('content')
<!-- Content Header Start -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Content Header End -->

<!-- Widgets Setion Start -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="info-box">
          @if(Auth::user()->isAllowed('DashboardController:index'))
            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Employees</span>
              <span class="info-box-number">{{count($totalemployees)}}</span>
            </div>
          @else
            <span class="info-box-icon bg-success"><i class="fas fa-check-square"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Approved Leaves</span>
              <span class="info-box-number">{{$approvedLeaves}}</span>
            </div>
          @endif
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="info-box">
          @if(Auth::user()->isAllowed('DashboardController:index'))
            <span class="info-box-icon bg-success"><i class="fas fa-database"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Payroll Proc</span>
              <span class="info-box-number">0</span>
            </div>
          @else
            <span class="info-box-icon bg-danger"><i class="fas fa-window-close"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Rejected Leaves</span>
              <span class="info-box-number">{{$rejectedLeaves}}</span>
            </div>
          @endif
        </div>
      </div>
      <div class=" col-lg-4 col-md-4 col-sm-4">
        <div class="info-box">
          @if(Auth::user()->isAllowed('DashboardController:index'))
            <span class="info-box-icon bg-warning"><i class="fas fa-laptop"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Applicants</span>
              <span class="info-box-number">{{$applicants}}</span>
            </div>
          @else
            <span class="info-box-icon bg-warning"><i class="fas fa-minus-square"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Pending Leaves</span>
              <span class="info-box-number">{{$pendingLeaves}}</span>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Widgets Setion End -->

<!-- Main content Start -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div @if(Auth::user()->isAllowed('DashboardController:index')) class="col-lg-6" @else class="col-lg-12" @endif>
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Attendence</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="position-relative mb-4">
              <canvas id="attendance" @if(Auth::user()->isAllowed('DashboardController:index')) style="max-height: 500px;" @else style="max-height: 500px;" @endif></canvas>
            </div>
          </div>
        </div>

        @if(Auth::user()->isAllowed('DashboardController:index'))
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Recently Added Employee</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="card-body b-t collapse show">
                <table class="table v-middle no-border">
                  <tbody>
                  @foreach($employee as $employees)
                    <tr>
                      <td style="width:40px"><img src="{{asset($employees->picture)}}" onerror="this.src='{{asset('assets/images/default.png')}}';" width="55" height="60" class="img-circle" alt="picture"></td>
                      <td>{{$employees->firstname}}</td>
                      <td align="right"><span class="label label-light-danger">{{ $diff = Carbon\Carbon::parse($employees->joining_date)->subMonth()->diffForHumans()}}</span></td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @endif
      </div>

      @if(Auth::user()->isAllowed('DashboardController:index'))
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">Employees</h3>
              </div>
            </div>
            <div class="card-body">
              <div class="position-relative mb-4">
                <canvas id="employees" height="200"></canvas>
              </div>
            </div>
          </div>

          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Gender Ratio</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <canvas id="gender"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
<!-- Main content End -->

@if(Auth::user()->isAllowed('DashboardController:index'))
  <script>
    var ctx = document.getElementById('attendance').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'polarArea',
      data: {
        labels: {!! $chartMonths !!},
        datasets: [{
          label: {!! $chartMonths !!},
          data: {!! $averageAttendance !!},
          backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 215, 0, 0.5)',
            'rgba(128, 128, 0, 0.5)',
            'rgba(154, 205, 50, 0.5)',
            'rgba(0, 128, 128, 0.5)',
            'rgba(112, 128, 144, 0.5)',
            'rgba(139, 69, 19, 0.5)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 215, 0, 1)',
            'rgba(128, 128, 0, 1)',
            'rgba(154, 205, 50, 1)',
            'rgba(0, 128, 128, 1)',
            'rgba(112, 128, 144, 1)',
            'rgba(139, 69, 19, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctx = document.getElementById('employees').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! $DesignationName !!},
        datasets: [{
          label: 'Total',
          data: {!! $designationSeries !!},
          backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 215, 0, 0.5)',
            'rgba(128, 128, 0, 0.5)',
            'rgba(154, 205, 50, 0.5)',
            'rgba(0, 128, 128, 0.5)',
            'rgba(112, 128, 144, 0.5)',
            'rgba(139, 69, 19, 0.5)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 215, 0, 1)',
            'rgba(128, 128, 0, 1)',
            'rgba(154, 205, 50, 1)',
            'rgba(0, 128, 128, 1)',
            'rgba(112, 128, 144, 1)',
            'rgba(139, 69, 19, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctx = document.getElementById('gender').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Male', 'Female'],
        datasets: [{
          label: ['Male', 'Female'],
          data: [{!! $male !!}, {!! $female !!}],
          backgroundColor: [
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 99, 132, 0.5)'
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
@else
  <script>
    var ctx = document.getElementById('attendance').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'polarArea',
      data: {
        labels: {!! $chartMonths !!},
        datasets: [{
          label: {!! $chartMonths !!},
          data: {!! $averageAttendance !!},
          backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 215, 0, 0.5)',
            'rgba(128, 128, 0, 0.5)',
            'rgba(154, 205, 50, 0.5)',
            'rgba(0, 128, 128, 0.5)',
            'rgba(112, 128, 144, 0.5)',
            'rgba(139, 69, 19, 0.5)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 215, 0, 1)',
            'rgba(128, 128, 0, 1)',
            'rgba(154, 205, 50, 1)',
            'rgba(0, 128, 128, 1)',
            'rgba(112, 128, 144, 1)',
            'rgba(139, 69, 19, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
@endif
@stop