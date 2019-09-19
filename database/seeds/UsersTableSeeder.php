<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'amadeusjosue5@gmail.com',
            'password' => bcrypt('sadmin'),
        ]);

        $admin->assignRole('admin');

        $agent = User::create([
            'first_name' => 'Agent',
            'last_name' => 'Nicoya',
            'email' => 'amadeusjosue5+agent@gmail.com',
            'password' => bcrypt('agent_nicoya'),
        ]);

        $agent->assignRole('agent');
    }
}
