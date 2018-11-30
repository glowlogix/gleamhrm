<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RoleSeeder::class);//make it before employees
        $this->call(EmployeeSeeder::class);
        $this->call(DocumentstableSeeder::class);
        $this->call(LeaveTypeSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(EmployeeLeaveTypeSeeder::class);
        $this->call(DesignationSeeder::class);
         $this->call(DepartmentSeeder::class);
        $this->call(CountrySeeder::class);
    }
}
