<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Resolvers\PaymentPlatformResolver;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware('auth');

        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }
    
    public function pay(Request $request){
        $rules = [
            'value' => ['required', 'numeric', 'min:5'],
            'currency' => ['required', 'exists:currencies,iso'],
            'paymentPlatform' => ['required', 'exists:payment_platforms,id'],
        ];
        
        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->paymentPlatform);
        Session::put('paymentPlatformId', $request->paymentPlatform);

        if ($request->user()->hasActiveSubscription()) {
            $request->value = round($request->value * 0.9, 2);
        }

        return $paymentPlatform->handlePayment($request);
    }

    public function approval(){
        if (Session::has('paymentPlatformId')) {
            $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('paymentPlatformId'));

            return $paymentPlatform->handleApproval();    
        }

        return redirect()->route('home')->withErrors('We can not retrive Payment platform. Please try again.');        
    }

    public function cancelled(){
        return redirect()->route('home')->withErrors('You have cancelled the payment.');
    }
}
