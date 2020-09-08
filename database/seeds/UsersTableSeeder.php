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

        $admin = User::create([
            'first_name' => 'Claudia',
            'last_name' => 'Gomez',
            'email' => 'clau.gomezp@gmail.com',
            'password' => bcrypt('sadmin'),
        ]);

        $admin->assignRole('admin');

        $admin = User::create([
            'first_name' => 'Johnny',
            'last_name' => 'Bosche',
            'email' => 'jbosche@hyper-tele.com',
            'password' => bcrypt('sadmin'),
        ]);

        $admin->assignRole('admin');

        $admin = User::create([
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'email' => 'kulpreet+me@i22.in',
            'password' => bcrypt('sadmin'),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'first_name' => 'KK',
            'last_name' => 'KK',
            'email' => 'kulpreet@i22.in',
            'password' => bcrypt('user'),
        ]);

        $user->assignRole('user');


    }
}
