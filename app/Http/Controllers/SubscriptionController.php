<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PaymentPlatform;
use App\Resolvers\PaymentPlatformResolver;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver){
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function show(){
        $paymentPlatforms = PaymentPlatform::where('subscriptions_enabled', true)->get();

        return view('subscribe')->with([
            'plans' => Plan::all(),
            'paymentPlatforms' => $paymentPlatforms,
        ]);
    }

    public function store(Request $request){
        $rules = [
            'plan' => ['required', 'exists:plans,slug'],
            'paymentPlatform' => ['required', 'exists:payment_platforms,id'],
        ];
        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->paymentPlatform);
        session()->put('subscriptionPlatformId', $request->paymentPlatform);

        return $paymentPlatform->handleSubscription($request);
    }

    public function approval(Request $request){
        $rules = [
            'plan' => ['required', 'exists:plans,slug']
        ];
        $request->validate($rules);

        if(session()->has('subscriptionPlatformId')){
            $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('subscriptionPlatformId'));
            if($paymentPlatform->validateSubscription($request)){
                $plan = Plan::where('slug', $request->plan)->firstOrFail();
                $user = $request->user();

                $subscription = Subscription::create([
                    'active_until' => now()->addDays($plan->duration_in_days),
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                ]);

                return redirect()->route('home')->withSuccess(['payment' => "Thanks, {$user->name}. Now you have {$plan->slug} subscription. Enjoy!"]);
            }
        }

        return redirect()->route('subscription.show')->withErrors('We can not confirm your subscription. Please, try again.'); 
    }

    public function cancelled(){
        return redirect()->route('subscription.show')->withErrors('You have cancelled. You can try again when ready.');
    }
}
