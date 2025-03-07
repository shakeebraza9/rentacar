<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; background: #fff; border-radius: 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); }
        .invoice-box table { width: 100%; border-collapse: collapse; }
        .invoice-box table td { padding: 10px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 35px; font-weight: bold; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 20px; }
        .invoice-box table tr.heading td { background: #007BFF; color: white; font-weight: bold; text-transform: uppercase; }
        .invoice-box table tr.item td { border-bottom: 1px solid #ddd; }
        .invoice-box table tr.total td { font-weight: bold; font-size: 18px; border-top: 2px solid #007BFF; }
        .logo { max-width: 120px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .paid { color: green; font-weight: bold; }
        .unpaid { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <!-- Header Section -->
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path(getset('logo')) }}" alt="Company Logo" class="logo">
                            </td>
                            <td class="text-right">
                                <h2>Invoice</h2>
                                <strong>Order #: </strong> #{{ $order->id }}<br>
                                <strong>Date: </strong> {{ date('d-m-Y', strtotime($order->created_at)) }}<br>
                                <strong>Status: </strong>
                                <span class="{{ $order->payment_status ? 'paid' : 'unpaid' }}">
                                    {{ $order->payment_status ? 'Paid' : 'Unpaid' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Customer & Attraction Details -->
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <!-- Customer Details -->
                            <td>
                                <h4>Customer Details</h4>
                                <strong>Name:</strong> {{ $order->name }}<br>
                                <strong>Email:</strong> {{ $order->email }}<br>
                                <strong>Phone:</strong> {{ $order->phone }}<br>
                                <strong>Country:</strong> {{ $order->country }}
                            </td>

                            <!-- Attraction Details -->
                            <td class="text-right">
                                <h4>Attraction</h4>
                                <strong>{{ $attraction->title ?? 'N/A' }}</strong><br>
                                <img src="{{ public_path($attraction->get_thumbnail->path) }}" class="img-fluid rounded shadow" style="max-width: 120px;" alt="Attraction Image">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Ticket Details -->
            <tr class="heading">
                <td>Ticket Details</td>
                <td class="text-right">Amount (RM)</td>
            </tr>

            <!-- ✅ Fetch Adult & Child Prices from Variations -->
            @php
                $adultVariation = $ticket->variations->where('type', 'adult')->first();
                $childVariation = $ticket->variations->where('type', 'child')->first();
                $adultPrice = $adultVariation ? $adultVariation->price : 0;
                $childPrice = $childVariation ? $childVariation->price : 0;
            @endphp

            <tr class="item">
                <td>Adult Tickets ({{ $order->adult_quantity }})</td>
                <td class="text-right">RM {{ number_format($order->adult_quantity * $adultPrice, 2) }}</td>
            </tr>
            <tr class="item">
                <td>Child Tickets ({{ $order->child_quantity }})</td>
                <td class="text-right">RM {{ number_format($order->child_quantity * $childPrice, 2) }}</td>
            </tr>

            <!-- Add-ons Section -->
            @if (!empty($addons))
                <tr class="heading">
                    <td>Add-ons</td>
                    <td class="text-right">Amount (RM)</td>
                </tr>
                @foreach ($addons as $addon)
                    <tr class="item">
                        <td>{{ $addon['name'] }} ({{ $addon['quantity'] }})</td>
                        <td class="text-right">RM {{ number_format($addon['price'] * $addon['quantity'], 2) }}</td>
                    </tr>
                @endforeach
            @endif

            <!-- Discount -->
            <tr class="item">
                <td>Discount Applied</td>
                <td class="text-danger text-right">- RM {{ number_format(getset('discount_value_Ticket'), 2) }}</td>
            </tr>

            <!-- Grand Total -->
            <tr class="total">
                <td>Grand Total</td>
                @php
                    $grandTotal = ($order->adult_quantity * $adultPrice) +
                                  ($order->child_quantity * $childPrice) +
                                  $totalAddons - getset('discount_value_Ticket');
                @endphp
                <td class="text-right"><strong>RM {{ number_format($grandTotal, 2) }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
