<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            'USD',
            'GBP',
            'EUR',
            'JPY',
        ];       

        foreach($currencies as $currency){
            Currency::create([
                'iso' => $currency,
            ]);
        } 
    }
}
