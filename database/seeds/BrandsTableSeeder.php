<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Brand::create([
            'name'  => 'brand',
            'created_at'  => now()
        ]);
    }
}
