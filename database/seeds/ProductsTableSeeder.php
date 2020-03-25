<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Products::create([
            'name'  => 'product',
            'description' => 'description',
            'category_id' => 1,
            'brand_id' => 1,
            'created_at'  => now()
        ]);
    }
}
