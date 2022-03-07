<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CurrenciesTableSeeder;
use Database\Seeders\PaymentPlatformsTableSeeder;
use Database\Seeders\PlanSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(CurrenciesTableSeeder::class);
        $this->call(PaymentPlatformsTableSeeder::class);
        $this->call(PlanSeeder::class);
    }
}
