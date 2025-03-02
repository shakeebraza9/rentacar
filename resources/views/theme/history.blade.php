@extends('theme.layout')

@php
    //dd($product)

@endphp

@section('metatags')
    <title>Cart</title>
    <meta name="description" content="{{$global_d['blog_meta_description'] ?? ''}}">
    <meta name="keywords" content="{{$global_d['blog_keywords'] ?? ''}}">
@endsection
@section('css')

@endsection
@section('content')

    <?php
    //dd($carts);
    ?>
    <main class="main">
        <div>
            <div class="container my-5">
                <h3 class="text-primary mb-4">Booking History</h3>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="car_rental-tab" data-bs-toggle="tab"
                            data-bs-target="#car_rental" type="button" role="tab" aria-controls="car_rental"
                            aria-selected="true">Car Rental</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="experience-tab" data-bs-toggle="tab" data-bs-target="#experience"
                            type="button" role="tab" aria-controls="experience" aria-selected="false">Attraction</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="car_rental" role="tabpanel" aria-labelledby="car_rental-tab">
                        <div class="my-3">
                            <form method="get" accept-charset="utf-8" action="/history">
                                <div class="row gx-2 justify-content-end">
                                    <div class="col-md-auto">
                                        <div class="mb-3">
                                            <select class="form-select" name="payment_status" id="payment-status">
                                                <option value="">All Status</option>
                                                <option value="0" {{ request('payment_status') === '0' ? 'selected' : '' }}>Unpaid</option>
                                                <option value="1" {{ request('payment_status') === '1' ? 'selected' : '' }}>Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-auto">
                                        <input type="submit" class="btn btn-primary" value="Filter">
                                    </div>
                                </div>
                            </form>
                        </div>



                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead >
                                                <tr>
                                                    <th><a href="?sort=id&direction={{ $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc' }}">ID</a></th>
                                                    <th>Pickup Location</th>
                                                    <th>Drop-off Location</th>
                                                    <th>
                                                        <a href="?sort=from_date&direction={{ $sort === 'from_date' && $direction === 'asc' ? 'desc' : 'asc' }}">
                                                            Rental Datetime
                                                        </a>
                                                    </th>
                                                    <th>
                                                        <a href="?sort=to_date&direction={{ $sort === 'to_date' && $direction === 'asc' ? 'desc' : 'asc' }}">
                                                            Drop-off Datetime
                                                        </a>
                                                    </th>
                                                    <th>
                                                        <a href="?sort=payment_status&direction={{ $sort === 'payment_status' && $direction === 'asc' ? 'desc' : 'asc' }}">
                                                            Payment Status
                                                        </a>
                                                    </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->product->pickup_location ?? 'N/A' }}</td>
                                                    <td>{{ $order->product->dropoff_location ?? 'N/A' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->to_date)->format('d M Y, h:i A') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->from_date)->format('d M Y, h:i A') }}</td>
                                                    <td>
                                                        <span class="badge {{ $order->payment_status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $order->payment_status == 1 ? 'Paid' : 'Unpaid' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($order->payment_status == 0)
                                                            <a href="{{ route('checkout', ['order_id' => Crypt::encryptString($order->id)]) }}" class="btn btn-sm btn-warning">
                                                                Pay Now
                                                            </a>
                                                        @else
                                                            <a href="{{ route('order.details', ['id' => Crypt::encryptString($order->id)]) }}" class="btn btn-sm btn-primary">
                                                                View Details
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>


                        <div class="wrap-pagination my-2">
                            <div class="paginator text-center">
                                <small class="text-muted">Page 1 of 1, showing 0 records out of 0 total</small>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="experience" role="tabpanel" aria-labelledby="experience-tab">
                        <div class="my-3">
                            <form method="get" accept-charset="utf-8" action="/customer/users/history">
                                <div class="row gx-2 justify-content-end">
                                    <div class="col-md-auto">
                                        <div class="mb-3"><select class="form-select " name="payment_status_exp"
                                                id="payment-status-exp">
                                                <option value="">All Status</option>
                                                <option value="0">Pending</option>
                                                <option value="1">Paid</option>
                                                <option value="3">Deposit</option>
                                            </select><span class="form-text"></span></div>
                                    </div>
                                    <div class="col-md-auto">
                                        <input type="submit" class="btn btn-primary" value="Filter">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive ">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Attraction Name</th>
                                        <th>Ticket Details</th>
                                        <th>Price</th>
                                        <th>Payment Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
@section('js')



@endsection
