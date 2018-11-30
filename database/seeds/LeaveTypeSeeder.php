<?php

use Illuminate\Database\Seeder;
use App\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leave_type = LeaveType::create([
            'name' => 'Sick Leaves',
            'count' => '12',
        ]);

        $leave_type = LeaveType::create([
            'name' => 'Casual Leaves',
            'count' => '12',
        ]);
    }
}
