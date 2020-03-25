<?php

use Illuminate\Database\Seeder;

class VariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Variants::create([
            'color'  => 'red',
            'size' => 'XL',
            'stock' => '100',
            'price' => '15000',
            'products_id' => 1,
            'disabled' => '0',
            'created_at'  => now()
        ]);
    }
}
