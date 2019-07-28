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
                'code' => 'CR',
                'cost' => '8',
                'description' => 'Create a Professional Custom Recording',
                'type' => AddonType::OTF
            ],
            [
                'name' => 'Multi-Ring',
                'code' => 'MR',
                'cost' => '5',
                'description' => 'Multiple Ring',
                'type' => AddonType::Subscription
            ],
            [
                'name' => 'Fraud Alert',
                'code' => 'FA',
                'cost' => '5',
                'description' => 'Make sure to be notice when a Fraud occurs',
                'type' => AddonType::Subscription
            ],
            [
                'name' => 'Call Blocker',
                'code' => 'CB',
                'cost' => '5',
                'description' => 'Block any incoming call you want',
                'type' => AddonType::Subscription
            ],
            [
                'name' => 'Additional Numbers',
                'code' => 'AN',
                'cost' => '5',
                'description' => 'Add any numbers you want. Only $5 per number',
                'type' => AddonType::OTF
            ]
        ]);
    }
}
