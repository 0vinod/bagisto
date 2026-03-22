{{-- Related Products Partial --}}
<div class="related-products-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">You May Also Like</h2>
            <p class="section-subtitle">Discover similar products our customers love</p>
        </div>
        
        @if(count($products) > 1)
            <div class="row g-4">
                @foreach($products as $product)
                    @if($product->id !== $currentProduct->id)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product-card">
                                <div class="product-card-image">
                                    @php
                                        $productPhotos = explode(',', $product->photo);
                                        $productImage = $productPhotos[0] ?? asset('images/default-product.jpg');
                                    @endphp
                                    <a href="{{ route('product-detail', $product->slug) }}">
                                        <img src="{{ $productImage }}" 
                                             alt="{{ $product->title }}"
                                             class="img-fluid">
                                    </a>
                                    @if($product->discount > 0)
                                        <span class="product-badge">-{{ $product->discount }}%</span>
                                    @endif
                                    <div class="product-card-actions">
                                        <button onclick="quickView('{{ $product->slug }}')" 
                                                class="action-btn" title="Quick View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="addToWishlist('{{ $product->slug }}')" 
                                                class="action-btn" title="Add to Wishlist">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <button onclick="addToCompare('{{ $product->slug }}')" 
                                                class="action-btn" title="Add to Compare">
                                            <i class="fas fa-chart-line"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-card-content">
                                    <h3 class="product-card-title">
                                        <a href="{{ route('product-detail', $product->slug) }}">
                                            {{ $product->title }}
                                        </a>
                                    </h3>
                                    
                                    <div class="product-card-rating">
                                        @php
                                            $avgRating = ceil($product->getReview->avg('rate'));
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $avgRating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="rating-count">({{ $product->getReview->count() }})</span>
                                    </div>
                                    
                                    <div class="product-card-price">
                                        @php
                                            $productAfterDiscount = $product->price - ($product->discount * $product->price) / 100;
                                        @endphp
                                        @if($product->discount > 0)
                                            <span class="current-price">${{ number_format($productAfterDiscount, 2) }}</span>
                                            <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    
                                    <button onclick="addToCart('{{ $product->slug }}', 1)" 
                                            class="btn btn-add-to-cart w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">No related products found</p>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .related-products-section {
        background: var(--light-color);
    }
    
    .section-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 10px;
    }
    
    .section-subtitle {
        color: #6b7280;
        font-size: 16px;
    }
    
    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .product-card-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1;
    }
    
    .product-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-card-image img {
        transform: scale(1.05);
    }
    
    .product-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--danger-color);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .product-card-actions {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 10px;
        background: rgba(255,255,255,0.9);
        transition: bottom 0.3s ease;
    }
    
    .product-card:hover .product-card-actions {
        bottom: 0;
    }
    
    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: white;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .product-card-content {
        padding: 15px;
    }
    
    .product-card-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .product-card-title a {
        color: var(--dark-color);
        text-decoration: none;
    }
    
    .product-card-title a:hover {
        color: var(--primary-color);
    }
    
    .product-card-rating {
        margin-bottom: 10px;
        font-size: 12px;
    }
    
    .rating-count {
        margin-left: 5px;
        color: #6b7280;
    }
    
    .product-card-price {
        margin-bottom: 15px;
    }
    
    .current-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .original-price {
        font-size: 14px;
        color: #9ca3af;
        text-decoration: line-through;
        margin-left: 8px;
    }
    
    @media (max-width: 768px) {
        .product-card-actions {
            bottom: 0;
            background: rgba(255,255,255,0.95);
        }
        
        .section-title {
            font-size: 24px;
        }
    }
</style>
@endpush