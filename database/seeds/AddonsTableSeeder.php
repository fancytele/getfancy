<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\AddonType;

class AddonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addons')->insert([
            [
                'name' => 'Professional Greeting/Custom Recordings',
                'code' => 'F01',
                'cost' => '8',
                'description' => 'Create a Professional Custom Recording',
                'type' => AddonType::OTF
            ],
            [
                'name' => 'Multi-Ring',
                'code' => 'F02',
                'cost' => '5',
                'description' => 'Multiple Ring',
                'type' => AddonType::SUBSCRIPTION
            ],
            [
                'name' => 'Fraud Alert',
                'code' => 'F03',
                'cost' => '5',
                'description' => 'Make sure to be notice when a Fraud occurs',
                'type' => AddonType::SUBSCRIPTION
            ],
            [
                'name' => 'Call Blocker',
                'code' => 'F04',
                'cost' => '5',
                'description' => 'Block any incoming call you want',
                'type' => AddonType::SUBSCRIPTION
            ],
            [
                'name' => 'Additional Numbers',
                'code' => 'F05',
                'cost' => '5',
                'description' => 'Add any numbers you want. Only $5 per number',
                'type' => AddonType::OTF
            ]
        ]);
    }
}
