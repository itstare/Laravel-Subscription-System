<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentPlatform;

class PaymentPlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentPlatform::create([
            'name' => 'PayPal',
            'image' => 'img/payment-platforms/paypal.jpg',
        ]);
        PaymentPlatform::create([
            'name' => 'Stripe',
            'image' => 'img/payment-platforms/stripe.jpg',
        ]);
    }
}
