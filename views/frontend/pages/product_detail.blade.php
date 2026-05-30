{{-- D:\wamp64\www\bagisto\resources\views\frontend\pages\product_detail.blade.php --}}
@extends('frontend.layouts.master')

@section('meta')
@php
    $photos = explode(',', $product_detail->photo);
    $mainImage = $photos[0] ?? asset('images/default-product.jpg');

    $afterDiscount =
        $product_detail->price -
        ($product_detail->price * $product_detail->discount) / 100;
@endphp

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
   
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
    <meta name="description" content="{{ Str::limit(strip_tags($product_detail->summary), 160) }}">
    <meta property="og:url" content="{{ route('product-detail', $product_detail->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $product_detail->title }}">
    <meta property="og:image" content="{{ asset(trim(explode(',', $product_detail->photo)[0])) }}">
    <meta property="og:description" content="{{ $product_detail->description }}">
   
   <meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $product_detail->title }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($product_detail->summary), 160) }}">
  <meta property="og:image" content="{{ asset(trim(explode(',', $product_detail->photo)[0])) }}">
  
  <script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ $product_detail->title }}",
  "image": "{{ $mainImage }}",
  "description": "{{ strip_tags($product_detail->summary) }}",
  "sku": "{{ $product_detail->sku }}",
  "brand": {
    "@type": "Brand",
    "name": "Moonzio"
  },
  "offers": {
    "@type": "Offer",
    "url": "{{ route('product-detail', $product_detail->slug) }}",
    "priceCurrency": "INR",
    "price": "{{ $afterDiscount }}",
    "availability": "https://schema.org/{{ $product_detail->stock > 0 ? 'InStock' : 'OutOfStock' }}"
  }
}
</script>
@endsection
 <link rel="canonical" href="{{ route('product-detail', $product_detail->slug) }}">
 <script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "BreadcrumbList",
 "itemListElement": [{
   "@type": "ListItem",
   "position": 1,
   "name": "Home",
   "item": "{{ url('/') }}"
 },{
   "@type": "ListItem",
   "position": 2,
   "name": "{{ $product_detail->cat_info['title'] }}",
   "item": "{{ route('product-cat', $product_detail->cat_info['slug']) }}"
 },{
   "@type": "ListItem",
   "position": 3,
   "name": "{{ $product_detail->title }}"
 }]
}
</script>
@section('title', $product_detail->title . ' | Moonzio')

@section('main-content')
 
<link rel="stylesheet" href="{{ asset('frontend/css/product-detail.css') }}">

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
                           
                                <img
    id="mainProductImage"
    src="{{ $mainImage }}"
    alt="{{ $product_detail->title }}"
    class="img-fluid main-product-image"
    width="700"
    height="700"
    loading="eager"
>
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
                                                <img src="{{ $photo }}" alt="{{ $product_detail->title }} image {{ $index + 1 }}"
                                                    class="img-fluid thumbnail-image"
                                                    data-main-image="{{ $photo }}" loading="lazy">
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

 

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
   <script src="{{ asset('frontend/js/product-detail.js') }}"></script>
@endpush
