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
                <div class="card-header">{{ __('Subscribe') }}</div>

                <div class="card-body">
                    <form action="{{ route('subscription.store') }}" method="POST" id="paymentForm">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>Select your plan</label>
                                <div class="form-group">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        @foreach($plans as $plan)
                                        <label class="btn btn-outline-info rounded m-2 p-3">
                                            <input type="radio" name="plan" value="{{ $plan->slug }}" required>
                                            <p class="h2 fw-bold text-capitalize">{{ $plan->slug }}</p>
                                            <p class="display-4 text-capitalize">{{ $plan->visual_price }}</p>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
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
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="payButton">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stack('stripe-scripts')
@endsection
