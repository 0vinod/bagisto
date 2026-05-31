@extends('frontend.layouts.master')

@section('title', 'Moonzio || PRODUCT PAGE')

@section('main-content')
    <!-- Modern Breadcrumbs -->
    <div class="modern-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="modern-breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shop List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('shop.filter') }}" method="POST" id="filterForm">
        @csrf
        <section class="modern-product-list section">
            <div class="container">
                <div class="row g-4">
                    <!-- Sidebar -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="product-sidebar">
                            <!-- Categories Widget -->
                            <div class="sidebar-widget">
                                <h3 class="widget-title">
                                    <i class="fas fa-folder-open"></i>
                                    Categories
                                </h3>
                                <div class="widget-content">
                                    <ul class="category-list">
                                        @php
                                            $menu = App\Models\Category::getAllParentWithChild();
                                        @endphp
                                        @if ($menu)
                                            @foreach ($menu as $cat_info)
                                                @if ($cat_info->child_cat->count() > 0)
                                                    <li class="has-children">
                                                        <a href="{{ route('product-cat', $cat_info->slug) }}">
                                                            <i class="fas fa-chevron-right"></i>
                                                            {{ $cat_info->title }}
                                                        </a>
                                                        <ul class="sub-categories">
                                                            @foreach ($cat_info->child_cat as $sub_menu)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]) }}">
                                                                        {{ $sub_menu->title }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="{{ route('product-cat', $cat_info->slug) }}">
                                                            <i class="fas fa-chevron-right"></i>
                                                            {{ $cat_info->title }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <!-- Price Range Widget -->
                            <div class="sidebar-widget">
                                <h3 class="widget-title">
                                    <i class="fas fa-dollar-sign"></i>
                                    Filter by Price
                                </h3>
                                <div class="widget-content">
                                    <div class="price-range-container">
                                        @php
                                            $max = DB::table('products')->max('price');
                                        @endphp
                                        <div id="slider-range" data-min="0" data-max="{{ $max }}"
                                            data-currency="$"></div>
                                        <div class="price-range-values">
                                            <div class="price-range-input">
                                                <span class="price-label">Range:</span>
                                                <input type="text" id="amount" class="price-amount" readonly />
                                                <input type="hidden" name="price_range" id="price_range"
                                                    value="@if (!empty($_GET['price'])) {{ $_GET['price'] }} @endif" />
                                            </div>
                                            <button type="submit" class="btn-filter">
                                                <i class="fas fa-filter"></i>
                                                Apply Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Products Widget -->
                            <div class="sidebar-widget">
                                <h3 class="widget-title">
                                    <i class="fas fa-clock"></i>
                                    Recent Products
                                </h3>
                                <div class="widget-content">
                                    @foreach ($recent_products as $product)
                                        @php
                                            $photo = explode(',', $product->photo);
                                            $after_discount =
                                                $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        <div class="recent-product-item">
                                            <div class="recent-product-image">
                                                <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                                            </div>
                                            <div class="recent-product-info">
                                                <h5>
                                                    <a href="{{ route('product-detail', $product->slug) }}">
                                                        {{ Str::limit($product->title, 40) }}
                                                    </a>
                                                </h5>
                                                <div class="recent-product-price">
                                                    <span class="current-price">Rs.
                                                        {{ number_format($after_discount, 2) }}</span>
                                                    <del class="old-price">Rs.
                                                        {{ number_format($product->price, 2) }}</del>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Brands Widget -->
                            <div class="sidebar-widget">
                                <h3 class="widget-title">
                                    <i class="fas fa-tag"></i>
                                    Brands
                                </h3>
                                <div class="widget-content">
                                    <ul class="brand-list">
                                        @php
                                            $brands = DB::table('brands')
                                                ->orderBy('title', 'ASC')
                                                ->where('status', 'active')
                                                ->get();
                                        @endphp
                                        @foreach ($brands as $brand)
                                            <li>
                                                <a href="{{ route('product-brand', $brand->slug) }}">
                                                    <i class="fas fa-chevron-right"></i>
                                                    {{ $brand->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products List -->
                    <div class="col-lg-9 col-md-8 col-12">
                        <!-- Shop Top Bar -->
                        <div class="shop-top-bar">
                            <div class="filter-options">
                                <div class="filter-option">
                                    <label>Show:</label>
                                    <select class="form-select" name="show" onchange="this.form.submit();">
                                        <option value="">Default</option>
                                        <option value="9" @if (!empty($_GET['show']) && $_GET['show'] == '9') selected @endif>09</option>
                                        <option value="15" @if (!empty($_GET['show']) && $_GET['show'] == '15') selected @endif>15</option>
                                        <option value="21" @if (!empty($_GET['show']) && $_GET['show'] == '21') selected @endif>21</option>
                                        <option value="30" @if (!empty($_GET['show']) && $_GET['show'] == '30') selected @endif>30</option>
                                    </select>
                                </div>
                                <div class="filter-option">
                                    <label>Sort By:</label>
                                    <select class="form-select" name="sortBy" onchange="this.form.submit();">
                                        <option value="">Default</option>
                                        <option value="title" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'title') selected @endif>Name
                                        </option>
                                        <option value="price" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price') selected @endif>Price
                                        </option>
                                        <option value="category" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'category') selected @endif>Category
                                        </option>
                                        <option value="brand" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'brand') selected @endif>Brand
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="view-mode">
                                <a href="{{ route('product-grids') }}" title="Grid View">
                                    <i class="fas fa-th-large"></i>
                                </a>
                                <a href="javascript:void(0)" class="active" title="List View">
                                    <i class="fas fa-list"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Products List Container -->
                        <div class="products-list">
                            @if (count($products) > 0)
                                @foreach ($products as $product)
                                    @php
                                        $photo = explode(',', $product->photo);
                                        $after_discount =
                                            $product->price - ($product->price * $product->discount) / 100;
                                    @endphp
                                    <div class="product-list-item">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-md-5 col-sm-6">
                                                <div class="product-image">
                                                    <a href="{{ route('product-detail', $product->slug) }}">
                                                        <img class="primary-img" src="{{ $photo[0] }}"
                                                            alt="{{ $product->title }}">
                                                        @if (count($photo) > 1)
                                                            <img class="hover-img" src="{{ $photo[1] }}"
                                                                alt="{{ $product->title }}">
                                                        @endif
                                                    </a>
                                                    @if ($product->discount)
                                                        <span class="discount-badge">-{{ $product->discount }}%</span>
                                                    @endif
                                                    <div class="product-actions">
                                                        <button class="action-btn quick-view" data-toggle="modal"
                                                            data-target="#{{ $product->id }}" title="Quick View">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a href="{{ route('add-to-wishlist', $product->slug) }}"
                                                            class="action-btn wishlist" title="Add to Wishlist">
                                                            <i class="far fa-heart"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-7 col-sm-6">
                                                <div class="product-info">
                                                    <div class="product-price">
                                                        <span class="current-price">Rs.
                                                            {{ number_format($after_discount, 2) }}</span>
                                                        <del class="old-price">Rs.
                                                            {{ number_format($product->price, 2) }}</del>
                                                    </div>
                                                    <h3 class="product-title">
                                                        <a href="{{ route('product-detail', $product->slug) }}">
                                                            {{ $product->title }}
                                                        </a>
                                                    </h3>
                                                    <div class="product-rating">
                                                        @php
                                                            $rate = DB::table('product_reviews')
                                                                ->where('product_id', $product->id)
                                                                ->avg('rate');
                                                            $rate_count = DB::table('product_reviews')
                                                                ->where('product_id', $product->id)
                                                                ->count();
                                                        @endphp
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($rate >= $i)
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                        <span class="rating-count">({{ $rate_count }} reviews)</span>
                                                    </div>
                                                    <p class="product-description">
                                                        {!! html_entity_decode(Str::limit($product->summary, 120)) !!}
                                                    </p>
                                                    <div class="product-stock">
                                                        @if ($product->stock > 0)
                                                            <span class="in-stock">
                                                                <i class="fas fa-check-circle"></i> In Stock
                                                                ({{ $product->stock }})
                                                            </span>
                                                        @else
                                                            <span class="out-of-stock">
                                                                <i class="fas fa-times-circle"></i> Out of Stock
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="buy-now-cod mt-2">
                                                       <a href="{{ route('checkout', ['slug' => $product->slug]) }}"
   class="btn btn-cod">
    <i class="ti-shopping-cart"></i> Buy Now (COD)
</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-products">
                                    <i class="fas fa-box-open"></i>
                                    <h4>No Products Found</h4>
                                    <p>Try adjusting your filters or browse our categories.</p>
                                    <a href="{{ route('product-grids') }}" class="btn btn-primary">Reset Filters</a>
                                </div>
                            @endif
                        </div>

                        <!-- Pagination -->
                        @if (count($products) > 0)
                            <div class="pagination-wrapper">
                                {{ $products->appends($_GET)->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </form>

    <!-- Quick View Modals -->
    @if ($products)
        @foreach ($products as $product)
            <div class="modal fade quickview-modal" id="{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Quick View</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            @php
                                                $photo = explode(',', $product->photo);
                                            @endphp
                                            @foreach ($photo as $data)
                                                <div class="single-slider">
                                                    <img src="{{ $data }}" alt="{{ $product->title }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="quickview-content">
                                        <h2>{{ $product->title }}</h2>

                                        <div class="quickview-rating">
                                            <div class="rating-stars">
                                                @php
                                                    $rate = DB::table('product_reviews')
                                                        ->where('product_id', $product->id)
                                                        ->avg('rate');
                                                    $rate_count = DB::table('product_reviews')
                                                        ->where('product_id', $product->id)
                                                        ->count();
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($rate >= $i)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span class="rating-count">({{ $rate_count }} reviews)</span>
                                            </div>
                                            <div class="stock-status">
                                                @if ($product->stock > 0)
                                                    <span class="in-stock">
                                                        <i class="fas fa-check-circle"></i> {{ $product->stock }} in stock
                                                    </span>
                                                @else
                                                    <span class="out-of-stock">
                                                        <i class="fas fa-times-circle"></i> Out of stock
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        @php
                                            $after_discount =
                                                $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        <div class="quickview-price">
                                            <span class="current-price">Rs. {{ number_format($after_discount, 2) }}</span>
                                            <del class="old-price">Rs. {{ number_format($product->price, 2) }}</del>
                                        </div>

                                        <div class="quickview-description">
                                            <p>{!! html_entity_decode(Str::limit($product->summary, 150)) !!}</p>
                                        </div>

                                        @if ($product->size)
                                            <div class="size-selection">
                                                <h4>Select Size</h4>
                                                <div class="size-options">
                                                    @php
                                                        $sizes = explode(',', $product->size);
                                                    @endphp
                                                    @foreach ($sizes as $size)
                                                        <label class="size-option">
                                                            <input type="radio" name="size"
                                                                value="{{ trim($size) }}">
                                                            <span class="size-label">{{ trim($size) }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <form action="{{ route('single-add-to-cart') }}" method="POST"
                                            class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="slug" value="{{ $product->slug }}">
                                            <div class="quantity-selector">
                                                <label>Quantity:</label>
                                                <div class="quantity-controls">
                                                    <button type="button" class="qty-minus">-</button>
                                                    <input type="text" name="quant[1]" class="quantity-input"
                                                        value="1" min="1" max="1000">
                                                    <button type="button" class="qty-plus">+</button>
                                                </div>
                                            </div>
                                            <div class="quickview-actions">
                                                <button type="submit" class="btn-add-to-cart">
                                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                                </button>
                                                <a href="{{ route('add-to-wishlist', $product->slug) }}"
                                                    class="btn-wishlist">
                                                    <i class="far fa-heart"></i>
                                                </a>
                                            </div>
                                        </form>

                                        <div class="share-buttons">
                                            <span>Share:</span>
                                            <div class="sharethis-inline-share-buttons"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@push('styles')
    <style>
        /* Modern Product List Styles */
        :root {
            --primary-orange: #F7941D;
            --primary-dark: #F76E1C;
            --text-dark: #333;
            --text-light: #6c757d;
            --border-color: #e5e7eb;
            --bg-light: #f8f9fa;
        }

        /* Breadcrumbs */
        .modern-breadcrumbs {
            background: var(--bg-light);
            padding: 15px 0;
            margin-bottom: 30px;
        }

        .modern-breadcrumb {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            background: transparent;
        }

        .modern-breadcrumb .breadcrumb-item {
            color: var(--text-light);
        }

        .modern-breadcrumb .breadcrumb-item a {
            color: var(--primary-orange);
            text-decoration: none;
        }

        .modern-breadcrumb .breadcrumb-item.active {
            color: var(--text-dark);
        }

        .modern-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            padding: 0 8px;
            color: var(--text-light);
        }

        /* Sidebar */
        .product-sidebar {
            position: sticky;
            top: 20px;
        }

        .sidebar-widget {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .sidebar-widget:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .widget-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary-orange);
            display: inline-block;
        }

        .widget-title i {
            color: var(--primary-orange);
            margin-right: 8px;
        }

        /* Category Lists */
        .category-list,
        .brand-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li,
        .brand-list li {
            margin-bottom: 10px;
        }

        .category-list li a,
        .brand-list li a {
            color: var(--text-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 0;
            transition: all 0.3s ease;
        }

        .category-list li a i,
        .brand-list li a i {
            font-size: 12px;
            color: var(--primary-orange);
            transition: transform 0.3s ease;
        }

        .category-list li a:hover,
        .brand-list li a:hover {
            color: var(--primary-orange);
            padding-left: 5px;
        }

        .category-list li a:hover i {
            transform: translateX(3px);
        }

        .sub-categories {
            list-style: none;
            padding-left: 25px;
            margin-top: 8px;
        }

        /* Price Range */
        .price-range-container {
            padding: 10px 0;
        }

        .ui-slider {
            background: var(--border-color);
            border-radius: 10px;
            height: 4px;
            margin-bottom: 20px;
        }

        .ui-slider .ui-slider-handle {
            width: 16px;
            height: 16px;
            background: white;
            border: 2px solid var(--primary-orange);
            border-radius: 50%;
            cursor: pointer;
            top: -6px;
        }

        .ui-slider .ui-slider-range {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
        }

        .price-range-values {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .price-amount {
            background: var(--bg-light);
            border: 1px solid var(--border-color);
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            width: auto;
            display: inline-block;
        }

        .btn-filter {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 148, 29, 0.3);
        }

        /* Recent Products */
        .recent-product-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .recent-product-item:last-child {
            border-bottom: none;
        }

        .recent-product-image {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .recent-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recent-product-info h5 {
            font-size: 14px;
            margin: 0 0 5px 0;
        }

        .recent-product-info h5 a {
            color: var(--text-dark);
            text-decoration: none;
        }

        .recent-product-info h5 a:hover {
            color: var(--primary-orange);
        }

        .recent-product-price .current-price {
            color: var(--primary-orange);
            font-weight: 600;
            font-size: 14px;
        }

        .recent-product-price .old-price {
            font-size: 12px;
            color: var(--text-light);
            margin-left: 5px;
        }

        /* Shop Top Bar */
        .shop-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-options {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .filter-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-option label {
            margin: 0;
            font-size: 14px;
            color: var(--text-light);
        }

        .filter-option .form-select {
            padding: 6px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        .view-mode {
            display: flex;
            gap: 10px;
        }

        .view-mode a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: var(--bg-light);
            border-radius: 8px;
            color: var(--text-light);
            transition: all 0.3s ease;
        }

        .view-mode a.active,
        .view-mode a:hover {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
            color: white;
        }

        /* Product List Items */
        .product-list-item {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .product-list-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            aspect-ratio: 1;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-image .hover-img {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .product-list-item:hover .product-image .primary-img {
            transform: scale(1.05);
        }

        .product-list-item:hover .product-image .hover-img {
            opacity: 1;
        }

        .discount-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 1;
        }

        .product-actions {
            position: absolute;
            bottom: 12px;
            right: 12px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
            z-index: 1;
        }

        .product-list-item:hover .product-actions {
            opacity: 1;
            transform: translateX(0);
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            color: var(--text-dark);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        /* Product Info */
        .product-info {
            padding-left: 20px;
        }

        .product-price {
            margin-bottom: 10px;
        }

        .current-price {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-orange);
        }

        .old-price {
            font-size: 16px;
            color: var(--text-light);
            margin-left: 10px;
        }

        .product-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .product-title a {
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .product-title a:hover {
            color: var(--primary-orange);
        }

        .product-rating {
            margin-bottom: 12px;
        }

        .rating-count {
            margin-left: 8px;
            font-size: 13px;
            color: var(--text-light);
        }

        .product-description {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .product-stock {
            margin-bottom: 20px;
        }

        .in-stock {
            color: #28a745;
            font-size: 14px;
            font-weight: 500;
        }

        .out-of-stock {
            color: #dc3545;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-add-to-cart {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-add-to-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(247, 148, 29, 0.3);
            color: white;
        }

        /* Empty Products */
        .empty-products {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
        }

        .empty-products i {
            font-size: 64px;
            color: var(--primary-orange);
            margin-bottom: 20px;
        }

        .empty-products h4 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .empty-products p {
            color: var(--text-light);
            margin-bottom: 20px;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination {
            display: inline-flex;
            gap: 5px;
            list-style: none;
            padding: 0;
        }

        .pagination li a,
        .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 8px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination li.active span,
        .pagination li a:hover {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
            color: white;
            border-color: transparent;
        }

        /* Quick View Modal */
        .quickview-modal .modal-content {
            border-radius: 12px;
            overflow: hidden;
        }

        .quickview-modal .modal-header {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
            color: white;
            border: none;
        }

        .quickview-modal .modal-header .close {
            color: white;
            opacity: 1;
        }

        .quickview-content h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .quickview-rating {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .quickview-price {
            margin-bottom: 15px;
        }

        .quickview-price .current-price {
            font-size: 28px;
        }

        .size-selection {
            margin: 15px 0;
        }

        .size-options {
            display: flex;
            gap: 10px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .size-option {
            cursor: pointer;
        }

        .size-option input {
            display: none;
        }

        .size-label {
            display: inline-block;
            padding: 6px 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .size-option input:checked+.size-label {
            background: linear-gradient(135deg, var(--primary-orange), var(--primary-dark));
            color: white;
            border-color: transparent;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 20px 0;
        }

        .quantity-controls {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .quantity-controls button {
            width: 36px;
            height: 36px;
            border: none;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-controls button:hover {
            background: var(--primary-orange);
            color: white;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            padding: 8px 0;
        }

        .quickview-actions {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }

        .quickview-actions .btn-add-to-cart {
            flex: 1;
        }

        .btn-wishlist {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .btn-wishlist:hover {
            background: var(--primary-orange);
            color: white;
            border-color: transparent;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .product-info {
                padding-left: 0;
                margin-top: 20px;
            }

            .product-image {
                max-width: 300px;
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .product-list-item {
                padding: 20px;
            }

            .current-price {
                font-size: 20px;
            }

            .product-title {
                font-size: 18px;
            }

            .shop-top-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-options {
                justify-content: center;
            }

            .product-sidebar {
                position: static;
                margin-bottom: 30px;
            }

            .product-actions {
                opacity: 1;
                transform: translateX(0);
                bottom: 12px;
                right: 12px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-list-item {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            // Price Range Slider
            if ($("#slider-range").length > 0) {
                const max_value = parseInt($("#slider-range").data('max')) || 500;
                const min_value = parseInt($("#slider-range").data('min')) || 0;
                const currency = $("#slider-range").data('currency') || '';
                let price_range = min_value + '-' + max_value;

                if ($("#price_range").length > 0 && $("#price_range").val()) {
                    price_range = $("#price_range").val().trim();
                }

                let price = price_range.split('-');
                $("#slider-range").slider({
                    range: true,
                    min: min_value,
                    max: max_value,
                    values: price,
                    slide: function(event, ui) {
                        $("#amount").val(currency + ui.values[0] + " - " + currency + ui.values[1]);
                        $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    }
                });
            }

            if ($("#amount").length > 0) {
                const m_currency = $("#slider-range").data('currency') || '';
                $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                    " - " + m_currency + $("#slider-range").slider("values", 1));
            }

            // Quantity controls in modal
            $('.qty-minus').click(function() {
                let input = $(this).closest('.quantity-controls').find('.quantity-input');
                let currentVal = parseInt(input.val());
                if (currentVal > 1) {
                    input.val(currentVal - 1);
                }
            });

            $('.qty-plus').click(function() {
                let input = $(this).closest('.quantity-controls').find('.quantity-input');
                let currentVal = parseInt(input.val());
                let max = parseInt(input.attr('max')) || 1000;
                if (currentVal < max) {
                    input.val(currentVal + 1);
                }
            });

            // Add to cart
            $('.btn-add-to-cart').click(function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                if (form.length) {
                    let submitBtn = $(this);
                    let originalText = submitBtn.html();
                    submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
                    submitBtn.prop('disabled', true);

                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            if (response.status) {
                                swal('Success!', response.msg, 'success');
                            } else {
                                swal('Error', response.msg, 'error');
                            }
                        },
                        error: function() {
                            swal('Error', 'Something went wrong', 'error');
                        },
                        complete: function() {
                            submitBtn.html(originalText);
                            submitBtn.prop('disabled', false);
                        }
                    });
                } else {
                    let btn = $(this);
                    let originalText = btn.html();
                    btn.html('<i class="fas fa-spinner fa-spin"></i> Adding...');
                    btn.prop('disabled', true);

                    $.ajax({
                        url: "{{ url('add-to-cart') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            quantity: 1,
                            pro_id: btn.data('id')
                        },
                        success: function(response) {
                            if (response.status) {
                                swal('Success!', response.msg, 'success');
                            } else {
                                swal('Error', response.msg, 'error');
                            }
                        },
                        error: function() {
                            swal('Error', 'Something went wrong', 'error');
                        },
                        complete: function() {
                            btn.html(originalText);
                            btn.prop('disabled', false);
                        }
                    });
                }
            });

            // Wishlist
            $('.wishlist').click(function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            swal('Success!', 'Added to wishlist', 'success');
                        } else {
                            swal('Info', 'Already in wishlist', 'info');
                        }
                    },
                    error: function() {
                        swal('Error', 'Please login to add to wishlist', 'error');
                    }
                });
            });
        });
    </script>
@endpush
