@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Complete the security steps</div>

                <div class="card-body">
                    You need to follow some additional steps from your bank.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
    const stripe = Stripe('{{ config('services.stripe.key') }}');

    stripe.confirmCardPayment(
        "{{ $clientSecret }}",
        {payment_method: "{{ $paymentMethod }}"}
        ).then(function(result){
        if(result.error){
            window.location.replace("{{ route('subscription.cancelled') }}");
        } else {
            window.location.replace("{!! route('subscription.approval', ['plan' => $plan, 'subscription_id' => $subscriptionId]) !!}");
        }
    });
</script>

@endsection
