{{-- D:\wamp64\www\bagisto\resources\views\frontend\pages\shipping_policy.blade.php --}}
@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Moonzio, Shipping Policy.">
    <meta name="description" content="{{ $shipping_policy->description }}">
    <meta property="og:url" content="{{ route('shipping.policy') }}">
    
    <meta property="og:description" content="{{ $shipping_policy->description }}">
@endsection

@section('title', 'Moonzio || SHIPPING POLICY')

@section('main-content')
 
 <section class="shipping-policy section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="title">{{ __('Shipping Policy') }}</h2>
                    <p>{!! $shipping_policy->description !!}</p>
                </div>
            </div>
        </div>
 </section>

 

    <!-- Recently Viewed Products Modal -->
    @include('frontend.partials.product-modal')
@endsection

 