@extends('theme.attractions.layout')

@php

@endphp

@section('metatags')
    <title>{{$global_d['site_title']}}</title>
@endsection

@section('css')



@endsection
@section('content')
<main class="main">
    <div class="container">


        <div class="card">
            <h2 class="mb-4 mt-6">Ticket Details</h2>
            <div class="card-header bg-primary text-white">
                Order #{{ $orderTickets->id }} | Ticket #{{ $ticket->id }}
            </div>
            <div class="card-body">
                <p><strong>Customer Name:</strong> {{ $orderTickets->name }}</p>
                <p><strong>Email:</strong> {{ $orderTickets->email }}</p>
                <p><strong>Phone:</strong> {{ $orderTickets->phone }}</p>
                <p><strong>Country:</strong> {{ $orderTickets->country }}</p>
                <p><strong>Adults:</strong> {{ $orderTickets->adult_quantity }}</p>
                <p><strong>Children:</strong> {{ $orderTickets->child_quantity }}</p>
                <p><strong>Promo Code:</strong> {{ $orderTickets->promo_code ?? 'N/A' }}</p>
                <p><strong>Amount Paid:</strong> RM {{ number_format($orderTickets->amount, 2) }}</p>
                <p><strong>Order Date:</strong> {{ $orderTickets->date }}</p>

                <hr>

                <h5>Ticket Details</h5>
                <p><strong>Title:</strong> {{ $ticket->title }}</p>
                <p><strong>Description:</strong> {{ $ticket->description }}</p>
                <p><strong>Discount Price:</strong> RM {{ $ticket->discount_price ?? '0.00' }}</p>
                <p><strong>Price:</strong> RM {{ number_format($ticket->selling_price, 2) }}</p>
                <p><strong>Ticket Type:</strong> {{ $ticket->ticket_type ?? 'N/A' }}</p>

                <p>
                    <strong>Payment Status:</strong>
                    <span class="badge {{ $orderTickets->payment_status == 1 ? 'bg-success' : 'bg-danger' }}">
                        {{ $orderTickets->payment_status == 1 ? 'Paid' : 'Pending' }}
                    </span>
                </p>
            </div>

            <div class="card-footer">
                @if($orderTickets->payment_status == 0)
                    <a href="{{ route('place.checkout', ['order_id' => encrypt($orderTickets->id)]) }}" class="btn btn-sm btn-warning">
                        Pay Now
                    </a>

                @endif
                <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')

@endsection
