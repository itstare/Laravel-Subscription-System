@extends('layouts.app')

@push('scripts')
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endpush

@section('content')
@include('partials.authorization')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form action="{{ route('pay') }}" method="POST" id="paymentForm">
                        @csrf
                        <div class="row">
                            <div class="col-auto">
                                <label>How much do you want to pay?</label>
                                <input type="number" name="value" min="5" step="0.01" class="form-control" value="{{ mt_rand(500, 100000) / 100 }}" required>
                                <small class="form-text text-muted">Use values with up to two decimal positions, by using a dot "."</small>
                            </div>
                            <div class="col-auto">
                                <label>Currency</label>
                                <select name="currency" class="form-control" required>
                                    @foreach($currencies as $currency)
                                    <option value="{{ $currency->iso }}">{{ strtoupper($currency->iso) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Select desired payment platform</label>
                                <div class="form-group" id="toggler">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        @foreach($paymentPlatforms as $platform)
                                        <label class="btn btn-outline-secondary rounded m-2 p-1" data-bs-toggle="collapse" data-bs-target="#{{ $platform->name }}Collapse">
                                            <input type="radio" name="paymentPlatform" value="{{ $platform->id }}" required>
                                            <img src="{{ asset($platform->image) }}" class="img-thumbnail">
                                        </label>
                                        @endforeach
                                    </div>
                                    @foreach($paymentPlatforms as $platform)
                                    <div id="{{ $platform->name }}Collapse" class="collapse" data-bs-parent="#toggler">
                                    @include('components.' . strtolower($platform->name) . '-collapse')
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @auth
                        <div class="row">
                            <div class="col-auto">
                                <p class="border-bottom border-primary rounded">
                                        @if(! auth()->user()->hasActiveSubscription())
                                        Would you like discount every time?
                                        <a href="{{ route('subscription.show') }}">Subscribe</a>
                                        @else
                                        You get <span class="fw-bold">10% off</span> as part of your subscription. (This will be applied in the checkout).
                                        @endif
                                </p>
                            </div>
                        </div>
                        @endauth
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="payButton">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stack('stripe-scripts')
@endsection
