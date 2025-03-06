@extends('theme.attractions.layout')

@php

@endphp

@section('metatags')
    <title>{{$global_d['site_title']}}</title>
@endsection

@section('css')

    <style>

    </style>

@endsection
@section('content')
    <main class="main">
        <div>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>


            <div class="container my-5">
                <div class="wrapper-wizard">
                    <ol class="wizard-indicator">
                        <li class="complete active">
                            <div class="step">1</div>
                            <div class="caption">Customer Details</div>
                        </li>
                        <li>
                            <div class="step">2</div>
                            <div class="caption">Payment</div>
                        </li>
                        <li>
                            <div class="step">3</div>
                            <div class="caption">Booking Summary</div>
                        </li>
                    </ol>
                </div>

                <div class="row my-5 mx-md-8 justify-content-between">
                    <div class="col-md-5">
                        <div class="card bg-gradient shadow-sm rounded">
                            <div class="card-body">
                                <img src="{{asset($ticket->attraction->get_thumbnail->path)  }}"
                                    alt="{{ $ticket->title }}"
                                    class="card-img-top img-fluid object-fit-lg" style="max-height:280px;">
                                <h4 class="mt-3 mb-0">{{ $ticket->title }}</h4>
                                <h5>{{ $ticket->description }}</h5>
                                <hr class="bg-primary">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Date:</th>
                                            <td class="text-end">@php
                                                $selectedDate = date('j F Y, l', strtotime($selectedDate));
                                            echo $selectedDate;
                                            @endphp </td>
                                        </tr>
                                        <tr>
                                            <th>Ticket For:</th>
                                            <td class="text-end">
                                               @php
                                                   if($adultQuantity > 0){
                                                    echo $adultQuantity ." Adults";
                                                   }
                                                   if($childQuantity > 0){
                                                    echo $childQuantity ." Childs";
                                                   }
                                               @endphp </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 mt-5 mt-md-0">
                        <h4>YOUR INFORMATION</h4>

                        <hr>
                        <form method="post" accept-charset="utf-8"
                            action="/customer/experiences/info?experience_id=1&amp;date=2025-03-08&amp;no_of_adult=2&amp;no_of_child=0&amp;ticket_id=119">
                            <!-- STEP 1: Customer Info & Add-ons -->
                            <div class="step step-1">
                                <h3>Step 1: Personal Details & Add-ons</h3>

                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="Full Name as per ID/Passport" required>
                                </div>

                                <!-- Email & Phone -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" placeholder="e.g. john_doe@gmail.com" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone-number">Phone Number</label>
                                        <div class="input-group">
                                            <select class="form-select" name="country_code" required style="width: auto;">
                                                <option value="+1">+1 (USA)</option>
                                                <option value="+44">+44 (UK)</option>
                                                <option value="+60">+60 (Malaysia)</option>
                                                <option value="+92">+92 (Pakistan)</option>
                                                <option value="+91">+91 (India)</option>
                                            </select>
                                            <input class="form-control" type="tel" name="phone_number" placeholder="1234567890" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Country Selection -->
                                <div class="mb-3">
                                    <label for="country">Country of Origin</label>
                                    <select class="form-select" name="country" required>
                                        <option value="" selected>Select your country</option>
                                        <option value="MY">Malaysia</option>
                                        <option value="SG">Singapore</option>
                                        <option value="GB">United Kingdom</option>
                                    </select>
                                </div>

                                <!-- How did you hear about us? -->
                                <div class="mb-3">
                                    <label for="heard-from">How did you hear about us?</label>
                                    <select class="form-select" name="heard_from">
                                        <option value="">--- Please Select One ---</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Google">Google Search</option>
                                        <option value="Friends">Friends And Family</option>
                                    </select>
                                </div>

                                <!-- Add-ons Selection -->
                                <div class="card my-4 bg-gradient shadow-sm p-2">
                                    <div class="card-header">
                                        <h5 class="fw-bold">Add-ons</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Add-on</th>
                                                    <th>Price (RM)</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (json_decode($ticket->add_ons, true) as $index => $addon)
                                                    <tr>
                                                        <td>
                                                            <b>{{ $addon['name'] }}</b>
                                                            <p>{{ $addon['description'] }}</p>
                                                        </td>
                                                        <td>RM {{ number_format($addon['price'], 2) }}</td>
                                                        <td>
                                                            <select name="addons[{{ $index }}][quantity]" class="form-control">
                                                                @for ($i = 0; $i <= $addon['quantity']; $i++)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                            <input type="hidden" name="addons[{{ $index }}][price]" value="{{ $addon['price'] }}">
                                                            <input type="hidden" name="addons[{{ $index }}][name]" value="{{ $addon['name'] }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary next-step">Next Step</button>
                            </div>

                            <!-- STEP 2: Promo Code & Ticket Summary -->
                            <div class="step step-2" style="display: none;">
                                <h3>Step 2: Apply Promo Code & Review</h3>

                                <!-- Promo Code -->
                                <div class="card my-4 bg-gradient shadow-sm p-2">
                                    <div class="card-header">
                                        <h5 class="fw-bold">Have a Promo Code?</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md">
                                                <input class="form-control" type="text" name="promo_code" id="promo-code" placeholder="Enter Code">
                                            </div>
                                            <div class="col-md-auto">
                                                <button class="btn btn-primary" type="button" id="apply-promo">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ticket Summary -->
                                <div class="card bg-gradient shadow-sm p-2">
                                    <div class="card-body">
                                        <h5 class="fw-bold">Ticket Summary</h5>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><span class="small">{{ $adultQuantity }}x</span> Adult(s)</td>
                                                    <td class="fw-bold text-end">RM {{ $adultQuantity * $adultPrice }}</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="small">{{ $childQuantity }}x</span> Child(s)</td>
                                                    <td class="fw-bold text-end">RM {{ $childQuantity * $childPrice }}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Discount</td>
                                                    <th class="text-end text-danger discount_value">-RM 0.00</th>
                                                </tr>
                                                <tr>
                                                    <td>Add-ons</td>
                                                    <td class="fw-bold text-end"><span id="totalAddon">RM 0.00</span></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-primary" style="font-size: 18px;">Grand Total</th>
                                                    <th class="text-end" style="font-size: 18px;">RM <span id="total">0.00</span></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-secondary prev-step">Back</button>
                                <button type="button" class="btn btn-primary next-step">Next Step</button>
                            </div>

                            <!-- STEP 3: Payment -->
                            <div class="step step-3" style="display: none;">
                                <h3>Step 3: Choose Payment Option</h3>

                                <div class="row">
                                    <div class="col">
                                        <h5>Pay Full</h5>
                                        <button type="submit" class="btn btn-primary" name="payment_type" value="full">Pay RM <span id="fullAmount">0.00</span></button>
                                    </div>
                                    <div class="col">
                                        <h5>Place Deposit</h5>
                                        <button type="submit" class="btn btn-primary" name="payment_type" value="deposit">Pay RM <span id="depositAmount">0.00</span></button>
                                    </div>
                                </div>

                            <div class="row">
                                <div class="col text-end">
                                    <input type="submit" class="btn btn-primary" id="btnnext" value="Next">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
@section('js')
<script>
    $(".next-step").click(function() {
        $(this).closest(".step").hide().next(".step").show();
    });

    $(".prev-step").click(function() {
        $(this).closest(".step").hide().prev(".step").show();
    });
</script>
@endsection
