<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Monthly',
                'slug' => 'monthly',
                'cost' => '9.99',
                'is_primary' => false
            ],
            [
                'name' => 'Annually',
                'slug' => 'annually',
                'cost' => '99',
                'discount' => 10,
                'is_primary' => true
            ],
            [
                'name' => 'Biannually',
                'slug' => 'biannually',
                'cost' => '159',
                'discount' => 26,
                'is_primary' => false
            ]
        ]);
    }
}
