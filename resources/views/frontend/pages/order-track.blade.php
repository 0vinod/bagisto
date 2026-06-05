@extends('frontend.layouts.master')

@section('title', 'Moonzio || Order Track Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Order Track</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
 

    <section class="tracking_box_area section_gap py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="tracking-card p-4 p-md-5">
                        <div class="tracking-header text-center">
                            <h4><i class="ti-search me-2"></i> Track Your Order</h4>
                            <p class="text-muted mt-2">Enter your Order ID to get real-time updates on your delivery status</p>
                        </div>

                        <form class="tracking_form" action="#" method="post" id="trackingForm">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control form-control-modern" 
                                               name="order_number"
                                               id="order_number"
                                               placeholder="e.g., ORD-12345678" 
                                               value="{{ old('order_number') }}"
                                               autocomplete="off">
                                        <button type="submit" class="btn btn-track ms-2" id="trackBtn">
                                            <i class="ti-location-pin"></i> Track Order
                                        </button>
                                    </div>
                                    <small class="text-muted mt-2 d-block">
                                        <i class="ti-info-alt"></i> Enter your 8-12 digit order number found on your receipt or email
                                    </small>
                                </div>
                            </div>
                        </form>

                        @if (session('error'))
                            <div class="alert alert-danger alert-modern mt-4" role="alert" id="errorAlert">
                                <i class="ti-alert me-2"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if (isset($order) && $order)
                            @php
                                $statusMessages = [
                                    'new' => ['message' => 'Your order has been confirmed and is awaiting processed.', 'icon' => 'ti-check-box'],
                                    'process' => ['message' => 'Your order is being processed and will be shipped soon.', 'icon' => 'ti-settings'],
                                    'delivered' => ['message' => 'Your order has been delivered successfully. Enjoy your purchase!', 'icon' => 'ti-home'],
                                    'cancel' => ['message' => 'Your order has been cancelled. Contact support for more details.', 'icon' => 'ti-close'],
                                ];
                                $currentStatus = $order->status;
                                $statusInfo = $statusMessages[$currentStatus] ?? ['message' => 'Order status unknown.', 'icon' => 'ti-info-alt'];
                                $alertClass = $currentStatus == 'cancel' ? 'danger' : ($currentStatus == 'delivered' ? 'success' : 'info');
                                
                                // Get payment status class
                                $paymentStatusClass = $order->payment_status == 'completed' ? 'payment-completed' : ($order->payment_status == 'failed' ? 'payment-failed' : 'payment-pending');
                            @endphp

                            <!-- Order Summary Card -->
                            <div class="order-summary mt-4">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h5 class="mb-3"><i class="ti-shopping-cart"></i> Order Details</h5>
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Order ID:</span>
                                            <span class="order-summary-value fw-bold">{{ $order->order_number }}</span>
                                        </div>
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Order Date:</span>
                                            <span class="order-summary-value">{{ $order->created_at ? $order->created_at->format('F d, Y h:i A') : 'N/A' }}</span>
                                        </div>
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Last Update:</span>
                                            <span class="order-summary-value">{{ $order->updated_at ? $order->updated_at->format('F d, Y h:i A') : 'N/A' }}</span>
                                        </div>
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Quantity:</span>
                                            <span class="order-summary-value">{{ $order->quantity }} item(s)</span>
                                        </div>
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Sub Total:</span>
                                            <span class="order-summary-value">Rs {{ number_format($order->sub_total ?? 0, 2) }}</span>
                                        </div>
                                        @if($order->coupon)
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Coupon Applied:</span>
                                            <span class="order-summary-value text-success">{{ $order->coupon }}</span>
                                        </div>
                                        @endif
                                        @if($order->shipping_id)
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Shipping Cost:</span>
                                            <span class="order-summary-value">Rs {{ number_format($order->shipping_cost ?? 0, 2) }}</span>
                                        </div>
                                        @endif
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Total Amount:</span>
                                            <span class="order-summary-value h5 text-primary mb-0">Rs {{ number_format($order->total_amount ?? 0, 2) }}</span>
                                        </div>
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Payment Method:</span>
                                            <span class="order-summary-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</span>
                                        </div>
                                        <div class="order-summary-item">
                                            <span class="order-summary-label">Payment Status:</span>
                                            <span class="order-summary-value">
                                                <span class="status-badge {{ $paymentStatusClass }}">
                                                    <i class="ti-{{ $order->payment_status == 'completed' ? 'check' : ($order->payment_status == 'failed' ? 'close' : 'timer') }}"></i>
                                                    {{ ucfirst($order->payment_status ?? 'pending') }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-md-end">
                                        <div class="status-badge status-{{ $currentStatus == 'process' ? 'process' : $currentStatus }} mb-3">
                                            <i class="{{ $statusInfo['icon'] }} me-1"></i>
                                            {{ ucfirst($currentStatus) }}
                                        </div>
                                        <p class="text-muted small">{{ $statusInfo['message'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information Card -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="info-card">
                                        <i class="ti-user"></i>
                                        <h6 class="mb-2">Customer Information</h6>
                                        <p class="mb-1"><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                                        <p class="mb-1"><i class="ti-email"></i> {{ $order->email }}</p>
                                        <p class="mb-0"><i class="ti-mobile"></i> {{ $order->phone }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                        <i class="ti-location-pin"></i>
                                        <h6 class="mb-2">Shipping Address</h6>
                                        <p class="mb-1">{{ $order->address1 }}</p>
                                        @if($order->address2)<p class="mb-1">{{ $order->address2 }}</p>@endif
                                        <p class="mb-1">{{ $order->city ?? 'N/A' }}, {{ $order->state_id ?? 'N/A' }} - {{ $order->post_code }}</p>
                                        <p class="mb-0">{{ $order->country }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Information -->
                            @if($order->product_id)
                            <div class="mt-4">
                                <h5 class="mb-3"><i class="ti-package"></i> Product Details</h5>
                                @php
                                    $products = is_array($order->product_id) ? $order->product_id : json_decode($order->product_id, true);
                                @endphp
                                @if(is_array($products))
                                    @foreach($products as $product)
                                    <div class="product-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $product['name'] ?? 'Product' }}</strong>
                                            <div class="text-muted small">SKU: {{ $product['sku'] ?? 'N/A' }}</div>
                                        </div>
                                        <div class="text-end">
                                            <div>${{ number_format($product['price'] ?? 0, 2) }} × {{ $product['quantity'] ?? 1 }}</div>
                                            <small class="text-muted">Total: ${{ number_format(($product['price'] ?? 0) * ($product['quantity'] ?? 1), 2) }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="product-item">
                                        <strong>Product ID: {{ $order->product_id }}</strong>
                                    </div>
                                @endif
                            </div>
                            @endif

                            @if ($order->status != 'cancel')
                                <!-- Enhanced Timeline -->
                                <div class="timeline mt-4">
                                    @php
                                        $stages = [
                                            'new' => ['label' => 'Order Placed', 'icon' => 'ti-shopping-cart-full', 'date' => $order->created_at],
                                            'process' => ['label' => 'Processing', 'icon' => 'ti-settings', 'date' => $order->updated_at],
                                            'delivered' => ['label' => 'Delivered', 'icon' => 'ti-home', 'date' => $order->delivered_date ?? null],
                                        ];
                                        $currentStageIndex = array_search($currentStatus, array_keys($stages));
                                    @endphp

                                    @foreach ($stages as $key => $stage)
                                        @php
                                            $isCompleted = array_search($key, array_keys($stages)) <= $currentStageIndex;
                                            $isActive = $key == $currentStatus;
                                        @endphp
                                        <div class="timeline-step {{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}">
                                            <div class="timeline-icon">
                                                <i class="{{ $stage['icon'] }}"></i>
                                            </div>
                                            <div class="timeline-label">{{ $stage['label'] }}</div>
                                            <div class="timeline-date">
                                                @if ($stage['date'])
                                                    {{ $stage['date']->format('M d, h:i A') }}
                                                @elseif ($isActive)
                                                    In Progress
                                                @else
                                                    Pending
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Cancelled Order View -->
                                <div class="text-center mt-4 p-4 bg-light rounded-4">
                                    <div class="timeline-icon cancelled mx-auto mb-3" style="width: 80px; height: 80px; background: #ffebee; border-color: #d32f2f;">
                                        <i class="ti-close" style="font-size: 36px; color: #d32f2f;"></i>
                                    </div>
                                    <h5 class="text-danger">Order Cancelled</h5>
                                    <p class="text-muted">This order has been cancelled. For any questions, please contact our support team.</p>
                                    <a href="{{ route('contact') }}" class="btn btn-outline-danger rounded-pill px-4 mt-2">
                                        <i class="ti-email"></i> Contact Support
                                    </a>
                                </div>
                            @endif

                            <!-- Additional Help Section -->
                            <div class="text-center mt-4 pt-3">
                                <hr>
                                <p class="text-muted small">
                                    <i class="ti-help-alt"></i> Need help? 
                                    <a href="{{ route('contact') }}" class="text-decoration-none">Contact our support team</a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('trackingForm')?.addEventListener('submit', function(e) {
            const orderInput = document.getElementById('order_number');
            if (orderInput && !orderInput.value.trim()) {
                e.preventDefault();
                orderInput.classList.add('shake');
                orderInput.style.borderColor = '#dc3545';
                setTimeout(() => {
                    orderInput.classList.remove('shake');
                }, 500);
                
                let errorDiv = document.querySelector('.alert-danger');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-danger alert-modern mt-3';
                    errorDiv.innerHTML = '<i class="ti-alert me-2"></i> Please enter your order number';
                    document.querySelector('.tracking_form .row').after(errorDiv);
                    setTimeout(() => errorDiv.remove(), 3000);
                }
            }
        });

        document.getElementById('order_number')?.addEventListener('input', function() {
            this.classList.remove('shake');
            this.style.borderColor = '#e0e0e0';
        });

        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.transition = 'opacity 0.5s';
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500);
            }, 5000);
        }

        const trackBtn = document.getElementById('trackBtn');
        const form = document.getElementById('trackingForm');
        
        form?.addEventListener('submit', function() {
            if (trackBtn && document.getElementById('order_number')?.value.trim()) {
                const originalText = trackBtn.innerHTML;
                trackBtn.innerHTML = '<i class="ti-reload"></i> Tracking...';
                trackBtn.disabled = true;
                setTimeout(() => {
                    trackBtn.innerHTML = originalText;
                    trackBtn.disabled = false;
                }, 3000);
            }
        });
    </script>
@endsection