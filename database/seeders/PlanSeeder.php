<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'slug' => 'monthly',
            'price' => 1200,
            'duration_in_days' => 30,
        ]);

        Plan::create([
            'slug' => 'yearly',
            'price' => 9999,
            'duration_in_days' => 365,
        ]);
    }
}
