<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class cuomerOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Customer Order.
        DB::table('customer_orders')->insert([
                'orderId' => 1,
                'productId' => 1,
                'price' => 50.50,
            ]);
        DB::table('customer_orders')->insert([
            'orderId' => 1,
            'productId' => 2,
            'price' => 50.50,

        ]);
        DB::table('customer_orders')->insert([
            'orderId' => 1,
            'productId' => 3,
            'price' => 50.50,
        ]);
        DB::table('customer_orders')->insert([
            'orderId' => 1,
            'productId' => 1,
            'price' => 50.50,

        ]);
        DB::table('customer_orders')->insert([
            'orderId' => 1,
            'productId' => 4,
            'price' => 50.50,

        ]);
        DB::table('customer_orders')->insert([
            'orderId' => 1,
            'productId' => 5,
            'price' => 50.50,

        ]);
        DB::table('customer_orders')->insert([
            'orderId' => 1,
            'productId' => 6,
            'price' => 50.50,
        ]);
    }
}
