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
            'short_name' => 'sick_leaves',
            'name' => 'Sick Leaves',
            'amount' => '12',
        ]);

        $leave_type = LeaveType::create([
            'short_name' => 'casual_leaves',
            'name' => 'Casual Leaves',
            'amount' => '12',
        ]);
    }
}
