<?php

use Illuminate\Database\Seeder;

class UserstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=App\User::Create([
        	'name' => 'admin',
        	'email' => 'admin@gmail.com',
        	'password'=>bcrypt('admin'),
        	'admin'=>1
        ]);
    }
}
