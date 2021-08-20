<?php

use App\Employee;
use App\Salary;
use App\Traits\ZohoTrait;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    use ZohoTrait;

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
            'zuid'            => '123',
            'account_id'      => '123',
            'invite_to_zoho'  => 0,
            'invite_to_slack' => 0,
            'invite_to_asana' => 0,
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
            'branch_id'                      => '1',
            'status'                         => 1,
            'employment_status'              => 'permanent',
            'zuid'                           => '123',
            'account_id'                     => '123',
            'invite_to_zoho'                 => 0,
            'invite_to_slack'                => 0,
            'invite_to_asana'                => 0,
        ]);

        /*$employees = $this->getZohoAccount();
        $employees = $employees->original->data;
        foreach($employees as $employee){
            $employees = Employee::create([
                'firstname' => $employee->firstName,
                'lastname' => $employee->lastName,
                'fullname' => $employee->firstName.' '.$employee->lastName,
                'contact' => '0332456783',
                'emergency_contact' => '0332456783',
                'emergency_contact_relationship' => 'Cousin',
                'password' => '123456',
                'zuid' => $employee->zuid,
                'account_id' => $employee->accountId,
                'org_email' => $employee->primaryEmailAddress,
                'email' => 'dummy@gmail.com',
                'role' => $employee->role,
                'inviteToZoho' => 1,
                'inviteToSlack' => 0,
                'inviteToAsana' => 1,
                'status' => 1
            ]);
            if($employees){

            Salary::create([
                'employee_id' => $employees->id,
                'basic_salary' => 500
            ]);


            }
        }*/
    }
}
