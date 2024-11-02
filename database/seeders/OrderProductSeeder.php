<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $orders = Order::all();
        OrderProduct::factory()
            ->count(1)
            ->for(
                $products->isEmpty() ? Product::factory() : $products->random()
            )
            ->for(
                $orders->isEmpty() ? Order::factory() : $orders->random()
            )
            ->create();
    }
}
