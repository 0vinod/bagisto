@extends('frontend.layouts.master')

@section('title', 'Checkout page')

@section('main-content')
    <!-- Modern Breadcrumbs -->
    <div class="modern-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="modern-breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Shopping Cart</a></li>
                            <li class="breadcrumb-item active">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Main Checkout Section -->
    <section class="modern-checkout section">
        <div class="container">
            @php
                $selectedCountry = old(
                    'country',
                    ($lastOrder ? $lastOrder->country : null) ?? ($user ? $user->country ?? 'NP' : 'NP'),
                );
            @endphp

            <form class="checkout-form" method="POST" action="{{ route('cart.order') }}">
                @csrf
                <div class="row g-4">
                    <!-- Billing Details Column -->
                    <div class="col-lg-8 col-12">
                        <div class="billing-details-card">
                            <div class="card-header">
                                <h3><i class="fas fa-file-invoice me-2"></i> Billing Details</h3>
                                <p>Please fill in your information to complete your order</p>
                            </div>
                      <input type="hidden" name="slug" value="{{ old('slug', $product?->slug) }}">

                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="first_name">First Name <span class="required">*</span></label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                id="first_name" name="first_name" placeholder="First Name"
                                                value="{{ old('first_name', ($lastOrder ? $lastOrder->first_name : null) ?? ($firstName ?? '')) }}">
                                            
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <!-- Last Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                                name="last_name" placeholder="Last Name"
                                                value="{{ old('last_name', ($lastOrder ? $lastOrder->last_name : null) ?? ($lastName ?? '')) }}">
                                            <label for="last_name">Last Name <span class="required">*</span></label>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    <!-- Email Address -->
                                    <div class="col-md-6">
                                        <div class="form-group"><label for="email">Email Address <span class="required">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" placeholder="Email Address"
                                                value="{{ old('email', ($lastOrder ? $lastOrder->email : null) ?? ($user ? $user->email : '')) }}">
                                            
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="phone">Phone Number <span class="required">*</span></label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" placeholder="Phone Number"
                                                value="{{ old('phone', $lastOrder ? $lastOrder->phone : '') }}">
                                           
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Country -->
                                    <div class="col-md-6">
                                        <div class="form-group">  <label for="country">Country <span class="required">*</span></label>
                                            <select class="form-select form-control @error('country') is-invalid @enderror"
                                                id="country" name="country">
                                                <option value="IN" {{ $selectedCountry == 'IN' ? 'selected' : '' }}>
                                                    India</option>
                                            </select>
                                           
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">  <label>State <span class="required">*</span></label>
                                            <select id="state-dropdown" name="state_id" class="form-control" required>
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                              <label>City <span class="required">*</span></label>
                                                <select id="city-dropdown" name="city" class="form-control" required> 
                                                    <option value="">Select State First</option>
                                                </select>          
                                        </div>
                                    </div>

                                        <!-- Address Line 1 -->
                                        <div class="col-md-6">
                                            <div class="form-group">   <label for="address1">Address Line 1 <span class="required">*</span></label>
                                                <input type="text" class="form-control @error('address1') is-invalid @enderror"
                                                    id="address1" name="address1" placeholder="Address Line 1"
                                                    value="{{ old('address1', $lastOrder ? $lastOrder->address1 : '') }}"> 
                                                @error('address1')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Address Line 2 -->
                                        <div class="col-md-6">
                                            <div class="form-group">  
                                            <label for="address2">Address Line 2 (Optional)</label>
                                                <input type="text" class="form-control @error('address2') is-invalid @enderror"
                                                    id="address2" name="address2" placeholder="Address Line 2"
                                                    value="{{ old('address2', $lastOrder ? $lastOrder->address2 : '') }}">
                                                @error('address2')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- City/Town -->
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control @error('city') is-invalid @enderror"
                                                    id="city" name="city" placeholder="City/Town"
                                                    value="{{ old('city', $lastOrder ? $lastOrder->city : '') }}">
                                                <label for="city">City/Town <span class="required">*</span></label>
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        <!-- Postal Code -->
                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="post_code">Postal Code</label>
                                                <input type="text"
                                                    class="form-control @error('post_code') is-invalid @enderror"
                                                    id="post_code" name="post_code" placeholder="Postal Code"
                                                    value="{{ old('post_code', $lastOrder ? $lastOrder->post_code : '') }}">
                                               
                                                @error('post_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Additional Notes -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea class="form-control" id="notes" name="notes" placeholder="Order Notes (Optional)"
                                                    style="height: 100px">{{ old('notes') }}</textarea>
                                                <label for="notes">Order Notes (Optional)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary Column -->
                        <div class="col-lg-4 col-12">
                            <div class="order-summary-card">
                                <div class="card-header">
                                    <h3><i class="fas fa-shopping-cart me-2"></i> Your Order</h3>
                                </div>

                                <div class="card-body">
                                    <!-- Cart Items Preview -->
                                    @if (Helper::cartCount() > 0)
                                        <div class="cart-items-preview mb-3">
                                            <h5>Order Items</h5>
                                            @php $cart_items = Helper::getAllProductFromCart(); @endphp
                                            @foreach ($cart_items as $item)
                                                <div class="cart-item-preview">
                                                    <div class="item-info">
                                                        <span class="item-name">{{ $item->product->title }}</span>
                                                        <span class="item-quantity">x{{ $item->quantity }}</span>
                                                    </div>
                                                    <span class="item-price">Rs. {{ number_format($item->amount, 2) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Order Totals -->
                                    <div class="order-totals">
                                        <div class="total-row">
                                            <span>Subtotal</span>
                                            <span class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">
                                                Rs. {{ number_format(Helper::totalCartPrice(), 2) }}
                                            </span>
                                        </div>

                                        <div class="total-row shipping-row">
                                            <span>Shipping</span>
                                            <span class="shipping-cost">
                                                @if (count(Helper::shipping()) > 0 && Helper::cartCount() > 0)
                                                    <select name="shipping" class="shipping-select" id="shipping_select">
                                                        <option value="">Select shipping method</option>
                                                        @foreach (Helper::shipping() as $shipping)
                                                            <option value="{{ $shipping->id }}"
                                                                data-price="{{ $shipping->price }}"
                                                                {{ old('shipping') == $shipping->id ? 'selected' : '' }}>
                                                                {{ $shipping->type }}:
                                                                Rs. {{ number_format($shipping->price, 2) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <span class="free-shipping">Free Shipping</span>
                                                @endif
                                            </span>
                                        </div>

                                        @if (session('coupon'))
                                            <div class="total-row coupon-row">
                                                <span>Discount (Coupon)</span>
                                                <span class="coupon_price" data-price="{{ session('coupon')['value'] }}">
                                                    -Rs. {{ number_format(session('coupon')['value'], 2) }}
                                                </span>
                                            </div>
                                        @endif

                                        <div class="total-row grand-total">
                                            <span>Total</span>
                                            @php
                                                $total_amount = Helper::totalCartPrice();
                                                if (session('coupon')) {
                                                    $total_amount = $total_amount - session('coupon')['value'];
                                                }
                                            @endphp
                                            <span class="order_total_price" id="order_total_price">
                                                Rs. {{ number_format($total_amount, 2) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Payment Methods -->
                                    <div class="payment-methods mt-4">
                                        <h5>Payment Method</h5>
                                        <div class="payment-options">
                                            <div class="payment-option">
                                                <input type="radio" name="payment_method" id="payment_cod"
                                                    value="cod"
                                                    {{ session('payment_method') == 'cod' ? 'checked' : '' }}
                                                    {{ old('payment_method') == 'cod' ? 'checked' : '' }} checked>
                                                <label for="payment_cod">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                    Cash on Delivery
                                                </label>
                                            </div>

                                            {{-- <div class="payment-option">
                                            <input type="radio" name="payment_method" id="payment_paypal"
                                                value="paypal"
                                                {{ session('payment_method') == 'paypal' ? 'checked' : '' }}
                                                {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                                            <label for="payment_paypal">
                                                <i class="fab fa-paypal"></i>
                                                PayPal
                                            </label>
                                        </div> --}}
                                        </div>
                                    </div>

                                    <!-- Payment Methods Image -->
                                    <div class="payment-methods-img mt-3">
                                        <label for="">Coming Soon..</label>
                                        <img src="{{ asset('backend/img/payment-method.png') }}" alt="Payment Methods"
                                            class="img-fluid">
                                    </div>

                                    <!-- Place Order Button -->
                                    <div class="place-order-btn mt-4">
                                        <button type="submit" class="btn btn-primary btn-place-order">
                                            <i class="fas fa-check-circle me-2"></i> Place Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </section>

   
    {{-- <!-- Newsletter Section -->
    <section class="modern-newsletter section">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="newsletter-content">
                            <h4><i class="fas fa-envelope"></i> Subscribe to our Newsletter</h4>
                            <p>Get 10% off your first purchase and stay updated with our latest offers!</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form action="mail/mail.php" method="get" target="_blank" class="newsletter-form">
                            <div class="input-group">
                                <input type="email" name="EMAIL" class="form-control"
                                    placeholder="Your email address" required>
                                <button type="submit" class="btn btn-subscribe">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection

@push('styles')
    <style>
        /* Modern Checkout Styles */
        .modern-breadcrumbs {
            background: #f8f9fa;
            padding: 15px 0;
            margin-bottom: 30px;
        }

        .modern-breadcrumb {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
            background: transparent;
        }

        .modern-breadcrumb .breadcrumb-item {
            color: #6c757d;
        }

        .modern-breadcrumb .breadcrumb-item a {
            color: #F7941D;
            text-decoration: none;
        }

        .modern-breadcrumb .breadcrumb-item.active {
            color: #333;
        }

        .modern-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            padding: 0 8px;
            color: #6c757d;
        }

        /* Billing Details Card */
        .billing-details-card,
        .order-summary-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-header {
            background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
            color: white;
            padding: 20px 25px;
            border-bottom: none;
        }

        .card-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .card-header p {
            margin: 5px 0 0;
            font-size: 13px;
            opacity: 0.9;
        }

        .card-body {
            padding: 25px;
        }

        /* Form Styles */
        .form-floating {
            position: relative;
        }

        .form-floating>.form-control,
        .form-floating>.form-select {
            height: 58px;
            padding: 1rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-floating>.form-control:focus,
        .form-floating>.form-select:focus {
            border-color: #F7941D;
            box-shadow: 0 0 0 0.2rem rgba(247, 148, 29, 0.1);
        }

        .form-floating>label {
            padding: 1rem 0.75rem;
            color: #6c757d;
        }

        .required {
            color: #dc3545;
        }

        /* Order Totals */
        .order-totals {
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .total-row:last-child {
            border-bottom: none;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #F7941D;
            padding-top: 15px;
            margin-top: 5px;
            border-top: 2px solid #F7941D;
        }

        .shipping-select {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        .free-shipping {
            color: #28a745;
            font-weight: 500;
        }

        /* Cart Items Preview */
        .cart-items-preview {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .cart-item-preview {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .item-info {
            display: flex;
            gap: 10px;
        }

        .item-name {
            font-size: 14px;
            font-weight: 500;
        }

        .item-quantity {
            font-size: 12px;
            color: #6c757d;
        }

        .item-price {
            font-weight: 500;
            color: #F7941D;
        }

        /* Payment Methods */
        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .payment-option {
            display: flex;
            align-items: center;
        }

        .payment-option input[type="radio"] {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: #F7941D;
        }

        .payment-option label {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-weight: 500;
        }

        .payment-option label i {
            font-size: 18px;
            color: #F7941D;
        }

        .payment-methods-img {
            text-align: center;
            padding: 15px 0;
            border-top: 1px solid #e5e7eb;
        }

        .payment-methods-img img {
            max-height: 40px;
        }

        /* Place Order Button */
        .btn-place-order {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
            border: none;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-place-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 148, 29, 0.3);
        }

        /* Services Section */
        .modern-services {
            background: #f8f9fa;
            padding: 60px 0;
            margin-top: 50px;
        }

        .service-card {
            text-align: center;
            padding: 25px;
            background: white;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .service-card i {
            font-size: 40px;
            color: #F7941D;
            margin-bottom: 15px;
        }

        .service-card h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .service-card p {
            font-size: 14px;
            color: #6c757d;
            margin: 0;
        }

        /* Newsletter Section */
        .modern-newsletter {
            padding: 60px 0;
            background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
        }

        .newsletter-wrapper {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px;
        }

        .newsletter-content h4 {
            color: white;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .newsletter-content p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        .newsletter-form .input-group {
            background: white;
            border-radius: 50px;
            overflow: hidden;
        }

        .newsletter-form .form-control {
            border: none;
            padding: 12px 20px;
            font-size: 14px;
        }

        .newsletter-form .form-control:focus {
            box-shadow: none;
        }

        .btn-subscribe {
            background: #333;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 0;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-subscribe:hover {
            background: #F7941D;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .card-header,
            .card-body {
                padding: 20px;
            }

            .newsletter-wrapper {
                padding: 25px;
                text-align: center;
            }

            .newsletter-form {
                margin-top: 20px;
            }

            .service-card {
                padding: 20px;
            }
        }

        /* Loading State */
        .btn-place-order.loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-place-order.loading::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();

        // Shipping cost calculation
        $(document).ready(function() {
            $('.shipping-select').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                $('#order_total_price').text('$' + (subtotal + cost - coupon).toFixed(2));
            });

            // Auto-select COD if coming from product page
            @if (session('payment_method') == 'cod')
                $('#payment_cod').prop('checked', true);
            @endif

            // Form validation
            $('.checkout-form').on('submit', function(e) {
                let isValid = true;

                // Check required fields
                $(this).find('input[required], select[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Check payment method selected
                if (!$('input[name="payment_method"]:checked').val()) {
                    $('.payment-options').addClass('border-danger');
                    isValid = false;
                } else {
                    $('.payment-options').removeClass('border-danger');
                }

                if (!isValid) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $('.is-invalid:first').offset().top - 100
                    }, 500);
                    return false;
                }

                // Show loading state
                $('.btn-place-order').addClass('loading');
                return true;
            });
        });

        function showMe(box) {
            var checkbox = document.getElementById('shipping').style.display;
            var vis = 'none';
            if (checkbox == "none") {
                vis = 'block';
            }
            if (checkbox == "block") {
                vis = "none";
            }
            document.getElementById(box).style.display = vis;
        }
    </script>
@endpush
