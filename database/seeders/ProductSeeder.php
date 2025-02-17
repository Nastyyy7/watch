<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = Type::all();
        Product::factory()
            ->count(5)
            ->for(
                $types->isEmpty() ? Type::factory() : $types->random()
            )
            ->create();
    }
}
