<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Department::Create([
        'department_name'      => 'HR',
        'status'    => 'Active',
    ]);
        App\Department::Create([
            'department_name'      => 'Development',
            'status'    => 'Active',
        ]);
    }
}
