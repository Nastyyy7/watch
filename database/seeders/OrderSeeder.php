<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $statuses = Status::all();
        Order::factory()
            ->count(1)
            ->for(
                $users->isEmpty() ? User::factory() : $users->random()
            )
            ->hasAttached(
                $statuses->isEmpty() ?
                    Status::factory()->count(3)
                    :
                    $statuses->random(1, $statuses->count())
            )
            ->create();
    }
}
