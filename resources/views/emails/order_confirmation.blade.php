<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">

    <table width="100%" style="max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 10px;">
        <!-- Header -->
        <tr>
            <td align="center">
                <img src="{{ public_path(getset('logo')) }}" alt="Company Logo" width="150">
                <h2>Order Confirmation</h2>
                <p>Order #: {{ $order->id }}</p>
            </td>
        </tr>

        <!-- Customer Details -->
        <tr>
            <td>
                <h4>Customer Details</h4>
                <p><strong>Name:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Country:</strong> {{ $order->country }}</p>
            </td>
        </tr>

        <!-- Ticket Details -->
        <tr>
            <td>
                <h4>Ticket Details</h4>
                <p><strong>Attraction:</strong> {{ $attraction->title }}</p>
                <p><strong>Adult Tickets:</strong> {{ $order->adult_quantity }} x RM {{ number_format($ticket->variations->where('type', 'adult')->first()->price ?? 0, 2) }}</p>
                <p><strong>Child Tickets:</strong> {{ $order->child_quantity }} x RM {{ number_format($ticket->variations->where('type', 'child')->first()->price ?? 0, 2) }}</p>
            </td>
        </tr>

        <!-- Add-ons -->
        @if (!empty($addons))
        <tr>
            <td>
                <h4>Selected Add-ons</h4>
                <ul>
                    @foreach ($addons as $addon)
                        <li>{{ $addon['name'] }} ({{ $addon['quantity'] }}) - RM {{ number_format($addon['price'] * $addon['quantity'], 2) }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endif

        <!-- Total -->
        <tr>
            <td>
                <h4>Total Amount</h4>
                <p><strong>Grand Total:</strong> RM {{ number_format($order->amount, 2) }}</p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center">
                <p>Thank you for booking with us!</p>
                <p>For any queries, contact <a href="mailto:{{ getset('email_address') }}">{{ getset('email_address') }}</a></p>
            </td>
        </tr>
    </table>

</body>
</html>
