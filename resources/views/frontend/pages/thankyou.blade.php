@extends('frontend.layouts.master')
@section('title', 'Order Confirmation')

@section('main-content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Message -->
            <div class="card shadow-sm border-0 rounded-lg mb-4">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 70px;"></i>
                    </div>
                    <h2 class="mb-3">Thank You for Your Order!</h2>
                    <p class="lead mb-4">Your order has been successfully placed.</p>
                    
                    <!-- Order Number - Prominently Displayed -->
                    <div class="bg-light p-4 rounded mb-4">
                        <h5 class="text-muted mb-2">Order Number</h5>
                        <h3 class="text-primary mb-0 font-weight-bold">{{ $order->order_number }}</h3>
                    </div>
                    
                    <p class="mb-0">
                        <i class="fas fa-envelope me-2"></i> 
                        A confirmation email has been sent to <strong>{{ $order->email }}</strong>
                    </p>
                </div>
            </div>

            <!-- Order Details -->
            <div class="card shadow-sm border-0 rounded-lg mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h6 class="text-muted mb-2">Order Information</h6>
                            <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y H:i') }}</p>
                            <p class="mb-1"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                            <p class="mb-1"><strong>Payment Status:</strong> 
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                            <p class="mb-0"><strong>Order Status:</strong> 
                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Shipping Address</h6>
                            <p class="mb-0">{{ $order->first_name }} {{ $order->last_name }}</p>
                            <p class="mb-0">{{ $order->address1 }}</p>
                            @if($order->address2)
                                <p class="mb-0">{{ $order->address2 }}</p>
                            @endif
                            <p class="mb-0">{{ $order->post_code }}, {{ $order->country }}</p>
                            <p class="mb-0">Phone: {{ $order->phone }}</p>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->cart as $item)
                                <tr>
                                    <td>
                                        {{ $item->product->title ?? 'Product' }}
                                        @if($item->product && $item->product->slug)
                                            <br>
                                            <small class="text-muted">{{ $item->product->slug }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price ?? 0, 2) }}</td>
                                    <td class="text-end">${{ number_format(($item->price ?? 0) * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">${{ number_format($order->sub_total, 2) }}</td>
                                </tr>
                                @if($order->shipping_id)
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                    <td class="text-end">${{ number_format($order->shipping_price ?? 0, 2) }}</td>
                                </tr>
                                @endif
                                @if($order->coupon > 0)
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Coupon Discount:</strong></td>
                                    <td class="text-end text-success">-${{ number_format($order->coupon, 2) }}</td>
                                </tr>
                                @endif
                                <tr class="bg-light">
                                    <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                    <td class="text-end"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-primary me-2">
                    <i class="fas fa-home me-2"></i> Continue Shopping
                </a>
                {{-- <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-user me-2"></i> View My Orders
                </a> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
    }
    .badge {
        padding: 8px 12px;
        font-weight: 500;
    }
    .table > :not(caption) > * > * {
        padding: 12px;
    }
    @media (max-width: 768px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        .card-body {
            padding: 1.5rem;
        }
    }
</style>
@endpush