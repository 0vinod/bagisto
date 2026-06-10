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
                        <img src="{{ asset('frontend/img/logo.png') }}" alt="Moonzio">
                    </a>
                </div>

                <nav class="navbar navbar-expand-lg">
  
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa-solid fa-bars-staggered"></i>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>

                            <li class="nav-item {{ request()->routeIs('about-us') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
                            </li>

                            <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('product-grids') }}">Products</a>
                            </li>

                            @if (isset($categories) && count($categories) > 0)
                                @foreach ($categories->take(5) as $category)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('products.category', $category->slug) }}">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif

                            {{-- <li class="nav-item"><a class="nav-link" href="{{ route('blog') }}">Blog</a></li> --}}
                            <li class="nav-item"><a class="nav-link" href="{{ route('order.track') }}">Track Order</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                            <li>
                                     <div class="header-user">
                        @auth
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('admin') }}" class="user-btn">Dashboard</a>
                            @else
                                <a href="{{ route('user') }}" class="user-btn">My Account</a>
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
                            </li>
      
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
                                                        <span class="amount">Rs. {{ number_format($item->price, 2) }}</span>
                                                    </p>
                                                    <p class="item-total">
                                                        <span class="total-label">Total:</span>
                                                        <span
                                                            class="total-value">Rs. {{ number_format($item->amount, 2) }}</span>
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
                                                Rs. {{ isset($cartTotal) ? number_format($cartTotal, 2) : '0.00' }}
                                            </span>
                                        </div>

                                        @if (session()->has('coupon'))
                                            <div class="cart-discount">
                                                <span class="discount-label">
                                                    <i class="fas fa-ticket-alt"></i> Discount
                                                </span>
                                                <span class="discount-amount">
                                                    -Rs. {{ number_format(Session::get('coupon')['value'], 2) }}
                                                </span>
                                            </div>
                                            @php
                                                $finalTotal = $cartTotal - Session::get('coupon')['value'];
                                            @endphp
                                            <div class="cart-total">
                                                <span class="total-label">Total</span>
                                                <span class="total-amount">Rs. {{ number_format($finalTotal, 2) }}</span>
                                            </div>
                                        @else
                                            <div class="cart-total">
                                                <span class="total-label">Total</span>
                                                <span
                                                    class="total-amount">Rs. {{ isset($cartTotal) ? number_format($cartTotal, 2) : '0.00' }}</span>
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
               
                </div>

            </div>
        </div>
    </div>
</header>
 