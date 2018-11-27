<?php

use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Designation::Create([
        "designation_name" 			=> "CEO",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Project Coordinator",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Web Developer",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Junior Web Developer",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Front-end Developer",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Account Sales Executive",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Account Sales Executive",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Sales Officer",
        ]);
        App\Designation::Create([
            "designation_name"     	=> "Digital Marketing Executive",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Content Writer",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Digital Marketer",
        ]);
        App\Designation::Create([
        "designation_name" 			=> "Web Designer Lead",
         ]);
        App\Designation::Create([
            "designation_name" 		=> "Junior Web Designer",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Junior Web Developer",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "HR Manager",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "HR Officer",
        ]);
        App\Designation::Create([
            "designation_name" 		=> "Admin",
        ]);

    }
}
