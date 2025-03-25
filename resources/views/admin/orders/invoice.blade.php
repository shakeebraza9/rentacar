<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        .invoice-header {
            text-align: center;
            padding: 20px;
            background-color: #6b0909;
            color: white;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo-container img {
            width: 80px;
            height: auto;
        }
        .invoice-header h1 {
            margin: 5px 0;
            font-size: 22px;
        }
        .invoice-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .invoice-details th, .invoice-details td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .invoice-details th {
            background-color: #6b0909;
            color: white;
        }
        .total-amount {
            text-align: right;
            margin-top: 15px;
            background-color: #6b0909;
            color: white;
            padding: 8px 15px;
            font-weight: bold;
        }
        .status-check {
            color: #6b0909;
            font-size: 12px; /* Reduced font size */
            font-weight: bold;
            margin-top: 10px;
        }
        .car-image {
            width: 120px; /* Reduced image size */
            height: auto;
            border: 1px solid #ddd;
            padding: 3px;
            background-color: #f9f9f9;
        }
        h2, h3 {
            color: #6b0909;
            font-size: 14px; /* Reduced section heading font size */
        }
        .company-name {
            text-align: center;
            font-size: 16px; /* Slightly larger font for company name */
            margin-top: 20px;
            font-weight: bold;
            color: #6b0909;
        }
        .cheesy-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
            color: #ff6600;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="logo-container" style="height: 50px;
  width: auto;
  max-width: 150px;
  object-fit: contain;">
        <img src="https://mrholidays.phpnode.net/filemanager/67af8dab6232c.png" alt="Company Logo" />
    </div>
    <div class="invoice-header">
        <h1>Invoice #{{ $order->id }}</h1>
        <p>Buyer: {{ $order->buyer_name }}</p>
        <p>Email: {{ $order->buyer_email }}</p>
        <p>Phone: {{ $order->buyer_phone_number }}</p>
        <p>Date: {{ date('d-m-Y h:i A', strtotime($order->from_date)) }} to {{ date('d-m-Y h:i A', strtotime($order->to_date)) }}</p>
    </div>

    <!-- Car Rental Period Section -->
    <h3>Car Rental Period</h3>
    <p>From: {{ date('d-m-Y h:i A', strtotime($order->from_date)) }} <strong>to</strong> {{ date('d-m-Y h:i A', strtotime($order->to_date)) }}</p>

    <!-- Pickup and Dropoff Locations Section -->
    <h3>Pickup and Dropoff Locations</h3>
    <p><strong>Pickup Location:</strong> {{ $product->pickup_location }}</p>
    <p><strong>Dropoff Location:</strong> {{ $product->dropoff_location }}</p>

    <!-- Car Details Section -->
    <h2>Car Details</h2>
    <table class="invoice-details">
        <thead>
            <tr>
                <th>Car Image</th>
                <th>Car Model</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img src="{{ $image }}" alt="Car Image" class="car-image"></td>
                <td>{{ $product->title }}</td> <!-- Displaying car model name -->
            </tr>
        </tbody>
    </table>

    <!-- Payment and Deposit Status Section -->
    <h3>Payment and Deposit Status</h3>
    <table class="invoice-details">
        <thead>
            <tr>
                <th>Payment Status</th>
                @if($order->deposit_status == 1)
                <th>Deposit Status</th>
                @endif
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if($order->payment_status == 1)
                        Full Payment Made
                    @else
                        Deposit Paid
                    @endif
                </td>
                @if($order->deposit_status == 1)
                <td>Paid</td>
                @endif
                <td>RM {{ $order->amount }}</td>
                <td>{{ $order->status }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Status Check Section -->
    <div class="status-check">
        @if($order->payment_status == 0)
            <p>&#10004; Payment Pending</p>
        @elseif($order->payment_status == 1)
            <p>&#10004; Full Payment Made</p>
        @endif

        <!-- Show deposit status only if deposit is paid -->
        @if($order->deposit_status == 1)
            <p>&#10004; Deposit Paid</p>
        @elseif($order->deposit_status == 0 && $order->payment_status == 1)
            <p>&#10004; Deposit Pending</p>
        @endif
    </div>

    <!-- Total Amount Section -->
    <div class="total-amount">
        <p>Total Amount: RM {{ $order->amount }}</p>
    </div>

    <!-- Company Name Section -->
    <div class="company-name">
        <p>Thank you for choosing <strong>{{ getset('site_title') }}</strong> for your car rental needs!</p>
    </div>



</body>
</html>
