<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            [
                'name' => 'Montlhy',
                'slug' => 'monthly',
                'stripe_plan' => 'Montlhy',
                'cost' => '9.99',
                'is_primary' => false
            ],
            [
                'name' => 'Annually',
                'slug' => 'annually',
                'stripe_plan' => 'Annually',
                'cost' => '99',
                'is_primary' => true
            ],
            [
                'name' => 'Biannually',
                'slug' => 'biannually',
                'stripe_plan' => 'Biannually',
                'cost' => '159',
                'is_primary' => false
            ]
        ]);
    }
}
