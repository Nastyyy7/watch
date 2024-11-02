<?php

namespace Database\Seeders;

use App\Models\OrderProduct;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderProduct = OrderProduct::all();
        Review::factory()
            ->count(1)
            ->for(
                $orderProduct->isEmpty() ? OrderProduct::factory() : $orderProduct->random()
            )
            ->create();
    }
}
