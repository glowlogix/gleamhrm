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
        $admin = Employee::create([
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
        $admin->assignRole($role);

        $hr = Employee::create([
            'firstname'                      => 'Hr',
            'lastname'                       => 'Manager',
            'contact_no'                     => '03324567834',
            'emergency_contact'              => '03324567834',
            'emergency_contact_relationship' => 'brother',
            'password'                       => bcrypt('123456'),
            'identity_no'                    => '1320245699855',
            'date_of_birth'                  => '1998-09-19',
            'official_email'                 => 'hr@glowlogix.com',
            'personal_email'                 => 'hr@gmail.com',
            'designation'                    => 'HR Manager',
            'city'                           => 'Islamabad',
            'joining_date'                   => '2021-08-23',
            'gross_salary'                   => 20000,
            'branch_id'                      => 1,
            'department_id'                  => 1,
            'status'                         => 1,
            'employment_status'              => 'permanent',
        ]);

        $role = Role::find(2);
        $hr->assignRole($role);
        $permissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 156, 157, 158, 159, 160, 161];
        $hr->givePermissionTo($permissions);

        $user = Employee::create([
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
            'designation'                    => 'Web Developer',
            'city'                           => 'Islamabad',
            'joining_date'                   => '2021-08-23',
            'gross_salary'                   => 20000,
            'branch_id'                      => 1,
            'department_id'                  => 2,
            'status'                         => 1,
            'employment_status'              => 'permanent',
        ]);
    }
}
