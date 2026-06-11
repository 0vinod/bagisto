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
                                        <div class="form-group"> <label for="first_name">First Name <span
                                                    class="required">*</span></label>
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
                                        <div class="form-group"><label for="email">Email Address <span
                                                    class="required">*</span></label>
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
                                        <div class="form-group"> <label for="phone">Phone Number <span
                                                    class="required">*</span></label>
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
                                        <div class="form-group"> <label for="country">Country <span
                                                    class="required">*</span></label>
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
                                        <div class="form-group"> <label>State <span class="required">*</span></label>
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
                                        <div class="form-group"> <label for="address1">Address Line 1 <span
                                                    class="required">*</span></label>
                                            <input type="text"
                                                class="form-control @error('address1') is-invalid @enderror" id="address1"
                                                name="address1" placeholder="Address Line 1"
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
                                            <input type="text"
                                                class="form-control @error('address2') is-invalid @enderror" id="address2"
                                                name="address2" placeholder="Address Line 2"
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
                            @php
                                $afterDiscount = $product->price - ($product->price * $product->discount) / 100;
                                $savingAmount = ($product->price * $product->discount) / 100;
                            @endphp
                            <div class="card-body">
                                <!-- Cart Items Preview -->
                                {{-- @if (Helper::cartCount() > 0) --}}

                                <div class="cart-items-preview mb-3">
                                    <h5>Order Items</h5>
                                    {{-- @php $cart_items = Helper::getAllProductFromCart(); @endphp --}}
                                    {{-- @foreach ($cart_items as $item) --}}
                                    <div class="cart-item-preview">
                                        <div class="item-info">
                                            <span class="item-name">{{ $product->title }}</span>
                                            {{-- <span class="item-quantity">x{{ $product->quantity }}</span> --}}
                                        </div>
                                        <span class="product-price">Rs. {{ number_format($afterDiscount) }}</span>
                                    </div>
                                    {{-- @endforeach --}}
                                </div>
                                {{-- @endif --}}

                                <!-- Order Totals -->
                                <div class="order-totals">
                                    <div class="total-row">
                                        <span>Saving on Amount</span>
                                        <span class="order_subtotal" data-price="{{ number_format($savingAmount) }}">
                                            Rs. {{ number_format($savingAmount) }}
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
                                                            Rs. {{ number_format($shipping->price) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <span class="free-shipping">Free Shipping</span>
                                            @endif
                                        </span>
                                    </div>


                                    <div class="total-row coupon-row">
                                        <div>
                                            <input type="text" class="form-control" name="coupon_code"
                                                id="coupon_code" placeholder="coupon">
                                            @error('coupon_code')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>

                                        <span class="coupon_price" data-price="0">
                                            - Rs. 0
                                        </span>

                                        <button type="button" id="applyCouponBtn" class="btn btn-sm btn-primary">
                                            Apply
                                        </button>
                                    </div>


                                    <div class="total-row grand-total">
                                        <span>Total</span>
                                        {{-- @php
                                                $total_amount = Helper::totalCartPrice();
                                                if (session('coupon')) {
                                                    $total_amount = $total_amount - session('coupon')['value'];
                                                }
                                            @endphp --}}
                                        Rs.<span class="order_total_price" id="order_total_price">
                                            {{ number_format($afterDiscount) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Payment Methods -->
                                <div class="payment-methods mt-4">
                                    <h5>Payment Method</h5>
                                    <div class="payment-options">
                                        <div class="payment-option">
                                            <input type="radio" name="payment_method" id="payment_cod" value="cod"
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


@endsection

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

        $('#applyCouponBtn').click(function() {

            let couponCode = $('#coupon_code').val();
            let amount = parseFloat($('#order_total_price').data('base-amount'));

            $.ajax({
                url: "{{ route('apply.coupon') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    coupon_code: couponCode,
                    amount: "{{ $afterDiscount }}"
                },
                success: function(response) {

                    if (response.status) {

                        $('.coupon_price')
                            .text('- Rs. ' + response.coupon_discount)
                            .attr('data-price', response.coupon_discount);

                        $('#order_total_price')
                            .text('Rs. ' + response.final_amount);

                        toastr.success(response.message);

                    } else {

                        $('.coupon_price').text('- Rs. 0').attr('data-price', 0);
                        $('#coupon_code').val('')
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Something went wrong');
                }
            });

        });
    </script>
@endpush
