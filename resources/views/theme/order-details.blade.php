@extends('theme.layout')

@section('metatags')
    <title>Order Details</title>
    <meta name="description" content="{{ $global_d['blog_meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $global_d['blog_keywords'] ?? '' }}">
@endsection

@section('css')
<style>
    .product-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
        max-height: 250px;
    }
    .card-custom {
        transition: transform 0.3s ease-in-out;
    }
    .card-custom:hover {
        transform: scale(1.02);
    }
    .order-table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
</style>
@endsection

@section('content')
<main class="main">
    <div class="container my-5">
        <h2 class="text-center mb-4">Order Details</h2>

        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        @if(!$order)
            <div class="alert alert-warning text-center">Order not found.</div>
        @else
            <div class="row">
                <!-- Product Details Section -->
                <div class="col-md-6">
                    <div class="card shadow-lg border-0 rounded-3 card-custom">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">Product Details</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset($order->product->get_thumbnail->path) ?? asset('images/default-product.jpg') }}"
                                 alt="Product Image" class="product-image mb-3">
                            <h5 class="fw-bold">{{ $order->product->title ?? 'N/A' }}</h5>
                            <p><strong>Pickup Location:</strong> {{ $order->product->pickup_location ?? 'N/A' }}</p>
                            <p><strong>Drop-off Location:</strong> {{ $order->product->dropoff_location ?? 'N/A' }}</p>
                            <p class="fw-bold text-success fs-5">RM {{ number_format($order->product->selling_price ?? 0, 2) }}</p>
                        </div>
                    </div>


                    @php
                        $addons = json_decode($order->selected_addons, true);
                    @endphp
                    @if(!empty($addons))
                    <div class="card shadow-lg border-0 rounded-3 mt-4 card-custom">
                        <div class="card-header bg-info text-white text-center">
                            <h5 class="mb-0">Selected Add-ons</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Add-on Name</th>
                                        <th>Quantity</th>
                                        <th>Price (RM)</th>
                                        <th>Total (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($addons as $addon)
                                        <tr>
                                            <td>{{ $addon['name'] ?? 'N/A' }}</td>
                                            <td>{{ $addon['quantity'] ?? '0' }}</td>
                                            <td>{{ number_format($addon['price'] ?? 0, 2) }}</td>
                                            <td>{{ number_format($addon['total'] ?? 0, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Order Details Section -->
                <div class="col-md-6">
                    <div class="card shadow-lg border-0 rounded-3 card-custom">
                        <div class="card-header bg-success text-white text-center">
                            <h5 class="mb-0">Order Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table order-table">
                                <tbody>
                                    <tr>
                                        <td><strong>Order ID:</strong> {{ $order->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Buyer Name:</strong> {{ $order->buyer_name }}</td>
                                        <td><strong>Buyer Email:</strong> {{ $order->buyer_email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong> {{ $order->buyer_phone_number }}</td>
                                        <td><strong>Country:</strong> {{ $order->buyer_country_of_origin }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Rental Date:</strong> {{ \Carbon\Carbon::parse($order->from_date)->format('d M Y, h:i A') }}</td>
                                        <td><strong>Return Date:</strong> {{ \Carbon\Carbon::parse($order->to_date)->format('d M Y, h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Passport:</strong> {{ $order->passport ?? 'N/A' }}</td>
                                        <td><strong>License:</strong> {{ $order->license ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Driver Name:</strong> {{ $order->driver_name ?? 'N/A' }}</td>
                                        <td><strong>Driver License:</strong> {{ $order->driver_license_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Flight No:</strong> {{ $order->flight_no ?? 'N/A' }}</td>
                                        <td><strong>Note:</strong> {{ $order->note ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Payment Status:</strong>
                                            <span class="badge {{ $order->payment_status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $order->payment_status == 1 ? 'Paid' : 'Unpaid' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>Order Status:</strong>
                                            <span class="badge {{ $order->status == 'confirmed' ? 'bg-primary' : ($order->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Amount:</strong> RM {{ number_format($order->amount, 2) }}</td>
                                        <td><strong>Extra Amount:</strong> RM {{ number_format($order->extra_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            @if($order->payment_status == 0)
                                <a href="{{ route('checkout', ['order_id' => Crypt::encryptString($order->id)]) }}"
                                   class="btn btn-warning w-100 mt-3">
                                    <i class="bi bi-wallet2 me-2"></i> Pay Now
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</main>
@endsection

@section('js')
@endsection
