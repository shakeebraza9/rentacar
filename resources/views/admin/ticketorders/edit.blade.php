@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Left Side - Order Details -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    @php
                        // Fetch correct ticket variations dynamically
                        $adultVariation = $ticket->variations->where('type', 'adult')->first();
                        $childVariation = $ticket->variations->where('type', 'child')->first();

                        $adultPrice = $adultVariation ? $adultVariation->price : 0;
                        $childPrice = $childVariation ? $childVariation->price : 0;

                        $totalAdult = $order->adult_quantity * $adultPrice;
                        $totalChild = $order->child_quantity * $childPrice;
                        $discount = getset('discount_value_Ticket');

                        $grandTotal = $totalAdult + $totalChild + ($order->addons ? array_sum(array_column(json_decode($order->addons, true), 'price')) : 0) - $discount;
                    @endphp
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Order ID:</th>
                                <td>#{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Order Date:</th>
                                <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Adult Tickets:</th>
                                <td>{{ $order->adult_quantity }} x RM {{ number_format($adultPrice, 2) }} = <strong>RM {{ number_format($totalAdult, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Child Tickets:</th>
                                <td>{{ $order->child_quantity }} x RM {{ number_format($childPrice, 2) }} = <strong>RM {{ number_format($totalChild, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Discount Applied:</th>
                                <td class="text-danger">- RM {{ number_format($discount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Payment Status:</th>
                                <td>
                                    <span class="{{ $order->payment_status ? 'text-success' : 'text-danger' }}">
                                        {{ $order->payment_status ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Promo Code Used:</th>
                                <td>{{ $order->promo_code ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add-ons Details -->
            @if (!empty($order->addons))
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h5>Selected Add-ons</h5>
                </div>
                <div class="card-body">
                    @php
                        $addons = json_decode($order->addons, true);
                        $totalAddons = 0;
                    @endphp
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Addon Name</th>
                                <th>Price (RM)</th>
                                <th>Quantity</th>
                                <th>Total (RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addons as $addon)
                                @php
                                    $subtotal = $addon['price'] * $addon['quantity'];
                                    $totalAddons += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $addon['name'] }}</td>
                                    <td>RM {{ number_format($addon['price'], 2) }}</td>
                                    <td>{{ $addon['quantity'] }}</td>
                                    <td><strong>RM {{ number_format($subtotal, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-warning">
                                <th colspan="3" class="text-end">Total Add-ons</th>
                                <th><strong>RM {{ number_format($totalAddons, 2) }}</strong></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif

            <!-- Grand Total -->
            <div class="card mt-3">
                <div class="card-header bg-dark text-white">
                    <h5>Final Amount</h5>
                </div>
                <div class="card-body text-center">
                    <h4 class="text-primary">Grand Total: <strong>RM {{ number_format($grandTotal, 2) }}</strong></h4>

                    <!-- Show buttons if payment is completed -->
                    @if ($order->payment_status == 1)
                        <div class="mt-3">
                            <a href="{{ route('admin.ordersticket.sendConfirmation', $order->id) }}" class="btn btn-success">
                                <i class="fas fa-envelope"></i> Send Confirmation Email
                            </a>
                            <a href="{{ route('admin.ordersticket.downloadInvoice', $order->id) }}" class="btn btn-primary">
                                <i class="fas fa-file-invoice"></i> Download Invoice
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Side - Edit Order Form -->
        <div class="col-md-6">
            <!-- Ticket Variations -->
            @if ($ticket->variations->isNotEmpty())
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h5>Ticket Variations</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Price (RM)</th>
                                    <th>Quantity Available</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticket->variations as $variation)
                                    <tr>
                                        <td>{{ ucfirst($variation->type) }}</td>
                                        <td>RM {{ number_format($variation->price, 2) }}</td>
                                        <td>{{ $variation->quantity }}</td>
                                        <td>{{ date('d-m-Y', strtotime($variation->from_date)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($variation->to_date)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="card mt-3">
                <div class="card-header bg-warning">
                    <h5>Edit Order</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ticketorders.update', Crypt::encryptString($order->id)) }}" method="POST">
                        @csrf


                        <!-- User Details -->
                        <h6 class="text-primary">User Details</h6>
                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" value="{{ $order->name }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ $order->email }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" value="{{ $order->phone }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Country</label>
                            <input type="text" name="country" value="{{ $order->country }}" class="form-control" required>
                        </div>

                        <!-- Ticket Quantity -->


                        <!-- Payment Status -->
                        <div class="mb-3">
                            <label>Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="1" {{ $order->payment_status == 1 ? 'selected' : '' }}>Paid</option>
                                <option value="0" {{ $order->payment_status == 0 ? 'selected' : '' }}>Unpaid</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Update Order</button>
                    </form>
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-dark text-white">
                        <h5>Attraction Details</h5>
                    </div>
                    <div class="card-body text-center">
                        @if ($attraction)
                            <!-- Attraction Image -->
                            <div class="mb-3">
                                <img src="{{ asset($attraction->get_thumbnail->path) }}"
                                     alt="{{ $attraction->title }}"
                                     class="img-fluid rounded shadow-lg border"
                                     style="max-height: 300px; max-width: 100%;">
                            </div>

                            <!-- Attraction Title -->
                            <h3 class="text-primary fw-bold">{{ $attraction->title }}</h3>
                        @else
                            <p class="text-danger">No attraction details found.</p>
                        @endif
                    </div>
                </div>

                <!-- Attraction Ticket Details -->
                @if ($ticket)
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h5>Attraction Ticket Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Ticket Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center fw-bold">{{ $ticket->title }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Add-ons Section -->
                        @if (!empty($ticket->add_ons))
                        <div class="mt-4">
                            <h5 class="text-primary fw-bold">Included Add-ons</h5>
                            @php
                                $addons = json_decode($ticket->add_ons, true);
                            @endphp
                            <table class="table table-striped">
                                <thead class="table-warning">
                                    <tr>
                                        <th>Add-on Name</th>
                                        <th>Description</th>
                                        <th>Price (RM)</th>
                                        <th>Max Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($addons as $addon)
                                    <tr>
                                        <td>{{ $addon['name'] }}</td>
                                        <td>{{ $addon['description'] }}</td>
                                        <td>RM {{ number_format($addon['price'], 2) }}</td>
                                        <td>{{ $addon['quantity'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
                @endif




            </div>
        </div>

    </div>
</div>
@endsection




    @section('js')


    @endsection
