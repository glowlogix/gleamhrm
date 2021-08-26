<?php

use App\Employee;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = Employee::create([
            'firstname'                      => 'Admin',
            'lastname'                       => '',
            'contact_no'                     => '03324567833',
            'emergency_contact'              => '03324567833',
            'emergency_contact_relationship' => 'brother',
            'password'                       => bcrypt('admin'),
            'identity_no'                    => '1320245699852',
            'date_of_birth'                  => '1998-09-19',
            'official_email'                 => 'admin@glowlogix.com',
            'personal_email'                 => 'admin@gmail.com',
            'designation'                    => 'admin',
            'city'                           => 'Islamabad',
            'joining_date'                   => '2021-08-23',
            'branch_id'                      => '1',
            'status'                         => 0,
            //            'employment_status' => 'permanent',
        ]);

        $role = Role::find(1);
        $employee->assignRole($role);

        $employee = Employee::create([
            'firstname'                      => 'user',
            'lastname'                       => '',
            'contact_no'                     => '03324567844',
            'emergency_contact'              => '03324567844',
            'emergency_contact_relationship' => 'brother',
            'password'                       => bcrypt('123456'),
            'identity_no'                    => '1320245699855',
            'date_of_birth'                  => '1998-09-19',
            'official_email'                 => 'user@glowlogix.com',
            'personal_email'                 => 'user@gmail.com',
            'designation'                    => 'admin',
            'city'                           => 'Islamabad',
            'joining_date'                   => '2021-08-23',
            'gross_salary'                   => 20000,
            'branch_id'                      => '1',
            'status'                         => 1,
            'employment_status'              => 'permanent',
        ]);
    }
}
