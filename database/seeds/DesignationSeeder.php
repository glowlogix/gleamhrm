<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $designations = [
            ['designation_name' => 'CEO'],
            ['designation_name' => 'Project Coordinator'],
            ['designation_name' => 'Web Developer'],
            ['designation_name' => 'Junior Web Developer'],
            ['designation_name' => 'Web Developer'],
            ['designation_name' => 'Front-end Developer'],
            ['designation_name' => 'Account Sales Executive'],
            ['designation_name' => 'Sales Officer'],
            ['designation_name' => 'Digital Marketing Executive'],
            ['designation_name' => 'Account Sales Executive'],
            ['designation_name' => 'Content Writer'],
            ['designation_name' => 'Digital Marketer'],
            ['designation_name' => 'Web Designer Lead'],
            ['designation_name' => 'Junior Web Designer'],
            ['designation_name' => 'HR Manager'],
            ['designation_name' => 'HR Officer'],
            ['designation_name' => 'Admin'],
            ];
        DB::table('designations')->insert($designations);

    }
}
