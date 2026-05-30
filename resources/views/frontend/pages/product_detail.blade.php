{{-- D:\wamp64\www\bagisto\resources\views\frontend\pages\product_detail.blade.php --}}
@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
    <meta name="description" content="{{ $product_detail->summary }}">
    <meta property="og:url" content="{{ route('product-detail', $product_detail->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $product_detail->title }}">
    <meta property="og:image" content="{{ $product_detail->photo }}">
    <meta property="og:description" content="{{ $product_detail->description }}">
@endsection

@section('title', 'E-SHOP || PRODUCT DETAIL')

@section('main-content')
<style>.blink-text {
    animation: blink 3s linear infinite;
}

@keyframes blink {
    50% {
        opacity: 5;
    }
}</style>

    <!-- Main Product Section -->
    <section class="product-detail-section py-3">
        <div class="container">
            <div class="row g-4">
                <!-- Product Gallery Column -->
                <div class="col-lg-6">
                    <div class="product-gallery-modern">
                        <!-- Main Image -->
                        <div class="main-image-container">
                            @php
                                $photos = explode(',', $product_detail->photo);
                                $mainImage = $photos[0] ?? asset('images/default-product.jpg');
                            @endphp
                            <img id="mainProductImage" src="{{ $mainImage }}" alt="{{ $product_detail->title }}"
                                class="img-fluid main-product-image">
                            @if ($product_detail->discount > 0)
                                <span class="discount-badge">-{{ $product_detail->discount }}%</span>
                            @endif
                        </div>

                        <!-- Thumbnail Gallery -->
                        @if (count($photos) > 1)
                            <div class="thumbnail-gallery mt-3">
                                <div class="row g-2">
                                    @foreach ($photos as $index => $photo)
                                        <div class="col-3">
                                            <div class="thumbnail-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ $photo }}" alt="Thumbnail {{ $index + 1 }}"
                                                    class="img-fluid thumbnail-image"
                                                    data-main-image="{{ $photo }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info Column -->
                <div class="col-lg-6">
                    <div class="product-info-modern">
                        <!-- Product Title -->
                        <h1 class="product-title">{{ $product_detail->title }}</h1>

                        <!-- Rating Section -->
                        <div class="rating-section mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stars">
                                    @php
                                        $avgRating = ceil($product_detail->getReview->avg('rate'));
                                        $avgRating = $avgRating > 3.5 ? $avgRating : 4;
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $avgRating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-count">
                                    ({{ $product_detail->getReview->count() > 1000 ? $product_detail->getReview->count() : 1001 }}
                                    reviews)
                                </span>
                                @if ($product_detail->stock > 0)
                                    <span class="stock-badge in-stock">In Stock</span>
                                @else
                                    <span class="stock-badge out-of-stock">Out of Stock</span>
                                @endif
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div class="price-section mb-2">
                            @php
                                $afterDiscount =
                                    $product_detail->price - ($product_detail->price * $product_detail->discount) / 100;
                            @endphp
                            @if ($product_detail->discount > 0)
                                <div class="price-wrapper">
                                    <span class="current-price">Rs. {{ number_format($afterDiscount, 2) }}</span>
                                    <span class="original-price">Rs. {{ number_format($product_detail->price, 2) }}</span>
                                    <span class="saved-amount">Save
                                        Rs. {{ number_format($product_detail->price - $afterDiscount, 2) }}</span>
                                </div>
                            @else
                                <span class="current-price">Rs. {{ number_format($product_detail->price, 2) }}</span>
                            @endif
                        </div>



                        <!-- Product Options Form -->
                        {{-- <form action="{{ route('single-add-to-cart') }}" method="POST" class="product-form"> --}}
                        @csrf
                        <input type="hidden" name="slug" value="{{ $product_detail->slug }}">

                        <!-- Size Selection (if available) -->
                        @if ($product_detail->size)
                            <div class="form-group ">
                                <label class="form-label fw-bold">Select Size</label>
                                <div class="size-options">
                                    @php
                                        $sizes = explode(',', $product_detail->size);
                                    @endphp
                                    @foreach ($sizes as $size)
                                        <label class="size-option">
                                            <input type="radio" name="size" value="{{ trim($size) }}" required>
                                            <span class="size-label">{{ trim($size) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        @endif

                        <!-- Color Selection (if available) -->
                        @if ($product_detail->color)
                            <div class="form-group ">
                                <label class="form-label fw-bold">Select Color</label>
                                <div class="color-options">
                                    @php
                                        $colors = explode(',', $product_detail->color);
                                    @endphp
                                    @foreach ($colors as $color)
                                        <label class="color-option">
                                            <input type="radio" name="color" value="{{ trim($color) }}" required>
                                            <span class="color-label"
                                                style="background-color: {{ trim($color) }};"></span>
                                            <span class="color-name">{{ ucfirst(trim($color)) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        @endif

                       <!-- Quantity Section -->
<div class="form-group">
      Quantity  <small class="stock-info text-warning blink-text">
     <strong>{{ $product_detail->stock > 12 ? 12 : $product_detail->stock }}</strong>
        Units available
    </small>
</div>
                        <hr>
                        @php
                            // Check if product is already in cart
                            $cartItem = \App\Models\Cart::where('user_id', auth()->id())
                                ->where('order_id', null)
                                ->where('product_id', $product_detail->id)
                                ->first();
                            $isInCart = $cartItem ? true : false;
                            $cartQuantity = $cartItem ? $cartItem->quantity : 0;
                        @endphp
                        <!-- Action Buttons -->
                        <div class="action-buttons mb-4">
                            @if ($product_detail->stock > 0)
                                <div class="product-actions mt-2">
                                    @if ($isInCart && $cartQuantity > 0)
                                        <div class="cart-quantity-controls">
                                            <button class="qty-decrease" data-product-id="{{ $product_detail->id }}">

                                            </button>
                                            <span class="cart-qty">{{ $cartQuantity }}</span>
                                            <button class="qty-increase" data-product-id="{{ $product_detail->id }}">

                                            </button>
                                        </div>
                                    @else
                                        <button class="btn-add-cart" data-slug="{{ $product_detail->slug }}"
                                            data-id="{{ $product_detail->id }}">
                                            <i class="ti-shopping-cart"></i> Add to Cart
                                        </button>
                                    @endif
                                </div>
                            @else
                                <button type="button" class="btn btn-secondary btn-out-of-stock" disabled>
                                    <i class="fas fa-times-circle me-2"></i>Out of Stock
                                </button>
                            @endif
                            <!-- Buy Now COD Button - Added Here -->
                            <div class="buy-now-cod mt-2">
                                <form action="{{ route('checkout.cod') }}" method="POST" id="codForm">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{ $product_detail->slug }}">

                                    <button type="submit" class="btn btn-cod" id=" ">
                                        <i class="ti-shopping-cart"></i> Buy Now (COD)
                                    </button>
                                </form>
                            </div>
                            <!-- End Buy Now COD Button -->


                        </div>





                        <a href="{{ route('add-to-wishlist', $product_detail->slug) }}"
                            class="btn btn-outline-secondary btn-wishlist">
                            <i class="far fa-heart"></i>
                            <span>Wishlist</span>
                        </a>


                        <!-- Product Meta Info -->
                        <div class="product-meta">
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                <span>Category:</span>
                                <a href="{{ route('product-cat', $product_detail->cat_info['slug']) }}">
                                    {{ $product_detail->cat_info['title'] }}
                                </a>
                            </div>
                            @if ($product_detail->sub_cat_info)
                                <div class="meta-item">
                                    <i class="fas fa-folder"></i>
                                    <span>Sub Category:</span>
                                    <a
                                        href="{{ route('product-sub-cat', [$product_detail->cat_info['slug'], $product_detail->sub_cat_info['slug']]) }}">
                                        {{ $product_detail->sub_cat_info['title'] }}
                                    </a>
                                </div>
                            @endif
                            <div class="meta-item">
                                <i class="fas fa-box"></i>
                                <span>SKU:</span>
                                <span>{{ $product_detail->sku ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Share Section -->
                        <div class="share-section mt-4 pt-3">
                            <span class="share-label">Share this product:</span>
                            <div class="share-icons">
                                <a href="#" class="share-icon facebook" onclick="shareProduct('facebook')">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="share-icon twitter" onclick="shareProduct('twitter')">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="share-icon pinterest" onclick="shareProduct('pinterest')">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a href="#" class="share-icon whatsapp" onclick="shareProduct('whatsapp')">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Short Description -->
                        <div class="short-description mb-2">
                            <p>{!! $product_detail->summary !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs Section -->
            <div class="product-tabs-section mt-5">
                <ul class="nav nav-tabs modern-tabs" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button" role="tab">
                            <i class="fas fa-align-left me-2"></i>Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                            type="button" role="tab">
                            <i class="fas fa-star me-2"></i>Reviews ({{ $product_detail->getReview->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                            type="button" role="tab">
                            <i class="fas fa-truck me-2"></i>Shipping Info
                        </button>
                    </li>
                </ul>

                <div class="tab-content modern-tab-content" id="productTabContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <div class="product-description">
                                {!! $product_detail->description !!}
                            </div>

                            <!-- Product Features -->
                            @if ($product_detail->features)
                                <div class="product-features mt-4">
                                    <h4>Key Features</h4>
                                    <ul class="features-list">
                                        @foreach (explode(',', $product_detail->features) as $feature)
                                            <li><i class="fas fa-check-circle text-success me-2"></i>{{ trim($feature) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <!-- Review Form -->
                            <div class="review-form-section mb-5">
                                <h4 class="mb-4">Write a Review</h4>
                                @auth
                                    <form id="reviewForm" method="post"
                                        action="{{ route('review.store', $product_detail->slug) }}" class="review-form">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Your Rating *</label>
                                            <div class="rating-input">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" name="rate" value="{{ $i }}"
                                                        id="star{{ $i }}" required>
                                                    <label for="star{{ $i }}" class="star-label">
                                                        <i class="far fa-star"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                            @error('rate')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="review" class="form-label fw-bold">Your Review *</label>
                                            <textarea name="review" id="review" rows="5" class="form-control"
                                                placeholder="Share your experience with this product..." required></textarea>
                                            @error('review')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Submit Review
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Please <a href="{{ route('login.form') }}" class="alert-link">login</a> or
                                        <a href="{{ route('register.form') }}" class="alert-link">register</a> to write a
                                        review.
                                    </div>
                                @endauth
                            </div>

                            <!-- Reviews List -->
                            <div class="reviews-list">
                                <h4 class="mb-4">Customer Reviews</h4>

                                @if ($product_detail->getReview->count() > 0)
                                    @foreach ($product_detail->getReview as $review)
                                        <div class="review-item">
                                            <div class="review-header">
                                                <div class="reviewer-info">
                                                    @if ($review->user_info['photo'])
                                                        <img src="{{ $review->user_info['photo'] }}"
                                                            alt="{{ $review->user_info['name'] }}"
                                                            class="reviewer-avatar">
                                                    @else
                                                        <div class="reviewer-avatar-placeholder">
                                                            {{ substr($review->user_info['name'], 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h5 class="reviewer-name">{{ $review->user_info['name'] }}</h5>
                                                        <div class="review-stars">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $review->rate)
                                                                    <i class="fas fa-star text-warning"></i>
                                                                @else
                                                                    <i class="far fa-star text-muted"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="review-date">
                                                    <small>{{ $review->created_at->format('M d, Y') }}</small>
                                                </div>
                                            </div>
                                            <div class="review-content">
                                                <p>{{ $review->review }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-comment-dots fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Tab -->
                    <div class="tab-pane fade" id="shipping" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <div class="shipping-info">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <i class="fas fa-truck-fast fa-2x text-primary mb-3"></i>
                                            <h5>Shipping Information</h5>
                                            <p>Free shipping on orders over $50. Standard delivery takes 3-5 business days.
                                                Express delivery available at checkout.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <i class="fas fa-undo-alt fa-2x text-primary mb-3"></i>
                                            <h5>Returns Policy</h5>
                                            <p>30-day money-back guarantee. Items must be returned in original condition
                                                with packaging.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <i class="fas fa-shield-alt fa-2x text-primary mb-3"></i>
                                            <h5>Secure Shopping</h5>
                                            <p>Your payment information is encrypted and secure. We never store your credit
                                                card details.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <i class="fas fa-headset fa-2x text-primary mb-3"></i>
                                            <h5>Customer Support</h5>
                                            <p>24/7 customer support available via email, chat, or phone.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    @include('frontend.partials.related-products', [
        'products' => $product_detail->rel_prods,
        'currentProduct' => $product_detail,
    ])

    <!-- Recently Viewed Products Modal -->
    @include('frontend.partials.product-modal')
@endsection

@push('styles')
    <style>
        /* Modern Product Page Styles */
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #f59e0b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --border-color: #e5e7eb;
        }

        /* Breadcrumb */
        .breadcrumb-wrapper {
            background: var(--light-color);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        /* Product Gallery */
        .product-gallery-modern {
            position: sticky;
            top: 20px;
        }

        .main-image-container {
            position: relative;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            cursor: zoom-in;
        }

        .main-product-image {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .main-product-image:hover {
            transform: scale(1.05);
        }

        .discount-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--danger-color);
            color: white;
            padding: 5px 12px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            z-index: 1;
        }

        .thumbnail-item {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .thumbnail-item.active {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .thumbnail-image {
            width: 100%;
            height: auto;
        }

        /* Product Info */
        .product-info-modern {
            padding: 0 20px;
        }

        .product-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
        }

        .stars {
            font-size: 16px;
            letter-spacing: 2px;
        }

        .stock-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .in-stock {
            background: #d1fae5;
            color: #065f46;
        }

        .out-of-stock {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Price Section */
        .price-section {
            padding: 1px 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .current-price {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .original-price {
            font-size: 18px;
            color: #9ca3af;
            text-decoration: line-through;
            margin-left: 10px;
        }

        .saved-amount {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
        }

        /* Size Options */
        .size-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .size-option {
            position: relative;
            cursor: pointer;
        }

        .size-option input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .size-label {
            display: inline-block;
            padding: 8px 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .size-option input:checked+.size-label {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Color Options */
        .color-options {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .color-option {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            position: relative;
        }

        .color-option input {
            position: absolute;
            opacity: 0;
        }

        .color-label {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .color-name {
            font-size: 13px;
        }

        .color-option input:checked+.color-label {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        /* Quantity Selector */
        .quantity-selector {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .qty-btn {
            background: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .qty-btn:hover {
            background: var(--light-color);
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border: none;
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            padding: 10px 0;
        }

        .quantity-input:focus {
            outline: none;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-add-to-cart {
            background: var(--primary-color);
            border: none;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-add-to-cart:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-wishlist,
        .btn-compare {
            padding: 12px 20px;
        }

        /* Product Meta */
        .product-meta {
            background: var(--light-color);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .meta-item {
            margin-bottom: 8px;
            font-size: 14px;
        }

        .meta-item i {
            width: 25px;
            color: var(--primary-color);
        }

        /* Share Section */
        .share-icons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .share-icon {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--light-color);
            color: var(--dark-color);
            transition: all 0.3s ease;
        }

        .share-icon:hover {
            transform: translateY(-2px);
        }

        .share-icon.facebook:hover {
            background: #1877f2;
            color: white;
        }

        .share-icon.twitter:hover {
            background: #1da1f2;
            color: white;
        }

        .share-icon.pinterest:hover {
            background: #bd081c;
            color: white;
        }

        .share-icon.whatsapp:hover {
            background: #25d366;
            color: white;
        }

        /* Tabs */
        .modern-tabs {
            border-bottom: 2px solid var(--border-color);
            gap: 10px;
        }

        .modern-tabs .nav-link {
            border: none;
            padding: 12px 24px;
            color: var(--dark-color);
            font-weight: 500;
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
        }

        .modern-tabs .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .modern-tab-content {
            padding: 30px;
            background: white;
            border: 1px solid var(--border-color);
            border-top: none;
            border-radius: 0 0 8px 8px;
        }

        /* Review Form */
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }

        .rating-input input {
            display: none;
        }

        .star-label {
            cursor: pointer;
            font-size: 24px;
            color: #d1d5db;
            transition: color 0.2s;
        }

        .rating-input input:checked~label,
        .rating-input label:hover,
        .rating-input label:hover~label {
            color: #f59e0b;
        }

        /* Review Item */
        .review-item {
            padding: 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .reviewer-info {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .reviewer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .reviewer-avatar-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
        }

        .reviewer-name {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
        }

        /* Info Cards */
        .info-card {
            padding: 20px;
            background: var(--light-color);
            border-radius: 8px;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-info-modern {
                padding: 0;
            }

            .product-title {
                font-size: 24px;
            }

            .current-price {
                font-size: 28px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-add-to-cart,
            .btn-wishlist,
            .btn-compare {
                width: 100%;
            }

            .modern-tabs .nav-link {
                padding: 10px 15px;
                font-size: 14px;
            }

            .modern-tab-content {
                padding: 20px;
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

        .product-detail-section {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        // Thumbnail Gallery
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.addEventListener('click', function() {
                const mainImage = this.querySelector('.thumbnail-image').dataset.mainImage;
                document.getElementById('mainProductImage').src = mainImage;

                // Update active state
                document.querySelectorAll('.thumbnail-item').forEach(thumb => {
                    thumb.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Quantity Update
        function updateQuantity(action) {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            const maxStock = parseInt(quantityInput.dataset.stock);

            if (action === 'plus' && currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            } else if (action === 'minus' && currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }

            // Trigger change event
            quantityInput.dispatchEvent(new Event('change'));
        }

        // Validate quantity input
        document.getElementById('quantity')?.addEventListener('change', function() {
            let value = parseInt(this.value);
            const maxStock = parseInt(this.dataset.stock);

            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > maxStock) {
                this.value = maxStock;
                swal('Info', `Only ${maxStock} units available`, 'info');
            }
        });

        // Add to Cart with AJAX
        document.getElementById('addToCartForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = document.getElementById('addToCartBtn');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
            submitBtn.disabled = true;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.status) {
                    swal({
                        title: 'Success!',
                        text: data.msg || 'Product added to cart successfully',
                        icon: 'success',
                        button: 'Continue Shopping'
                    }).then(() => {
                        // Update cart count in header
                        updateCartCount();
                    });
                } else {
                    swal('Error', data.msg || 'Failed to add product to cart', 'error');
                }
            } catch (error) {
                swal('Error', 'Something went wrong. Please try again.', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Share Product
        function shareProduct(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $product_detail->title }}');
            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'pinterest':
                    shareUrl =
                        `https://pinterest.com/pin/create/button/?url=${url}&media={{ $photos[0] }}&description=${title}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title} ${url}`;
                    break;
            }

            window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        // Add to Compare
        function addToCompare(slug) {
            // Implement compare functionality
            swal('Info', 'Product added to compare list', 'info');
        }

        // Update cart count (implement based on your header structure)
        function updateCartCount() {
            // You can implement this to update cart count in header
            if (window.updateHeaderCartCount) {
                window.updateHeaderCartCount();
            }
        }

        // Smooth scroll to reviews
        document.querySelector('.total-review')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#reviews-tab')?.click();
            document.querySelector('#reviews')?.scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Star rating preview
        document.querySelectorAll('.star-label').forEach(star => {
            star.addEventListener('mouseenter', function() {
                const stars = this.parentElement.querySelectorAll('.star-label');
                const index = Array.from(stars).indexOf(this);

                stars.forEach((s, i) => {
                    if (i >= index) {
                        s.querySelector('i').classList.remove('far');
                        s.querySelector('i').classList.add('fas');
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                const stars = this.parentElement.querySelectorAll('.star-label');
                const checked = this.parentElement.querySelector('input:checked');
                const checkedIndex = checked ? Array.from(stars).indexOf(checked.parentElement
                    .querySelector('.star-label')) : -1;

                stars.forEach((s, i) => {
                    if (i <= checkedIndex) {
                        s.querySelector('i').classList.add('fas');
                        s.querySelector('i').classList.remove('far');
                    } else {
                        s.querySelector('i').classList.add('far');
                        s.querySelector('i').classList.remove('fas');
                    }
                });
            });
        });
    </script>
@endpush
