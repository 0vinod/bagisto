<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 text-center">
                    <ul class="list-main justify-content-center">
                        <li>
                            <strong>🔥 Upto 40% Off Deals Today. COD available | Free Shipping*</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="nav-main">
                <!-- Logo -->
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('frontend/img/logo.png') }}" alt="{{ config('app.name') }}">
                    </a>
                </div>

                <!-- Menu -->
                {{-- <nav class="navbar navbar-expand-lg">
                    <div class="navbar-collapse" id="mainNav">
                        <ul class="nav main-menu menu navbar-nav">
                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="{{ request()->routeIs('about-us') ? 'active' : '' }}">
                                <a href="{{ route('about-us') }}">About Us</a>
                            </li>
                            <li class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                                <a href="{{ route('product-grids') }}">Products</a>
                            </li>
                            @if (isset($categories) && count($categories) > 0)
                                @foreach ($categories->take(5) as $category)
                                    <li>
                                        <a href="{{ route('products.category', $category->slug) }}">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            <li class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">
                                <a href="{{ route('blog') }}">Blog</a>
                            </li>
                            <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                                <a href="{{ route('contact') }}">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </nav> --}}
                <nav class="navbar navbar-expand-lg">

                    <!-- Mobile Toggle -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav">
                        <i class="ti-menu"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNav">
                        <ul class="nav main-menu menu navbar-nav">
                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}">Home</a>
                            </li>

                            <li class="{{ request()->routeIs('about-us') ? 'active' : '' }}">
                                <a href="{{ route('about-us') }}">About Us</a>
                            </li>

                            <li class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                                <a href="{{ route('product-grids') }}">Products</a>
                            </li>

                            @if (isset($categories) && count($categories) > 0)
                                @foreach ($categories->take(5) as $category)
                                    <li>
                                        <a href="{{ route('products.category', $category->slug) }}">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif

                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>

                </nav>
                <!-- Right Icons -->
                <div class="header-right">
                    <!-- Search -->
                    <div class="nav-search">
                        <a href="javascript:void(0)" id="searchToggle">
                            <i class="ti-search"></i>
                        </a>
                        <div class="nav-search-form" id="searchForm">
                            <form action="{{ route('product.search') }}" method="GET">
                                @csrf
                                <select name="category">
                                    <option value="">All Category</option>
                                    @if (isset($categories))
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input name="search" placeholder="Search Products..." type="search"
                                    value="{{ request('search') }}">
                                <button type="submit">
                                    <i class="ti-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Cart -->
                    <?php
                    $cartCount = Helper::cartCount();
                    $cartItems = Helper::getAllProductFromCart();
                    $cartTotal = Helper::totalCartPrice();
                    ?>
                    <div class="sinlge-bar shopping">
                        <a href="{{ route('cart') }}" class="single-icon">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="total-count">{{ isset($cartCount) ? $cartCount : 0 }}</span>
                        </a>
                        @auth
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span>
                                        <i class="fas fa-shopping-bag"></i>
                                        {{ isset($cartItems) ? count($cartItems) : 0 }} Item(s)
                                    </span>
                                    <a href="{{ route('cart') }}" class="view-cart-btn">
                                        View Cart <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>

                                <ul class="shopping-list">
                                    @if (isset($cartItems) && count($cartItems) > 0)
                                        @foreach ($cartItems as $item)
                                            <li class="cart-item">
                                                <a href="{{ route('cart-delete', $item->id) }}" class="remove-item"
                                                    title="Remove Item">
                                                    <i class="fa fa-times-circle"></i>
                                                </a>
                                                <a class="cart-img"
                                                    href="{{ route('product-detail', $item->product->slug) }}">
                                                    <img src="{{ isset($item->product->photo) ? explode(',', $item->product->photo)[0] : asset('frontend/img/default.jpg') }}"
                                                        alt="{{ $item->product->title }}">
                                                </a>
                                                <div class="cart-item-info">
                                                    <h4>
                                                        <a href="{{ route('product-detail', $item->product->slug) }}">
                                                            {{ Str::limit($item->product->title, 30) }}
                                                        </a>
                                                    </h4>
                                                    <p class="quantity">
                                                        <span class="qty-label">Qty:</span>
                                                        <span class="qty-value">{{ $item->quantity }}</span>
                                                        <span class="price-separator">x</span>
                                                        <span class="amount">${{ number_format($item->price, 2) }}</span>
                                                    </p>
                                                    <p class="item-total">
                                                        <span class="total-label">Total:</span>
                                                        <span
                                                            class="total-value">${{ number_format($item->amount, 2) }}</span>
                                                    </p>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="empty-cart">
                                            <i class="fas fa-shopping-bag"></i>
                                            <p>Your cart is empty</p>
                                            <a href="{{ route('product-grids') }}" class="btn-shop-now">Shop Now</a>
                                        </li>
                                    @endif
                                </ul>

                                @if (isset($cartItems) && count($cartItems) > 0)
                                    <div class="cart-footer">
                                        <div class="cart-subtotal">
                                            <span class="subtotal-label">Subtotal</span>
                                            <span class="subtotal-amount">
                                                ${{ isset($cartTotal) ? number_format($cartTotal, 2) : '0.00' }}
                                            </span>
                                        </div>

                                        @if (session()->has('coupon'))
                                            <div class="cart-discount">
                                                <span class="discount-label">
                                                    <i class="fas fa-ticket-alt"></i> Discount
                                                </span>
                                                <span class="discount-amount">
                                                    -${{ number_format(Session::get('coupon')['value'], 2) }}
                                                </span>
                                            </div>
                                            @php
                                                $finalTotal = $cartTotal - Session::get('coupon')['value'];
                                            @endphp
                                            <div class="cart-total">
                                                <span class="total-label">Total</span>
                                                <span class="total-amount">${{ number_format($finalTotal, 2) }}</span>
                                            </div>
                                        @else
                                            <div class="cart-total">
                                                <span class="total-label">Total</span>
                                                <span
                                                    class="total-amount">${{ isset($cartTotal) ? number_format($cartTotal, 2) : '0.00' }}</span>
                                            </div>
                                        @endif

                                        <div class="cart-actions">
                                            <a href="{{ route('checkout') }}" class="btn-checkout">
                                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                                            </a>
                                            <a href="{{ route('cart') }}" class="btn-view-cart">
                                                <i class="fas fa-shopping-cart"></i> View Cart
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endauth
                    </div>

                    <!-- User Menu -->
                    <div class="header-user">
                        @auth
                            @if (Auth::user()->role == 'admin')
                                {{-- <a href="{{ route('admin') }}" class="user-btn">Dashboard</a> --}}
                            @else
                                {{-- <a href="{{ route('user') }}" class="user-btn">My Account</a> --}}
                            @endif
                            <a href="{{ route('user.logout') }}" class="user-btn logout"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login.form') }}" class="user-btn">Login</a>
                            <a href="{{ route('register.form') }}" class="user-btn register">Register</a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler" id="mobileMenuToggle">
                    <i class="ti-menu"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<style>
    /* Header Styles */
    .header.shop .header-inner {
        background: #fff;
        padding: 15px 0;
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .nav-main {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header.shop .logo img {
        max-height: 48px;
        width: auto;
    }

    .header.shop .navbar {
        flex: 1;
        margin: 0 20px;
    }

    .header.shop .navbar-collapse {

        justify-content: center;
    }

    .header.shop .nav {
        display: flex;
        align-items: center;
        gap: 5px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .header.shop .nav li a {
        color: #2c3e50;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .header.shop .nav li a:hover,
    .header.shop .nav li.active a {
        color: #F7941D;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-shrink: 0;
    }

    .nav-search {
        position: relative;
    }

    .nav-search>a {
        color: #2c3e50;
        font-size: 20px;
    }

    .nav-search-form {
        position: absolute;
        top: 45px;
        right: 0;
        background: #fff;
        padding: 15px;
        display: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        z-index: 999;
        min-width: 320px;
        border-radius: 12px;
        border: 1px solid #eee;
    }

    .nav-search-form form {
        display: flex;
        gap: 10px;
    }

    .nav-search-form select,
    .nav-search-form input {
        border: 1px solid #ddd;
        padding: 10px 12px;
        border-radius: 30px;
        font-size: 13px;
    }

    .nav-search-form button {
        background: #F7941D;
        border: none;
        padding: 0 20px;
        border-radius: 30px;
        color: #fff;
        cursor: pointer;
    }

    .single-icon {
        color: #2c3e50;
        font-size: 22px;
        position: relative;
        display: block;
    }

    .total-count {
        position: absolute;
        top: -10px;
        right: -14px;
        background: #F7941D;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }



    .user-btn {
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    .user-btn:first-child {
        background: #F7941D;
        color: #fff;
    }

    .user-btn.register {
        background: #2c3e50;
        color: #fff;
    }

    .user-btn.logout {
        background: #dc3545;
        color: #fff;
    }

    .topbar {
        background: #F7941D;
        padding: 8px 0;
    }

    .list-main {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .list-main li {
        color: #fff;
        font-size: 13px;
        font-weight: 500;
    }

    .navbar-toggler {
        display: none;
        border: none;
        background: transparent;
        font-size: 28px;
        cursor: pointer;
    }

    /* Responsive Fixes */
    @media (max-width: 992px) {
        .navbar-toggler {
            display: block !important;
            color: #2c3e50;
            float: right;
        }

        .navbar-collapse {
            display: none;
            /* jQuery toggle handle karega */
            width: 100%;
            background: #fff;
            padding: 20px;
            margin-top: 10px;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .header.shop .nav {
            flex-direction: column !important;
            align-items: flex-start !important;
        }

        .header.shop .nav li {
            width: 100%;
        }

        .header.shop .nav li a {
            display: block;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
    }

    @media (max-width: 768px) {
        .nav-main {
            flex-direction: row;
            /* Logo aur toggle ek line mein rakhne ke liye */
            justify-content: space-between;
        }

        .header-right {
            width: 100%;
            justify-content: center;
            margin-top: 15px;
        }
    }

    @media (max-width: 768px) {
        .nav-main {
            display: flex;
            flex-wrap: inherit;
        }

        .header-right {
            width: 100%;
            justify-content: space-between;
            margin-top: 8px;
        }
    }

    .header.sticky .header-inner {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: #fff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        animation: slideDown 0.3s ease;
        z-index: 999;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }

        to {
            transform: translateY(0);
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Mobile menu toggle


        // Search toggle
        $("#searchToggle").click(function(e) {
            e.preventDefault();
            $("#searchForm").toggle();
        });

        // Close dropdowns when clicking outside
        $(document).on("click", function(e) {
            if (!$(e.target).closest('.nav-search').length) {
                $("#searchForm").hide();
            }
        });

        // Sticky header
        $(window).on("scroll", function() {
            if ($(this).scrollTop() > 150) {
                $(".header").addClass("sticky");
            } else {
                $(".header").removeClass("sticky");
            }
        });
    });
</script>

<style>
    /* Modern Cart Dropdown Styles */
    .sinlge-bar {
        position: relative;
    }

    .single-icon {
        position: relative;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .single-icon i {
        font-size: 22px;
        color: #333;
        transition: color 0.3s ease;
    }

    .single-icon:hover i {
        color: #F7941D;
    }

    .total-count {
        position: absolute;
        top: -8px;
        right: -12px;
        background: linear-gradient(135deg, #F7941D, #F76E1C);
        color: white;
        font-size: 10px;
        font-weight: bold;
        min-width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Shopping Dropdown */
    .shopping-item {
        position: absolute;
        top: 100%;
        right: 0;
        width: 380px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 1000;
        overflow: hidden;
    }

    .sinlge-bar:hover .shopping-item {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Dropdown Header */
    .dropdown-cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: linear-gradient(135deg, #F7941D, #F76E1C);
        color: white;
    }

    .dropdown-cart-header span {
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dropdown-cart-header span i {
        font-size: 16px;
    }

    .view-cart-btn {
        color: white;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .view-cart-btn:hover {
        color: #333;
        transform: translateX(3px);
    }

    /* Shopping List */
    .shopping-list {
        max-height: 380px;
        overflow-y: auto;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .shopping-list::-webkit-scrollbar {
        width: 5px;
    }

    .shopping-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .shopping-list::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #F7941D, #F76E1C);
        border-radius: 5px;
    }

    .cart-item {
        position: relative;
        display: flex;
        padding: 15px 20px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .cart-item:hover {
        background: #fef9f0;
    }

    .remove-item {
        position: absolute;
        top: 15px;
        right: 20px;
        color: #dc3545;
        font-size: 16px;
        transition: all 0.3s ease;
        opacity: 0.6;
    }

    .remove-item:hover {
        opacity: 1;
        transform: scale(1.1);
        color: #dc3545;
    }

    .cart-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        margin-right: 12px;
    }

    .cart-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .cart-img:hover img {
        transform: scale(1.05);
    }

    .cart-item-info {
        flex: 1;
        padding-right: 25px;
    }

    .cart-item-info h4 {
        margin: 0 0 8px 0;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
    }

    .cart-item-info h4 a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .cart-item-info h4 a:hover {
        color: #F7941D;
    }

    .quantity {
        margin: 0 0 5px 0;
        font-size: 13px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .qty-label {
        color: #999;
    }

    .qty-value {
        font-weight: 600;
        color: #F7941D;
    }

    .price-separator {
        color: #999;
    }

    .amount {
        font-weight: 600;
        color: #333;
    }

    .item-total {
        margin: 0;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .total-label {
        color: #999;
        font-weight: normal;
    }

    .total-value {
        color: #F7941D;
        font-weight: 700;
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-cart i {
        font-size: 48px;
        color: #F7941D;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-cart p {
        color: #666;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .btn-shop-now {
        display: inline-block;
        background: linear-gradient(135deg, #F7941D, #F76E1C);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-shop-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(247, 148, 29, 0.3);
        color: white;
    }

    /* Cart Footer */
    .cart-footer {
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #e5e7eb;
    }

    .cart-subtotal,
    .cart-discount,
    .cart-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .cart-subtotal .subtotal-label,
    .cart-discount .discount-label {
        color: #666;
        font-weight: 500;
    }

    .cart-discount .discount-label i {
        margin-right: 5px;
        color: #28a745;
    }

    .cart-subtotal .subtotal-amount,
    .cart-discount .discount-amount {
        font-weight: 600;
    }

    .cart-discount .discount-amount {
        color: #28a745;
    }

    .cart-total {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e5e7eb;
        font-size: 16px;
        font-weight: 700;
    }

    .cart-total .total-label {
        color: #333;
    }

    .cart-total .total-amount {
        color: #F7941D;
        font-size: 18px;
    }

    /* Cart Actions */
    .cart-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-checkout,
    .btn-view-cart {
        flex: 1;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #F7941D, #F76E1C);
        color: white;
        border: none;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(247, 148, 29, 0.3);
        color: white;
    }

    .btn-view-cart {
        background: white;
        color: #F7941D;
        border: 1px solid #F7941D;
    }

    .btn-view-cart:hover {
        background: #F7941D;
        color: white;
        transform: translateY(-2px);
    }

    /* Animation */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .shopping-item {
        animation: slideIn 0.3s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .shopping-item {
            width: 320px;
            right: -50px;
        }

        .cart-item-info h4 {
            font-size: 13px;
        }

        .quantity,
        .item-total {
            font-size: 12px;
        }

        .cart-img {
            width: 50px;
            height: 50px;
        }
    }

    /* Badge Pulse Animation */
    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .total-count {
        animation: pulse 2s ease-in-out infinite;
    }

    /* Hover Effects */
    .cart-item {
        position: relative;
        overflow: hidden;
    }

    .cart-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(247, 148, 29, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .cart-item:hover::before {
        left: 100%;
    }
</style>

<script>
    // Optional: Add AJAX cart removal with animation
    document.addEventListener('DOMContentLoaded', function() {
        // Add remove item functionality with animation
        const removeButtons = document.querySelectorAll('.remove-item');

        removeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                const cartItem = this.closest('.cart-item');

                // Add fade out animation
                cartItem.style.transition = 'all 0.3s ease';
                cartItem.style.opacity = '0';
                cartItem.style.transform = 'translateX(20px)';

                setTimeout(() => {
                    window.location.href = url;
                }, 300);
            });
        });

        // Update cart count animation
        const cartCount = document.querySelector('.total-count');
        if (cartCount) {
            const currentCount = parseInt(cartCount.textContent);
            if (currentCount > 0) {
                cartCount.style.animation = 'none';
                setTimeout(() => {
                    cartCount.style.animation = 'pulse 0.5s ease-in-out';
                }, 10);
            }
        }
    });
</script>
