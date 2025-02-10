@extends('theme.layout')

@section('content')
<!-- Custom CSS Styles for the Blue-Green Themed Checkout Form -->
<style>
    /* Blue-green themed card styling with rounded corners and shadow */
    .checkout-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        background: #fff;
    }
    /* Header with a blue-green gradient */
    .checkout-card-header {
        background: linear-gradient(135deg, #2196F3, #4CAF50);
        padding: 1.5rem;
    }
    .checkout-card-header h4 {
        margin: 0;
        font-weight: 600;
        color: #fff;
    }
    /* Custom focus effect for input fields using blue tones */
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        border-color: #2196F3;
    }
    /* Blue-green gradient button styling */
    .btn-custom {
        background: linear-gradient(135deg, #2196F3, #4CAF50);
        border: none;
        transition: background 0.3s ease;
    }
    .btn-custom:hover {
        background: linear-gradient(135deg, #4CAF50, #2196F3);
    }
    /* Payment toggle button styles */
    .btn-group .btn-check:checked + .btn {
        background-color: #2196F3;
        border-color: #2196F3;
        color: #fff;
    }
    .btn-group .btn {
        transition: background-color 0.3s, color 0.3s;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card checkout-card">
                <div class="checkout-card-header text-center">
                    <h4>Checkout</h4>
                </div>
                <div class="card-body p-4">

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('process.payment') }}" method="POST">
                        @csrf

                        {{-- Name Field --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="Enter your full name"
                                   required>
                        </div>

                        {{-- Email Field --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   placeholder="Enter your email address"
                                   required>
                        </div>

                        {{-- Phone Number Field --}}
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text"
                                   name="phone_number"
                                   id="phone_number"
                                   class="form-control"
                                   placeholder="Enter your phone number"
                                   required>
                        </div>

                        {{-- Payment Method Toggle Switcher --}}
                        <div class="mb-4">
                            <label class="form-label d-block">Select Payment Method</label>
                            <div class="btn-group d-flex" role="group" aria-label="Payment Method Toggle">
                                <!-- PayPal option -->
                                <input type="radio" class="btn-check"
                                       name="payment_method"
                                       id="paypal"
                                       value="paypal"
                                       autocomplete="off"
                                       checked
                                       required>
                                <label class="btn btn-outline-primary flex-fill" for="paypal">PayPal</label>

                                <!-- Toyyibpay option -->
                                <input type="radio" class="btn-check"
                                       name="payment_method"
                                       id="toyyibpay"
                                       value="toyyibpay"
                                       autocomplete="off"
                                       required>
                                <label class="btn btn-outline-primary flex-fill" for="toyyibpay">Toyyibpay</label>
                            </div>
                        </div>

                        <button type="submit" class="btn  btn-lg w-100 text-white">
                            <i class="bi bi-lock-fill me-2"></i> Pay Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
