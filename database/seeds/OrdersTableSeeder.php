<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Orders::create([
            'user_id'  => 1,
            'order_status' => 'finish',
            'total_price' => 15000,
            'date_ordered' => now(),
            'created_at'  => now()
        ]);
    }
}
