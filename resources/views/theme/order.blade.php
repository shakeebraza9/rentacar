@extends('theme.layout')

@php
    //dd($users);
@endphp

@section('metatags')
<title>{{$global_d['site_title']}}</title>
@endsection

@section('css')

<style>
    .row {

        justify-content: center;
    }
</style>

@endsection
@section('content')

<main class="main">
    <div>
        <div class="container my-5">
            <div class="wrapper-wizard">
                <ol class="wizard-indicator">
                    <li class="complete">
                        <div class="step"><span class="fa fa-check"></span></div>
                        <div class="caption">Vehicle</div>
                    </li>
                    <li class="complete active">
                        <div class="step">2</div>
                        <div class="caption">Add-ons</div>
                    </li>
                    <li>
                        <div class="step">3</div>
                        <div class="caption">Driver Details</div>
                    </li>
                    <li>
                        <div class="step">4</div>
                        <div class="caption">Payment</div>
                    </li>
                </ol>
            </div>

            <div class="row gx-5">
                <div class="col-md-5">
                    <div class="card mb-4">
                        <img src="{{ asset($booking->get_thumbnail->path) }}" class="card-img-top img-fluid"
                            alt="{{ $booking->slug }}">
                        <div class="card-body">
                            <ul class="list-fleet-specs">
                                <?php foreach ($booking->productDetails as $detail): ?>
                                <li>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars(ucwords(str_replace('_', ' ', htmlspecialchars($detail->key_title))) ) ?>" class="icon">
                                        <img src="{{ asset('theme/asset/img/icon/' . $detail->key_title . '.svg') }}" class="img-fluid" alt="">
                                    </span>
                                    <?= htmlspecialchars($detail->value) ?>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-primary">Rental Amount</h5>
                            <h3 class="d-inline-block">
                                RM <b>{{ number_format($booking->selling_price, 2) }}</b>
                            </h3>
                            <i> for {{ $booking->duration }}</i>
                            <hr>

                            <div class="row">
                                <div class="col-md-5">
                                    <h5 class="text-primary">Rental Location</h5>
                                    {{ $booking->pickup_location }}
                                    <div class="text-muted">{{ date('h:i A, d M Y', strtotime($booking->pickup_time)) }}</div>
                                </div>
                                <div class="col-md-2 my-auto">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="col-md-5">
                                    <h5 class="text-primary">Drop-off Location</h5>
                                    {{ $booking->dropoff_location }}
                                    <div class="text-muted">{{ date('h:i A, d M Y', strtotime($booking->dropoff_time)) }}</div>
                                </div>
                            </div>

                            <hr>

                            <h5 class="text-primary">Summary of Charges</h5>

                            <table class="table">
                                <tbody>
                                    @php
                                    $rental = $global_d['rental'] ?? 0;
                                    $extra_hour = $global_d['extra_hour'] ?? 0;
                                    $pickup_fee = $global_d['pickup_fee'] ?? 0;
                                    $return_fee = $global_d['return_fee'] ?? 0;
                                    $addons = $global_d['add-ons'] ?? 0;
                                    $discount = $global_d['discount'] ?? 0;
                                    $productprice = $booking->selling_price ?? 0;

                                    // Total Before Discount
                                    $totalBeforeDiscount = $rental + $extra_hour + $pickup_fee + $return_fee + $addons + $productprice;

                                    // Calculate Discount Percentage
                                    $discountPercentage = $totalBeforeDiscount > 0 ? ($discount / $totalBeforeDiscount) * 100 : 0;

                                    // Final Total After Discount
                                    $total = $totalBeforeDiscount - $discount;
                                @endphp

                                <tr>
                                    <td>Rental</td>
                                    <td class="text-end">{{ number_format($rental, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Extra Hour ({{ $booking->extra_hours ?? 0 }})</td>
                                    <td class="text-end">{{ number_format($extra_hour, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Pickup Fee</td>
                                    <td class="text-end">{{ number_format($pickup_fee, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Return Fee</td>
                                    <td class="text-end">{{ number_format($return_fee, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Add-ons</td>
                                    <td class="text-end">{{ number_format($addons, 2) }}</td>
                                </tr>
                                <tr class="text-end">
                                    <td>Discount ({{ number_format($discountPercentage, 2) }}%)</td>
                                    <td class="fw-bold">-{{ number_format($discount, 2) }}</td>
                                </tr>
                                <tr class="text-end fw-bold">
                                    <td>Total Amount</td>
                                    <td class="text-primary">{{ number_format($total, 2) }}</td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 mt-4 mt-md-0">
                    <h3 class="text-primary">Add-ons</h3>
                    <form method="post" accept-charset="utf-8" action="/customer/orders/complete">
                        <div id="step1" class="step">
                            <h3>Step 1: Select Add-ons</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <th></th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Child Seat</b>
                                            <i> (per day)</i>

                                            <p>Age 1~3y with max. 15kg.</p>
                                        </td>
                                        <td>
                                            20.00 </td>
                                        <td class="col-md-2">
                                            <select name="addons[1]" id="1" class="form-control input_price_selector"
                                                data-price="20.00">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Additional Driver</b>
                                            <i> (per rental)</i>

                                            <p>Add additional drivers to drive the rental car. All drivers need to
                                                provide valid documentation </p>
                                        </td>
                                        <td>
                                            20.00 </td>
                                        <td class="col-md-2">
                                            <select name="addons[2]" id="2" class="form-control input_price_selector"
                                                data-price="20.00">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Liability Reduction Option (LRO) </b>
                                            <i> (per day)</i>

                                            <p>Recommended to reduce an excess and liability for major accident or
                                                vehicle loss</p>
                                        </td>
                                        <td>
                                            30.00 </td>
                                        <td class="col-md-2">
                                            <select name="addons[39]" id="39" class="form-control input_price_selector"
                                                data-price="30.00">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Baby Seat</b>
                                            <i> (per day)</i>

                                            <p>Age 0-1y with max. 10kg</p>
                                        </td>
                                        <td>
                                            20.00 </td>
                                        <td class="col-md-2">
                                            <select name="addons[41]" id="41" class="form-control input_price_selector"
                                                data-price="20.00">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="text-end">
                                        <th colspan="2">Total (RM):</th>
                                        <th><span id="addon-price-value">&nbsp;0.00</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="button" class="btn btn-primary" onclick="showStep(2)">Next</button>
                        </div>

                        <div id="step2" class="step d-none">
                            <div class="card mb-4">
                                <h3 class="card-header text-primary">Customer Details</h3>
                                <div class="card-body">
                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" name="name" required
                                            placeholder="Full Name as ID / Passport" id="name">
                                        <div class="invalid-feedback">Please provide a valid name.</div>
                                    </div>

                                    <!-- Email -->
                                    <!-- Email and Phone Number -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control" type="email" name="email" required
                                                    placeholder="e.g. john_doe@mail.com" id="email">
                                                <div class="invalid-feedback">Please provide a valid email.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone-number" class="form-label">Phone Number</label>
                                                <div class="input-group" style="display: flex; align-items: center;">
                                                    <select class="form-select" name="country_code" id="country-code"
                                                        required style="width: auto; min-width: 100px; flex-shrink: 0;">
                                                        <option value="+1">+1 (USA)</option>
                                                        <option value="+44">+44 (UK)</option>
                                                        <option value="+60">+60 (Malaysia)</option>
                                                        <option value="+92">+92 (Pakistan)</option>
                                                        <option value="+91">+91 (India)</option>
                                                        <!-- Add more country codes as needed -->
                                                    </select>
                                                    <input class="form-control" type="tel" name="phone_number" required
                                                        placeholder="e.g. 1234567890" id="phone-number"
                                                        style="flex-grow: 1; max-width: 250px;">
                                                </div>
                                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- Country of Origin -->
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="mb-3">
                                                <label for="country" class="form-label">Country of Origin</label>
                                                <select class="form-select" name="country" required id="country">
                                                    <option value="" selected>Select your country</option>
                                                    <option value="MY">Malaysia</option>
                                                    <option value="SG">Singapore</option>
                                                    <option value="GB">United Kingdom</option>
                                                    <!-- Add more countries here -->
                                                </select>
                                                <div class="invalid-feedback">Please select a country.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ID/Passport and License Number -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="user-passport" class="form-label">ID/Passport Number</label>
                                                <input class="form-control" type="text" name="user_passport" required
                                                    placeholder="e.g. 543210987654" id="user-passport">
                                                <div class="invalid-feedback">Please provide a valid ID/Passport number.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="user-license" class="form-label">License Number</label>
                                                <input class="form-control" type="text" name="user_license"
                                                    placeholder="e.g. 543210987654" id="user-license">
                                                <div class="invalid-feedback">Please provide a valid license number.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Age and Gender -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="user-age" class="form-label">Age</label>
                                                <select class="form-select" name="user_age" required id="user-age">
                                                    <option value="">Select Age</option>
                                                    <!-- Add age options here -->
                                                </select>
                                                <div class="invalid-feedback">Please select your age.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label">Gender <span
                                                        class="text-muted small fst-italic">(Optional)</span></label>
                                                <select class="form-select" name="gender" id="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                                <div class="invalid-feedback">Please select your gender.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- How did you hear about us? -->
                                    <div class="mb-3">
                                        <label for="heard-from-id" class="form-label">How did you hear about us?</label>
                                        <select class="form-select" name="heard_from_id" id="heard-from-id">
                                            <option value="">--- Please Select One ---</option>
                                            <option value="1">Facebook</option>
                                            <option value="3">Google Search</option>
                                            <option value="4">Friends And Family</option>
                                            <option value="5">LangkawiBook Customer</option>
                                            <option value="6">Google Maps</option>
                                            <option value="7">Blog &amp; Article</option>
                                        </select>
                                        <div class="invalid-feedback">Please select an option.</div>
                                    </div>

                                    <!-- Invoice Section -->
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="invoice" value="1"
                                                id="invoice">
                                            <label for="invoice" class="form-check-label">I want to invoice this rental
                                                using different information.</label>
                                        </div>
                                    </div>

                                    <!-- Invoice Details (Hidden by Default) -->
                                    <div id="invoice-area" class="d-none">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="invoice-name" class="form-label">Name</label>
                                                    <input class="form-control" type="text" name="invoice_name"
                                                        placeholder="e.g. John Doe" id="invoice-name" disabled>
                                                    <div class="invalid-feedback">Please provide a valid name.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="invoice-address" class="form-label">Invoice Address</label>
                                            <textarea class="form-control" name="invoice_address"
                                                placeholder="e.g. Taman Bukit Katil Baiduri, Ayer Keroh, Melaka"
                                                id="invoice-address" rows="5" disabled></textarea>
                                            <div class="invalid-feedback">Please provide a valid address.</div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Other Driver Section -->
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="other_driver"
                                                value="1" id="other-driver">
                                            <label for="other-driver" class="form-check-label">I am not a driver for
                                                this vehicle. I am making this reservation for someone else.</label>
                                        </div>
                                    </div>

                                    <!-- Driver Details (Hidden by Default) -->
                                    <div id="area_driver" class="d-none">
                                        <div class="mb-3">
                                            <label for="driver-name" class="form-label">Driver Name</label>
                                            <input class="form-control" type="text" name="driver_name"
                                                placeholder="e.g. John Doe" id="driver-name" disabled>
                                            <div class="invalid-feedback">Please provide a valid name.</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="driver-ic-number" class="form-label">Driver ID/Passport
                                                        Number</label>
                                                    <input class="form-control" type="number" name="driver_ic_number"
                                                        placeholder="e.g. 543210987654" id="driver-ic-number" disabled>
                                                    <div class="invalid-feedback">Please provide a valid ID/Passport
                                                        number.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="driver-license-number" class="form-label">Driver License
                                                        Number</label>
                                                    <input class="form-control" type="number"
                                                        name="driver_license_number" placeholder="e.g. 543210987654"
                                                        id="driver-license-number" disabled>
                                                    <div class="invalid-feedback">Please provide a valid license number.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="driver-age" class="form-label">Driver Age</label>
                                                    <select class="form-select" name="driver_age" id="driver-age"
                                                        disabled>
                                                        <option value="">Select Driver Age</option>
                                                        <!-- Add age options here -->
                                                    </select>
                                                    <div class="invalid-feedback">Please select the driver's age.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="get-driver-mobile-number" class="form-label">Driver
                                                        Mobile Number</label>
                                                    <input class="form-control" type="text" name="driver_mobile_number"
                                                        placeholder="e.g. +92 123 456789" id="get-driver-mobile-number"
                                                        disabled>
                                                    <div class="invalid-feedback">Please provide a valid mobile number.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Note -->
                                    <div class="mb-3">
                                        <label for="note" class="form-label">Note</label>
                                        <textarea class="form-control" name="note"
                                            placeholder="e.g. I will reach 30 minutes earlier." id="note"
                                            rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="showStep(1)">Previous</button>
                            <button type="button" class="btn btn-primary" onclick="showStep(3)">Next</button>
                        </div>

                        <div id="step3" class="step d-none">
                            <div class="col-md-7">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h4 class="text-primary">Customer Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Name</h6>
                                                <div class="border-bottom pb-2">
                                                    adasd </div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <h6>Email</h6>
                                                <div class="border-bottom pb-2">
                                                    aa@gmail.com </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Country of Origin</h6>
                                                <div class="border-bottom pb-2">
                                                    QA </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Phone Number</h6>
                                                <div class="border-bottom pb-2">
                                                    +923456677678 </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Driver Name</h6>
                                                <div class="border-bottom pb-2">
                                                    adasd </div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <h6>Driver Mobile Number</h6>
                                                <div class="border-bottom pb-2">
                                                    +923456677678 </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Driver ID/Passport Number</h6>
                                                <div class="border-bottom pb-2">
                                                    23424 </div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <h6>Driver License Number</h6>
                                                <div class="border-bottom pb-2">
                                                    234234234 </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Age</h6>
                                                <div class="border-bottom pb-2">
                                                    33 </div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <h6>How did you hear about us</h6>
                                                <div class="border-bottom pb-2">
                                                    Google Search </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md">
                                                <h6>Note</h6>
                                                <div class="border-bottom pb-2">
                                                    234234234 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form method="post" accept-charset="utf-8"
                                    action="/customer/orders/summary?custom_pickup_location=The+St.+Regis+Langkawi&amp;custom_return_location=The+St.+Regis+Langkawi&amp;start_date=2025-03-05&amp;start_time=6%3A00+AM&amp;end_date=2025-03-05&amp;end_time=12%3A00+PM&amp;use_different_return_location=0&amp;fleet_id=6&amp;addons%5B1%5D=0&amp;addons%5B2%5D=0&amp;addons%5B39%5D=0&amp;addons%5B41%5D=0&amp;name=adasd&amp;email=aa%40gmail.com&amp;phone_number=%2B923456677678&amp;country=QA&amp;user_passport=23424&amp;user_license=234234234&amp;user_age=33&amp;gender=&amp;race=&amp;heard_from_id=3&amp;invoice=0&amp;other_driver=0&amp;note=234234234&amp;driver_name=adasd&amp;driver_ic_number=23424&amp;driver_license_number=234234234&amp;driver_mobile_number=%2B923456677678&amp;driver_age=33">
                                    <div class="card mb-4" style="display: true">
                                        <div class="card-header">
                                            <h4 class="text-primary">Promo Code</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="mb-3"><label for="promo_code">Enter Code</label><input
                                                            class=" form-control " type="text" name="code"
                                                            id="promo_code"><span class="help-block text-muted"> </span>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-auto" style="padding-top:20px;">
                                                    <button class="btn btn-primary" id="apply">
                                                        Apply </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="text-primary">Total Amount</h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Rental</td>
                                                        <td class="text-end">100.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Extra Hour (0)</td>
                                                        <td class="text-end">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pickup Fee</td>
                                                        <td class="text-end">20.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Return Fee</td>
                                                        <td class="text-end">20.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Add-ons <br>
                                                            <ul>
                                                            </ul>
                                                        </td>
                                                        <td class="text-end">0.00</td>
                                                    </tr>
                                                    <tr class="text-end">
                                                        <td>Total Amount</td>
                                                        <td class="fw-bold total_value">140.00</td>
                                                    </tr>
                                                    <tr class="text-end">
                                                        <td>
                                                            Discount<br>
                                                        </td>
                                                        <td class="fw-bold discount_value text-danger">-0.00</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-end">
                                                        <td class="fw-bold">GRAND TOTAL (RM)</td>
                                                        <td class="fw-bold text-primary grand_value">140.00 </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="mb-3">
                                                <div class="form-check "><input class=" form-control " type="hidden"
                                                        name="term_conditions" value="0"><span
                                                        class="help-block text-muted"> </span>
                                                    <div class="invalid-feedback"></div><input class="form-check-input "
                                                        type="checkbox" name="term_conditions" value="1"
                                                        id="term_conditions" required="required"
                                                        aria-required="true"><label for="term_conditions"
                                                        class="form-check-label">It is essential that you understand the
                                                        <a href="/terms-and-conditions" target="_blank">terms &amp;
                                                            conditions</a> before submitting your reservation. Please
                                                        indicate acceptance by checking this box.</label>
                                                </div>
                                            </div> <span id="msgtnc" class="small text-danger fw-bold"
                                                style="margin-top:-15px; position: absolute; display: none;">Please tick
                                                this box to proceed</span>
                                        </div>
                                    </div>


                                    <!-- initiate razer payment method selection -->


                                </form>
                                <div class="row gx-md-8 mt-5">
                                    <div class="col-md border-end">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="text-muted mb-2"><i class="fas fa-hand-holding-usd"></i>
                                                    Place Deposit</div>
                                                <h2 class="text-primary">RM 100.00</h2>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-primary price-selector" data-value="0" value="0"
                                                    id="btn_deposit">
                                                    Place Deposit </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="showStep(2)">Previous</button>
                            <!-- <button type="submit" class="btn btn-success">Pay Now</button> -->
                            <button type="button" class="btn btn-success"
                                onclick="window.location.href='{{ url('/checkout') }}'">
                                Pay Now
                            </button>

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
    function showStep(step) {
        // Hide all steps
        document.querySelectorAll('.step').forEach(stepDiv => stepDiv.classList.add('d-none'));

        // Show the current step
        document.getElementById('step' + step).classList.remove('d-none');
    }

    // Show the first step initially
    showStep(1);
</script>
@endsection
