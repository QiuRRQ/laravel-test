<?php

use Illuminate\Database\Seeder;

class OrdersDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\OrdersDetails::create([
            'variants_id'  => 1,
            'qty_order' => 15,
            'on_cart' => 0,
            'on_buy' => 1,
            'orders_id' => 1,
            'created_at'  => now()
        ]);
    }
}
