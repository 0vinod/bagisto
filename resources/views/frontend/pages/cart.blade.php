@extends('frontend.layouts.master')
@section('title', 'Cart Page')
@section('main-content')
    <!-- Modern Breadcrumbs -->
    <div class="modern-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="modern-breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shopping Cart</li>
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

    <!-- Shopping Cart Section -->
    <div class="modern-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (Helper::getAllProductFromCart() && count(Helper::getAllProductFromCart()) > 0)
                        <div class="cart-wrapper">
                            <form action="{{ route('cart.update') }}" method="POST" id="cart-update-form">
                                @csrf
                                <div class="cart-table">
                                    <div class="cart-header">
                                        <div class="cart-col product-col">PRODUCT</div>
                                        <div class="cart-col name-col">NAME</div>
                                        <div class="cart-col price-col">UNIT PRICE</div>
                                        <div class="cart-col qty-col">QUANTITY</div>
                                        <div class="cart-col total-col">TOTAL</div>
                                        <div class="cart-col action-col"><i class="ti-trash remove-icon"></i></div>
                                    </div>

                                    <div class="cart-body" id="cart_item_list">
                                        @foreach (Helper::getAllProductFromCart() as $key => $cart)
                                            @php
                                                $photo = explode(',', $cart->product['photo']);
                                            @endphp
                                            <div class="cart-item" data-cart-id="{{ $cart->id }}"
                                                data-product-id="{{ $cart->product_id }}">
                                                <div class="cart-col product-col">
                                                    <div class="product-image">
                                                        <img src="{{ $photo[0] }}" alt="{{ $cart->product['title'] }}">
                                                    </div>
                                                </div>

                                                <div class="cart-col name-col">
                                                    <div class="product-info">
                                                        <h5 class="product-name">
                                                            <a href="{{ route('product-detail', $cart->product['slug']) }}"
                                                                target="_blank">
                                                                {{ $cart->product['title'] }}
                                                            </a>
                                                        </h5>

                                                    </div>
                                                </div>

                                                <div class="cart-col price-col">
                                                    <div class="unit-price">
                                                        Rs. {{ number_format($cart['price'], 2) }}
                                                    </div>
                                                </div>

                                                <div class="cart-col qty-col">
                                                    <div class="quantity-selector">
                                                        <button type="button" class="qty-btn qty-decrease"
                                                            data-product-id="{{ $cart->product_id }}">

                                                        </button>
                                                        <input type="text" name="quant[{{ $key }}]"
                                                            class="quantity-input cart-qty" data-min="1"
                                                            data-max="{{ $cart->product['stock'] }}"
                                                            value="{{ $cart->quantity }}"
                                                            data-product-id="{{ $key }}"
                                                            data-price="{{ $cart['price'] }}">
                                                        <input type="hidden" name="qty_id[]" value="{{ $cart->id }}">
                                                        <button type="button" class="qty-btn qty-increase"
                                                            data-product-id="{{ $cart->product_id }}">

                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="cart-col total-col">
                                                    <div class="item-total" data-key="{{ $key }}">
                                                        Rs. {{ number_format($cart['amount'], 2) }}
                                                    </div>
                                                </div>

                                                <div class="cart-col action-col">
                                                    <a href="{{ route('cart-delete', $cart->id) }}" class="remove-item"
                                                        title="Remove Item">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="empty-cart">
                            <div class="empty-cart-icon">
                                <i class="ti-shopping-cart"></i>
                            </div>
                            <h3>Your Cart is Empty</h3>
                            <p>Looks like you haven't added any items to your cart yet.</p>
                            <a href="{{ route('product-grids') }}" class="btn btn-continue-shopping">
                                <i class="ti-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            @if (Helper::getAllProductFromCart() && count(Helper::getAllProductFromCart()) > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <!-- Total Amount -->
                        <div class="total-amount-card">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-12">
                                    <div class="coupon-section">
                                        <h5><i class="ti-ticket"></i> Have a Coupon?</h5>
                                        <form action="{{ route('coupon-store') }}" method="POST" class="coupon-form">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" name="code" class="form-control"
                                                    placeholder="Enter coupon code" value="{{ old('code') }}">
                                                <button type="submit" class="btn btn-apply-coupon">Apply Coupon</button>
                                            </div>
                                            @if (session()->has('coupon'))
                                                <div class="coupon-applied mt-2">
                                                    <span class="badge badge-success">
                                                        <i class="ti-check"></i> Coupon Applied:
                                                        {{ session('coupon')['code'] }}
                                                    </span>
                                                    <a href="{{ route('coupon-remove') }}" class="remove-coupon">
                                                        <i class="ti-close"></i> Remove
                                                    </a>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="order-summary">
                                        <h5>Order Summary</h5>
                                        <div class="summary-details">
                                            <div class="summary-row subtotal">
                                                <span>Subtotal</span>
                                                <span class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">
                                                    Rs. {{ number_format(Helper::totalCartPrice(), 2) }}
                                                </span>
                                            </div>

                                            @if (session()->has('coupon'))
                                                <div class="summary-row discount">
                                                    <span>Discount ({{ session('coupon')['code'] }})</span>
                                                    <span class="coupon_price"
                                                        data-price="{{ Session::get('coupon')['value'] }}">
                                                        -Rs. {{ number_format(Session::get('coupon')['value'], 2) }}
                                                    </span>
                                                </div>
                                            @endif

                                            @php
                                                $total_amount = Helper::totalCartPrice();
                                                if (session()->has('coupon')) {
                                                    $total_amount = $total_amount - Session::get('coupon')['value'];
                                                }           
                                            @endphp          

                                            <div class="summary-row total">
                                                <span>Total</span>
                                                <span class="order_total_price" id="order_total_price">
                                                    Rs. {{ number_format($total_amount, 2) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="cart-buttons">
                                            <a href="{{ route('checkout') }}" class="btn btn-checkout">
                                                <i class="ti-shopping-cart"></i> Proceed to Checkout
                                            </a>
                                            <a href="{{ route('product-grids') }}" class="btn btn-continue">
                                                <i class="ti-arrow-left"></i> Continue Shopping
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Start Shop Services Area -->
    <section class="modern-services section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="service-card">
                        <i class="ti-rocket"></i>
                        <h4>Free Shipping</h4>
                        <p>Orders over $100</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="service-card">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="service-card">
                        <i class="ti-lock"></i>
                        <h4>Secure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="service-card">
                        <i class="ti-tag"></i>
                        <h4>Best Price</h4>
                        <p>Guaranteed price</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services -->
@endsection

@push('styles')

    <style>
        /* Modern Cart Styles */
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

        /* Cart Wrapper */
        .cart-wrapper {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        /* Cart Table */
        .cart-table {
            width: 100%;
            min-width: 768px;
            /* Prevents breaking on medium screens */
        }

        @media (max-width: 991px) {
            .cart-table {
                min-width: 700px;
            }
        }

        .cart-header {
            display: grid;
            grid-template-columns: 120px minmax(200px, 2fr) 120px 140px 120px 70px;
            background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            font-size: 14px;
            gap: 15px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 120px minmax(200px, 2fr) 120px 140px 120px 70px;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            align-items: center;
            transition: all 0.3s ease;
            gap: 15px;
        }

        .cart-item:hover {
            background: #fef9f0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        /* Product Image */
        .product-image {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Product Info */
        .product-info {
            padding-right: 10px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }

        .product-name a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-block;
            word-break: break-word;
        }

        .product-name a:hover {
            color: #F7941D;
        }

        .product-summary {
            font-size: 13px;
            color: #6c757d;
            margin: 0;
            line-height: 1.4;
        }

        /* Unit Price */
        .unit-price {
            font-size: 16px;
            font-weight: 500;
            color: #F7941D;
        }

        /* Quantity Selector */
        .quantity-selector {
            display: inline-flex;
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        .qty-btn {
            background: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        .qty-btn:hover {
            background: #F7941D;
            color: white;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border: none;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            padding: 8px 0;
            font-size: 14px;
        }

        .quantity-input:focus {
            outline: none;
        }

        /* Item Total */
        .item-total {
            font-size: 16px;
            font-weight: 600;
            color: #F7941D;
        }

        /* Remove Item */
        .remove-item {
            color: #dc3545;
            font-size: 18px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .remove-item:hover {
            color: #c82333;
            transform: scale(1.1);
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .empty-cart-icon {
            font-size: 80px;
            color: #F7941D;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .empty-cart p {
            color: #6c757d;
            margin-bottom: 25px;
        }

        .btn-continue-shopping {
            background: #F7941D;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-continue-shopping:hover {
            background: #F76E1C;
            transform: translateY(-2px);
            color: white;
        }

        /* Total Amount Card */
        .total-amount-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-top: 30px;
        }

        /* Coupon Section */
        .coupon-section h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .coupon-section h5 i {
            color: #F7941D;
            margin-right: 8px;
        }

        .coupon-form .input-group {
            display: flex;
            gap: 10px;
        }

        .coupon-form .form-control {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .coupon-form .form-control:focus {
            border-color: #F7941D;
            outline: none;
            box-shadow: 0 0 0 3px rgba(247, 148, 29, 0.1);
        }

        .btn-apply-coupon {
            background: #F7941D;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-apply-coupon:hover {
            background: #F76E1C;
            transform: translateY(-2px);
        }

        .coupon-applied {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .remove-coupon {
            color: #dc3545;
            font-size: 12px;
            text-decoration: none;
        }

        .remove-coupon:hover {
            text-decoration: underline;
        }

        /* Order Summary */
        .order-summary h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #F7941D;
            display: inline-block;
        }

        .summary-details {
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            gap: 15px;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row.subtotal span:first-child,
        .summary-row.discount span:first-child {
            color: #6c757d;
        }

        .summary-row.total {
            font-size: 18px;
            font-weight: 700;
            color: #F7941D;
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid #F7941D;
        }

        /* Cart Buttons */
        .cart-buttons {
            display: flex;
            gap: 10px;
            flex-direction: column;
        }

        .btn-checkout {
            background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 148, 29, 0.3);
            color: white;
        }

        .btn-continue {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-continue:hover {
            background: #e9ecef;
            transform: translateY(-2px);
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

        /* ========== IMPROVED RESPONSIVE DESIGN ========== */

        /* Tablet Landscape (992px - 1199px) */
        @media (max-width: 1199px) and (min-width: 992px) {

            .cart-header,
            .cart-item {
                grid-template-columns: 100px minmax(180px, 1.5fr) 110px 130px 110px 60px;
                gap: 12px;
            }

            .cart-item {
                padding: 15px;
            }

            .product-image {
                width: 80px;
                height: 80px;
            }

            .product-name {
                font-size: 14px;
            }

            .quantity-input {
                width: 50px;
            }
        }

        /* Tablet Portrait (768px - 991px) */
        @media (max-width: 991px) {
            .cart-table {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .cart-header,
            .cart-item {
                min-width: 700px;
                gap: 12px;
            }

            .cart-header {
                grid-template-columns: 100px minmax(180px, 2fr) 110px 130px 110px 60px;
            }

            .cart-item {
                grid-template-columns: 100px minmax(180px, 2fr) 110px 130px 110px 60px;
            }

            .product-image {
                width: 80px;
                height: 80px;
            }

            .product-summary {
                display: none;
            }

            .total-amount-card {
                padding: 20px;
            }

            .service-card {
                padding: 20px;
            }

            .service-card i {
                font-size: 32px;
            }

            .service-card h4 {
                font-size: 16px;
            }
        }

        /* Mobile Landscape (576px - 767px) */
        @media (max-width: 767px) {
            .modern-breadcrumbs {
                padding: 10px 0;
                margin-bottom: 20px;
            }

            .cart-wrapper {
                border-radius: 8px;
            }

            .cart-header {
                display: none;
            }

            .cart-table {
                min-width: auto;
                overflow: visible;
            }

            .cart-item {
                display: block;
                padding: 20px;
                position: relative;
                min-width: auto;
            }

            .cart-col {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                margin-bottom: 8px;
            }

            .cart-col::before {
                content: attr(data-title);
                font-weight: 600;
                color: #F7941D;
                min-width: 100px;
                font-size: 14px;
            }

            /* Set data-title attributes for each column */
            .product-col::before {
                content: "PRODUCT";
            }

            .name-col::before {
                content: "NAME";
            }

            .price-col::before {
                content: "UNIT PRICE";
            }

            .qty-col::before {
                content: "QUANTITY";
            }

            .total-col::before {
                content: "TOTAL";
            }

            .action-col::before {
                content: "ACTION";
            }

            .product-col {
                justify-content: center;
                flex-direction: column;
                text-align: center;
            }

            .product-col::before {
                display: none;
            }

            .action-col {
                position: relative;
                justify-content: flex-end;
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1px solid #e5e7eb;
            }

            .product-image {
                width: 120px;
                height: 120px;
                margin-bottom: 10px;
            }

            .product-info {
                text-align: center;
                padding-right: 0;
            }

            .product-name {
                font-size: 16px;
            }

            .unit-price {
                font-size: 18px;
                font-weight: 600;
            }

            .quantity-selector {
                margin: 0;
            }

            .item-total {
                font-size: 18px;
                font-weight: 700;
            }

            .remove-item {
                font-size: 20px;
                padding: 5px 10px;
            }

            .total-amount-card {
                padding: 20px;
            }

            .coupon-section {
                margin-bottom: 25px;
            }

            .coupon-form .input-group {
                flex-direction: column;
            }

            .btn-apply-coupon {
                width: 100%;
                white-space: normal;
            }

            .order-summary {
                margin-top: 20px;
            }

            .cart-buttons {
                flex-direction: column-reverse;
            }

            .modern-services {
                padding: 40px 0;
                margin-top: 30px;
            }

            .service-card {
                margin-bottom: 15px;
            }
        }

        /* Mobile Portrait (up to 575px) */
        @media (max-width: 575px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .cart-item {
                padding: 15px;
            }

            .product-image {
                width: 100px;
                height: 100px;
            }

            .product-name {
                font-size: 14px;
            }

            .cart-col {
                flex-wrap: wrap;
            }

            .cart-col::before {
                min-width: 90px;
                font-size: 13px;
            }

            .unit-price,
            .item-total {
                font-size: 16px;
            }

            .quantity-input {
                width: 50px;
            }

            .qty-btn {
                padding: 6px 10px;
            }

            .empty-cart {
                padding: 40px 15px;
            }

            .empty-cart-icon {
                font-size: 60px;
            }

            .empty-cart h3 {
                font-size: 20px;
            }

            .btn-continue-shopping {
                padding: 10px 20px;
                font-size: 14px;
            }

            .summary-row {
                font-size: 14px;
            }

            .summary-row.total {
                font-size: 16px;
            }

            .service-card {
                padding: 15px;
            }

            .service-card i {
                font-size: 28px;
            }

            .service-card h4 {
                font-size: 14px;
            }

            .service-card p {
                font-size: 12px;
            }
        }

        /* Extra Small Devices (up to 360px) */
        @media (max-width: 360px) {
            .cart-col::before {
                min-width: 80px;
                font-size: 12px;
            }

            .product-image {
                width: 80px;
                height: 80px;
            }

            .product-name {
                font-size: 13px;
            }

            .quantity-input {
                width: 45px;
            }

            .qty-btn {
                padding: 5px 8px;
            }

            .btn-apply-coupon,
            .btn-checkout,
            .btn-continue {
                padding: 10px;
                font-size: 13px;
            }
        }

        /* Loading State */
        .btn-update-cart.loading,
        .btn-checkout.loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-update-cart.loading::after,
        .btn-checkout.loading::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            right: 15px;
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

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cart-wrapper,
        .total-amount-card {
            animation: fadeIn 0.5s ease-out;
        }

        /* Cart count badge update animation */
        .total-count.update {
            animation: pulse 0.5s ease-in-out;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Set data-title attributes for responsive design
            function setDataTitles() {
                if ($(window).width() <= 767) {
                    $('.cart-item .product-col').attr('data-title', 'PRODUCT');
                    $('.cart-item .name-col').attr('data-title', 'NAME');
                    $('.cart-item .price-col').attr('data-title', 'UNIT PRICE');
                    $('.cart-item .qty-col').attr('data-title', 'QUANTITY');
                    $('.cart-item .total-col').attr('data-title', 'TOTAL');
                    $('.cart-item .action-col').attr('data-title', 'ACTION');
                } else {
                    $('.cart-col').removeAttr('data-title');
                }
            }

            // Call on load and resize
            setDataTitles();
            $(window).resize(function() {
                setDataTitles();
            });


            $('.quantity-input').on('change', function() {
                let key = $(this).data('key');
                updateItemTotal(key, $(this));
                $('#cart-update-form').submit();
            });

            function updateItemTotal(key, input) {
                let quantity = parseInt(input.val());
                let price = parseFloat(input.data('price'));
                let total = quantity * price;
                $(`.item-total[data-key="${key}"]`).text('$' + total.toFixed(2));
                updateCartTotals();
            }

            function updateCartTotals() {
                let subtotal = 0;
                $('.item-total').each(function() {
                    let total = parseFloat($(this).text().replace('$', ''));
                    subtotal += total;
                });

                $('.order_subtotal').data('price', subtotal);
                $('.order_subtotal').text('$' + subtotal.toFixed(2));

                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                let totalAmount = subtotal - coupon;
                $('#order_total_price').text('$' + totalAmount.toFixed(2));
            }

            $('#cart-update-form').on('submit', function() {
                $('.btn-update-cart').addClass('loading');
                return true;
            });

            $(document).on('click', '.remove-item', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let cartItem = $(this).closest('.cart-item');

                swal({
                    title: 'Are you sure?',
                    text: 'This item will be removed from your cart!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        cartItem.css({
                            'transition': 'all 0.3s ease',
                            'opacity': '0',
                            'transform': 'translateX(20px)'
                        });

                        $.ajax({
                            url: url,
                            type: "GET",
                            success: function(response) {
                                if (response.status == 'success') {
                                    cartItem.remove();
                                    updateCartTotals();
                                    $(".total-count").text(response.cartCount);
                                    $(".total-count").addClass('update');
                                    setTimeout(function() {
                                        $(".total-count").removeClass('update');
                                    }, 500);

                                    if ($('.cart-item').length === 0) {
                                        location.reload();
                                    }

                                    swal("Removed!", response.message, "success");
                                } else {
                                    swal("Error!", response.message, "error");
                                    cartItem.css({
                                        'opacity': '1',
                                        'transform': 'translateX(0)'
                                    });
                                }
                            },
                            error: function() {
                                swal("Error!", "Failed to remove item", "error");
                                cartItem.css({
                                    'opacity': '1',
                                    'transform': 'translateX(0)'
                                });
                            }
                        });
                    }
                });
            });

            $('.coupon-form').on('submit', function(e) {
                let code = $(this).find('input[name="code"]').val();
                if (!code) {
                    e.preventDefault();
                    swal('Error', 'Please enter a coupon code', 'error');
                }
            });
        });
    </script>
@endpush
