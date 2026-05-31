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

@section('title', 'Moonzio || PRODUCT DETAIL')

@section('main-content')
    <style>
        .blink-text {
            animation: blink 3s linear infinite;
        }

        @keyframes blink {
            50% {
                opacity: 5;
            }
        }
    </style>

   
   
 

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
