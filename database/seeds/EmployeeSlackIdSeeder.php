<?php

use App\Employee;
use Illuminate\Database\Seeder;

class EmployeeSlackIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $token = config('values.SlackToken');
        $output = file_get_contents('https://slack.com/api/users.list?token='.$token.'&pretty=1');
        $output = json_decode($output, true);
        foreach ($output['members'] as $key => $member) {
            if (isset($member['profile']['email'])) {
                $employee = Employee::where('official_email', $member['profile']['email'])->first();
                if (isset($employee->id)) {
                    $employee = Employee::where('official_email', $member['profile']['email'])->first();
                    $employee->slack_id = $member['id'];
                    $employee->save();
                }
            }
            /*else{
                $employee = Employee::create([
                    'slack_id' => $member['id'],
                    'official_email' => $member['profile']['email'],
                    'personal_email' => $member['profile']['email'],
                    'firstname' => $member['profile']['first_name'],
                    'lastname' => isset($member['profile']['last_name']) ? $member['profile']['last_name'] : '',
                    'contact_no' => $member['profile']['phone'],
                    'password' => bcrypt("123456"),
                    'city' => 'Islamabad',
                    'branch_id' => '1',
                    'status' => 1,
                    'zuid' => '123',
                    'account_id' => '123',
                    'invite_to_zoho' => 0,
                    'invite_to_slack' => 0,
                    'invite_to_asana' => 0,
                ]);
            }*/
        }
    }
}
