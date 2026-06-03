@extends('frontend.layouts.master')

@section('title', 'Moonzio || HOME PAGE')

@section('main-content')
    <!-- Slider Area -->
    @if (isset($banners) && count($banners) > 0)
        <section id="Gslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banners as $key => $banner)
                    <li data-target="#Gslider" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}">
                    </li>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="first-slide" src="{{ $banner->photo }}" alt="{{ $banner->title ?? 'Banner' }}">
                        <div class="carousel-caption d-none d-md-block text-left">
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </section>
    @endif

    <!-- Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>🔥 Trending Items</h2>
                    </div>
                </div>
            </div>

            <div class="row" id="product-data">
                @if (isset($products) && count($products) > 0)
                    @foreach ($products as $product)
                        @php
                            // Check if product is already in cart
                            $cartItem = \App\Models\Cart::where('user_id', auth()->id())
                                ->where('order_id', null)
                                ->where('product_id', $product->id)
                                ->first();
                            $isInCart = $cartItem ? true : false;
                            $cartQuantity = $cartItem ? $cartItem->quantity : 0;
                        @endphp
                        <div class="col-lg-3 col-md-4 col-6 mb-4">
                            <div class="single-product" data-product-id="{{ $product->id }}"
                                data-product-slug="{{ $product->slug }}">
                                <div class="product-img">
                                    <a href="{{ route('product-detail', $product->slug) }}">
                                        @php
                                            $photos = explode(',', $product->photo);
                                        @endphp
                                        <img class="default-img" src="{{ $photos[0] }}" alt="{{ $product->title }}">
                                    </a>
                                    @if ($product->discount > 0)
                                        <span class="sale-tag">-{{ $product->discount }}%</span>
                                    @endif
                                </div>
                                <div class="product-content">
                                    <h3>
                                        <a href="{{ route('product-detail', $product->slug) }}">
                                            {{ Str::limit($product->title, 40) }}
                                        </a>
                                    </h3>
                                    @php
                                        $after_discount =
                                            $product->price - ($product->price * $product->discount) / 100;
                                    @endphp
                                    <div class="product-price">
                                        <span>Rs. {{ number_format($after_discount, 2) }}</span>
                                        @if ($product->discount > 0)
                                            <del>Rs. {{ number_format($product->price, 2) }}</del>
                                        @endif
                                    </div>
                                    <div class="product-actions mt-2">
                                        @if ($isInCart && $cartQuantity > 0)
                                            <div class="cart-quantity-controls">
                                                <button class="qty-decrease" data-product-id="{{ $product->id }}">

                                                </button>
                                                <span class="cart-qty">{{ $cartQuantity }}</span>
                                                <button class="qty-increase" data-product-id="{{ $product->id }}">

                                                </button>
                                            </div>
                                        @else
                                            <button class="btn-add-cart d-none" data-slug="{{ $product->slug }}"
                                                data-id="{{ $product->id }}">
                                                <i class="ti-shopping-cart"></i> Add to Cart
                                            </button>
                                            <div class="buy-now-cod mt-2">
                                                <form action="{{ route('checkout') }}" method="post" id="codForm">
                                                    @csrf
                                                    <input type="hidden" name="slug"
                                                        value="{{ $product->slug }}">

                                                    <button type="submit" class="btn btn-cod" id=" ">
                                                        <i class="ti-shopping-cart"></i> Buy Now (COD)
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>No products found.</p>
                    </div>
                @endif
            </div>

            @if (isset($products) && count($products) >= 8)
                <div class="text-center mt-4">
                    <button id="load-more" data-page="2" class="btn btn-dark">
                        Load More Products
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Shop Services Area -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free Shipping</h4>
                        <p>Cash On Delivery</p>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                </div> --}}
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Guaranteed Premium Quality </h4>
                        <p>Original Moonzio Product</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
