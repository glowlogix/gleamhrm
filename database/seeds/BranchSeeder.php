<?php

use Illuminate\Database\Seeder;
use App\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branch = Branch::create([
            'name' => 'GlowLogix', 
            'status' => 1,
            'address' => 'Islamabad',
            'timing_start' => '14:00:00', 
            'timing_off' => '22:00:00',
            'weekend'=> '["Saturday","Sunday"]',
        ]);

        $branch = Branch::create([
            'name' => 'GlowLogix', 
            'status' => 1,
            'address' => 'Gujrat',
            'timing_start' => '09:00:00', 
            'timing_off' => '18:00:00',
            'weekend' => '["Sunday"]',
        ]);
    }
}
