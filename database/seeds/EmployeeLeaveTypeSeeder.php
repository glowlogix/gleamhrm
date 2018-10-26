<?php

use Illuminate\Database\Seeder;
use App\EmployeeLeaveType;

class EmployeeLeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leave_type = EmployeeLeaveType::create([
            'employee_id' => '1',
            'leave_type_id' => '1',
            'count' => '12',
        ]);

        $leave_type = EmployeeLeaveType::create([
            'employee_id' => '1',
            'leave_type_id' => '2',
            'count' => '12',
        ]);

        $leave_type = EmployeeLeaveType::create([
            'employee_id' => '2',
            'leave_type_id' => '1',
            'count' => '12',
        ]);

        $leave_type = EmployeeLeaveType::create([
            'employee_id' => '2',
            'leave_type_id' => '2',
            'count' => '12',
        ]);
    }
}
