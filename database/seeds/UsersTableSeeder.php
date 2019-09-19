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
        $user = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'amadeusjosue5@gmail.com',
            'password' => bcrypt('sadmin'),
        ]);

        $user->assignRole('admin');
    }
}
