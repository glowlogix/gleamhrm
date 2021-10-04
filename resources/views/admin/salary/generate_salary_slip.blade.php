<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @if(isset($platform->logo))
          <link rel="icon" type="image/png" sizes="16x16" href="{{public_path($platform->logo)}}">
        @else
            <link rel="icon" type="image/png" sizes="16x16" href="{{public_path('assets/images/company_logo.png')}}">
        @endif
        <title>HRM | @if(isset($platform->name)) {{$platform->name}} @else Company Name @endif</title>

        <!-- Google Font: Source Sans Pro StyleSheet -->
        <link rel="stylesheet" href="{{ public_path('assets/backend/plugins/font-googleapis/font.css') }}">

        <!-- Font Awesome Icons StyleSheet -->
        <link rel="stylesheet" href="{{ public_path('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">

        <!-- Theme  StyleSheet -->
        <link rel="stylesheet" href="{{ public_path('assets/backend/dist/css/adminlte.min.css') }}">

        <!-- jQuery Script -->
        <script src="{{ public_path('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
    </head>

    <body>
        <!-- Main Content Start -->
        <div class="col-12 text-center">
            <h4>
                @if(isset($platform->logo))
                    <img src="{{ public_path($platform->logo) }}" alt="Logo" width="40px">
                @else
                    <img src="{{ public_path('assets/images/company_logo.png') }}" alt="Logo" class="brand-image elevation-3 bg-white" width="80px">
                @endif

                HRM | @if(isset($platform->name)) {{$platform->name}} @else Company Name @endif
            </h4>
        </div>

        <hr>

        @foreach($employees as $employee)
            <div class="bg-dark">
                <h6 class="pl-2 pt-1 pb-1">
                    <i class="fas fa-user fa-sm"></i> Employee Details
                </h6>
            </div>
            
            <table style="width: 100%;">
                <tr class="row">
                    <td style="width: 50%;">
                        <p><b>Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{$employee->firstname}} {{$employee->lastname}}</p>
                        <p>
                            <b>Designation:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            @if($employee->designation != '')
                                {{$employee->designation}}
                            @else
                                N/A
                            @endif
                        </p>
                    </td>
                    <td style="width: 50%;">
                        <p>
                            <b>Department:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            @if($employee->department != '')
                                @foreach($departments as $department)
                                    @if($department->id == $employee->department_id)
                                        {{$department->department_name}}
                                    @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        </p>
                        <p><b>Salary Month:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{$month}}</p>
                    </td>
                </tr>
            </table>

            <div class="bg-dark">
                <h6 class="pl-2 pt-1 pb-1">
                    <i class="fas fa-id-card fa-sm"></i> Contact Details
                </h6>
            </div>
            <table style="width: 100%;">
                <tr class="row">
                    <td style="width: 50%;">
                        <p><b>Contact No:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            @if($employee->contact_no != '')
                                {{$employee->contact_no}}
                            @else
                                N/A
                            @endif
                        </p>
                        <p><b>Official Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            @if($employee->official_email != '')
                                {{$employee->official_email}}
                            @else
                                N/A
                            @endif
                        </p>
                    </td>
                    <td style="width: 50%;">
                        <p><b>Emergency No:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            @if($employee->contact_no != '')
                                {{$employee->contact_no}}
                            @else
                                N/A
                            @endif
                        </p>
                        <p><b>Personal Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            @if($employee->personal_email != '')
                                {{$employee->personal_email}}
                            @else
                                N/A
                            @endif
                        </p>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr class="row">
                    <td class="pl-0 pr-2" style="width: 50%;">
                        <div class="bg-dark">
                            <h6 class="pl-2 pt-1 pb-1">
                                <i class="fas fa-money-bill"></i> Salary Details
                            </h6>
                        </div>
                    </td>
                    <td class="pr-0" style="width: 50%;">
                        <div class="bg-dark">
                            <h6 class="pl-2 pt-1 pb-1">
                                <i class="fas fa-money-bill"></i> Deductions
                            </h6>
                        </div>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr class="row">
                    <td class="pl-0" style="width: 40%;">
                        <p><b>Gross Salary:</b></p>
                        <p><b>Basic Salary:</b></p>
                        @if(isset($employee['salary']->home_allowance))
                        <p><b>Home Allowance:</b></p>
                        @endif
                        @if(isset($employee['salary']->medical_allowance))
                        <p><b>Medical Allowance:</b></p>
                        @endif
                        @if(isset($employee['salary']->special_allowance))
                        <p><b>Special Allowance:</b></p>
                        @endif
                        @if(isset($employee['salary']->meal_allowance))
                        <p><b>Meal Allowance:</b></p>
                        @endif
                        @if(isset($employee['salary']->conveyance_allowance))
                        <p><b>Conveyance Allowance:</b></p>
                        @endif
                        <p><b>Bonus:</b></p>
                    </td>
                    <td style="width: 10%;">
                        <p>
                            @if(isset($employee['salary']->gross_salary))
                                ${{$employee['salary']->gross_salary}}
                            @else
                                $0
                            @endif
                        </p>
                        <p>
                            @if(isset($employee['salary']->basic_salary))
                                ${{$employee['salary']->basic_salary}}
                            @else
                                $0
                            @endif
                        </p>
                        <p>
                            @if(isset($employee['salary']->home_allowance))
                                ${{$employee['salary']->home_allowance}}
                            @endif
                        </p>
                        <p>
                            @if(isset($employee['salary']->medical_allowance))
                                ${{$employee['salary']->medical_allowance}}
                            @endif
                        </p>
                        <p>
                            @if(isset($employee['salary']->special_allowance))
                                ${{$employee['salary']->special_allowance}}
                            @endif
                        </p>
                        <p>
                            @if(isset($employee['salary']->meal_allowance))
                                ${{$employee['salary']->meal_allowance}}
                            @endif
                        </p>
                        <p>
                            @if(isset($employee['salary']->conveyance_allowance))
                                ${{$employee['salary']->conveyance_allowance}}
                            @endif
                        </p>
                        <p>
                            @if($employee->bonus != '')
                                ${{$employee->bonus}}
                            @else
                                $0
                            @endif
                        </p>
                    </td>
                    <td class="pr-0" style="width: 41%;position: relative;">
                        <p style="position: absolute;top: 0px;"><b>Provident Fund:</b></p>
                        <p style="position: absolute;top: 40px;"><b>Absents Deduction:</b></p>
                    </td>
                    <td class="pr-0" style="width: 9%;position: relative;">
                        <p style="position: absolute;top: 0px;">
                            @if(isset($employee['salary']->pf_deduction))
                                ${{$employee['salary']->pf_deduction}}
                            @else
                                $0
                            @endif
                        </p>
                        @php $deduction = $employee->gross_salary - $subtotal; @endphp
                        <p style="position: absolute;top: 40px;">
                            @if($deduction <= 0)
                                $0
                            @else
                                ${{$employee->gross_salary - $subtotal}}
                            @endif
                        </p>
                    </td>
                </tr>
            </table>

            @php
                if(isset($employee['salary']->pf_deduction)){
                    $gross_deduction = $deduction + $employee['salary']->pf_deduction;
                } else {
                    $gross_deduction = $deduction;
                }
            @endphp
            <table style="width: 100%;">
                <tr class="row">
                    <td class="pl-0" style="width: 40%;">
                        <div class="bg-dark">
                            <h6 class="pl-1 pt-1 pb-1"><b>Subtotal:</b></h6>
                        </div>
                    </td>
                    <td class="pl-0 pr-2" style="width: 10%;">
                        <div class="bg-dark">
                            <h6 class="pr-0 pt-1 pb-1">${{$subtotal}}</h6>
                        </div>
                    </td>
                    <td class="pr-0" style="width: 41%;">
                        <div class="bg-dark">
                            <h6 class="pl-1 pt-1 pb-1"><b>Gross Deduction:</b></h6>
                        </div>
                    </td>
                    <td class="pl-0 pr-0" style="width: 9%;">
                        <div class="bg-dark">
                            <h6 class="pr-0 pt-1 pb-1">${{$gross_deduction}}</h6>
                        </div>
                    </td>
                </tr>
            </table>
            <table style="width: 50%; float: right;">
                <tr class="row">
                    <?php $tax = 0; $totalTax = $subtotal / 100 * $tax; ?>
                    <td class="pl-2" style="width: 41%;">
                        <p><b>Tax ({{$tax}}%):</b></p>
                        <hr>
                    </td>
                    <td style="width: 9%;">
                        <p>${{$totalTax}}</p>
                        <hr>
                    </td>
                </tr>
                <tr class="row">
                    @php $netPayable = $subtotal - $totalTax - $gross_deduction; @endphp
                    <td style="width: 41%;">
                        <p class="pl-2"><b>Net Payable:</b></p>
                        <hr>
                    </td>
                    <td style="width: 9%;">
                        <p>
                            @if($netPayable > 0)
                                ${{$netPayable}}
                            @else
                                $0
                            @endif
                        </p>
                        <hr>
                    </td>
                </tr>
            </table>
        @endforeach
        <!-- Main Content End -->
    </body>
</html>