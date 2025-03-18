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
                    <li class="sepfist">
                        <div class="step">1</div>
                        <div class="caption">Vehicle</div>
                    </li>
                    <li>
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
                    @php
                    use Carbon\Carbon;
                    $bookingStart = Carbon::parse($today ?? now());
                    $bookingEnd = Carbon::parse($from ?? now());

                    $durationInMinutes = $bookingStart->diffInMinutes($bookingEnd);

                    $durationDays = floor($durationInMinutes / (60 * 24));
                    $remainingMinutesAfterDays = $durationInMinutes % (60 * 24);

                    $durationHours = floor($remainingMinutesAfterDays / 60);
                    $durationMinutes = $remainingMinutesAfterDays % 60;

                    $bookingDuration = '';

                    if ($durationDays > 0) {
                        $bookingDuration .= $durationDays . ' day' . ($durationDays > 1 ? 's' : '');
                    }
                    if ($durationHours > 0) {
                        if ($bookingDuration !== '') {
                            $bookingDuration .= ' ';
                        }
                        $bookingDuration .= $durationHours . ' hour' . ($durationHours > 1 ? 's' : '');
                    }
                    if ($durationMinutes > 0) {
                        if ($bookingDuration !== '') {
                            $bookingDuration .= ' ';
                        }
                        $bookingDuration .= $durationMinutes . ' min' . ($durationMinutes > 1 ? 's' : '');
                    }

                    @endphp


                    @php


                    $extra_hour = $global_d['extra_hour'] ?? 0;
                    $pickup_fee = $global_d['pickup_fee'] ?? 0;
                    $return_fee = $global_d['return_fee'] ?? 0;
                    $addons = $global_d['add-ons'] ?? 0;
                    $discountPercent = $global_d['discount'] ?? 0;
                    $productprice = $booking->selling_price ?? 0;
                    $bookingPrice = $booking->price ?? 0;
                    $rental =$productprice ?? 0;
                    if($discountPercent <= 0){
                        $discountAmount = $productprice * $bookingPrice; // This is your existing calc

                        // Now percentage difference between $productPrice and $bookingPrice
                        $difference = abs($productprice - $bookingPrice);
                        $average = ($productprice + $bookingPrice) / 2;

                        $discountAmount = ($difference / $average) * 100;
                    }else{

                        $discountAmount = ($productprice * $discountPercent) / 100;
                    }

                    $from = Carbon::parse($from ?? now());
                    $today = Carbon::parse($today ?? now());







                    $totalHours = $today->diffInHours($from);
                    $extraHours = max(0, $totalHours - 24);
                    $extraHourCharge = 0;











                    $session_extra_amount = 0;

                    if ($global_d['season_enable'] == 1) {
                        $sessionFrom = Carbon::parse($global_d['season_start_date']);
                        $sessionTo = Carbon::parse($global_d['season_end_date']);

                        // Swap if season dates are in wrong order
                        if ($sessionFrom->gt($sessionTo)) {
                            [$sessionFrom, $sessionTo] = [$sessionTo, $sessionFrom];
                        }

                        // Check if booking range overlaps with season range
                        $bookingStartsInSeason = $from->between($sessionFrom, $sessionTo);
                        $bookingEndsInSeason = $today->between($sessionFrom, $sessionTo);

                        // Check if booking starts before season but ends after it starts
                        $bookingCrossesSeason = $from->lt($sessionFrom) && $today->gt($sessionFrom);

                        if ($bookingStartsInSeason || $bookingEndsInSeason || $bookingCrossesSeason) {
                            $carType = getCarTypeBySlug($booking->type);
                            $session_extra_amount = $carType->amount ?? 0;
                            $rental += $session_extra_amount;
                        }
                    }



                    $total = $pickup_fee + $return_fee + $addons + $productprice   +$session_extra_amount ;
                    if ($discountPercent > 0) {
                        $total = max(0, $total - $discountAmount);
                    }

                    $extraHourCharge = 0;

                    if ($extra_hour > 0 && $totalHours > 24) {
                        $fullDays = floor($totalHours / 24);
                        $remainingHours = $totalHours % 24;


                        $dayCharge = $total * ($fullDays - 1);
                        $extraHourCharge += $dayCharge;
                        //$rental += $extraHourCharge;


                        if(isset($remainingHours)){
                        if ($remainingHours >= 1 && $remainingHours <= 5) {
                            $hourlyCharge = ($total * ($remainingHours * $extra_hour)) / 100;
                            $extraHourCharge += $hourlyCharge;
                        }

                        if($remainingHours > 5){

                        $dayCharge = $total * ($fullDays - 1);
                        $extraHourCharge += $dayCharge;
                        $rental += $extraHourCharge;
                        }
                    }
                    }

                    $total += $extraHourCharge;





                @endphp


                    <div class="card"  >
                        <div class="card-body">
                            <h5 class="text-primary">Rental Amount</h5>
                            <h3 class="d-inline-block">
                                RM <b>{{ number_format($rental , 2) }}</b>
                            </h3>
                            <i> for {{ $bookingDuration  }}</i>
                            <hr>

                            <div class="row">
                                <div class="col-md-5">
                                    <h5 class="text-primary">Rental Location</h5>
                                    {{ request("pickup_location") }}
                                    <div class="text-muted">{{ date('h:i A, d M Y', strtotime($today)) }}</div>
                                </div>
                                <div class="col-md-2 my-auto">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="col-md-5">
                                    <h5 class="text-primary">Drop-off Location</h5>
                                    {{ request("return_location") }}
                                    <div class="text-muted">{{ date('h:i A, d M Y', strtotime($from)) }}</div>
                                </div>
                            </div>

                            <hr>

                            <h5 class="text-primary" id="rentalamount-heading">Summary of Charges</h5>

                            <table class="table" id="rentalamount-sidebar" >
                                <tbody>








                                <tr>
                                    <td>Rental </td>
                                    <td class="text-end">{{ number_format($rental, 2) }}</td>
                                </tr>
                                <tr>
                                    @if (isset($remainingHours) && $remainingHours >= 1 && $remainingHours <= 5)
                                    <td>Extra Hour ({{ $remainingHours ?? 0 }})</td>
                                    <td class="text-end" style="color:#690C0B;">{{ number_format($hourlyCharge, 2) }} </td>
                                    @else
                                    <td>Extra Hour (0)</td>
                                    <td class="text-end" style="color:#690C0B;"> 0 </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Pickup Fee</td>
                                    <td class="text-end">{{ number_format($pickup_fee, 2) }}</td>
                                </tr>

                                {{--  @if($global_d['session_enable'] == 1)  --}}


                                {{--  <tr>
                                    <td>{{ $global_d['session_name'] }} - Charges</td>
                                    <td class="text-end">{{ number_format($session_extra_amount, 2) }}</td>
                                </tr>  --}}

                                {{--  @endif  --}}
                                <tr>
                                    <td>Return Fee</td>
                                    <td class="text-end">{{ number_format($return_fee, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Add-ons</td>
                                    <td class="text-end"><span id="addon-price">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td class="text-end"><span id="addon-price">-{{ number_format($discountAmount, 2) }}</span></td>
                                </tr>
                                {{--  <tr>
                                    <td>Total Without Discount,Extra Hour (0),Add-ons</td>
                                    <td class="text-end">{{ number_format($totalBeforeDiscount, 2) }} </td>
                                </tr>  --}}

                                <tr class="text-end fw-bold">
                                    <td>Total Amount</td>
                                    <td class="text-primary">
                                        RM <span id="total-amount" data-base-total="{{ $total }}">{{ number_format($total, 2) }}</span>
                                    </td>
                                </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 mt-4 mt-md-0">
                    <h3 class="text-primary" id="headingfrom">Add-ons</h3>
                    <form method="post" action="{{ route('cusmoter.checkout')}}" id="checkoutForm">
                        @csrf
                        <div id="step1" class="stepfrom">
                            {{--  <h3>Step 1: Select Add-ons</h3>  --}}
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
                        <input type="hidden" name="selected_addons" id="selected-addons">
                        <input type="hidden" name="extracharge" value="{{ $extraHourCharge }}">
                        {{--  <input type="hidden" name="extraChargepeek" value="{{ $extraCharge }}">  --}}
                        {{--  <input type="hidden" name="session_extra_amount" value="{{ $session_extra_amount }}">  --}}
                        <input type="hidden" name="depositeamount" value="{{ $price }}">

                        <div id="step2" class="stepfrom d-none">
                            <input type="hidden" name="slug" value="{{ $slug }}">
                            <div class="card mb-4">
                                <h3 class="card-header text-primary">Customer Details</h3>
                                <div class="card-body">
                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" name="name" required
                                            placeholder="Full Name as ID / Passport" id="name">
                                        <input type="hidden" name="today" value="{{ $today }}">
                                        <input type="hidden" name="from" value="{{ $from }}">
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
                                                {{--  <div class="input-group" style="display: flex; align-items: center;">
                                                    <select class="form-select" name="country_code" id="country-code"
                                                        required style="width: auto; min-width: 100px; flex-shrink: 0;">
                                                        <option value="+1">+1 (USA)</option>
                                                        <option value="+44">+44 (UK)</option>
                                                        <option value="+60">+60 (Malaysia)</option>
                                                        <option value="+92">+92 (Pakistan)</option>
                                                        <option value="+91">+91 (India)</option>

                                                    </select>
                                                    <input class="form-control" type="tel" name="phone_number" required
                                                        placeholder="e.g. 1234567890" id="phone-number"
                                                        style="flex-grow: 1; max-width: 250px;">
                                                </div>  --}}
                                                <input class="form-control phone" type="tel" id="phone" name="phone_number1" />
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
                                                    @php
                                                    $allCountry = explode(',', getset('country')); // Split by comma
                                                @endphp

                                                @foreach($allCountry as $country)
                                                    <option value="{{ trim($country) }}">{{ trim($country) }}</option>
                                                @endforeach

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
                                                <select class="form-select " name="user_age" required="required" id="user-age">
                                                    <option value="">Select Age</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                    <option value="51">51</option>
                                                    <option value="52">52</option>
                                                    <option value="53">53</option>
                                                    <option value="54">54</option>
                                                    <option value="55">55</option>
                                                    <option value="56">56</option>
                                                    <option value="57">57</option>
                                                    <option value="58">58</option>
                                                    <option value="59">59</option>
                                                    <option value="60">60</option>
                                                    <option value="61">61</option>
                                                    <option value="62">62</option>
                                                    <option value="63">63</option>
                                                    <option value="64">64</option>
                                                    <option value="65">65</option>
                                                    <option value="66">66</option>
                                                    <option value="67">67</option>
                                                    <option value="68">68</option>
                                                    <option value="69">69</option>
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
                                    <div id="invoice-area" class="" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3"><label for="invoice-name">Name</label><input class=" form-control " type="text" name="invoice_name" placeholder="e.g. John Doe" id="invoice-name" aria-required="true"><span class="help-block text-muted"> </span><div class="invalid-feedback"></div></div>                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone-number" class="form-label">Phone Number</label>
                                                    <div class="input-group" style="display: flex; align-items: center;">
                                                        {{--  <select class="form-select" name="country_code" id="country-code"  style="width: auto; min-width: 100px; flex-shrink: 0;">
                                                            <option value="+1">+1 (USA)</option>
                                                            <option value="+44">+44 (UK)</option>
                                                            <option value="+60">+60 (Malaysia)</option>
                                                            <option value="+92">+92 (Pakistan)</option>
                                                            <option value="+91">+91 (India)</option>
                                                            <!-- Add more country codes as needed -->
                                                        </select>
                                                        <input class="form-control" type="tel" name="phone_number2"  placeholder="e.g. 1234567890" id="phone-number" style="flex-grow: 1; max-width: 250px;">
                                                          --}}
                                                          <input class="form-control phone" type="tel" id="phone2" name="phone_number2" />
                                                          <div class="invalid-feedback">Please provide a valid phone number.</div>

                                                    </div>
                                                    <div class="invalid-feedback">Please provide a valid phone number.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3"><label for="invoice-address">Invoice Address</label><textarea class="form-control " type="" name="invoice_address" placeholder="e.g. Taman Bukit Katil Baiduri, Ayer Keroh, Melaka" id="invoice-address" aria-required="true" rows="5"></textarea><span class="help"> </span></div>                    </div>

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
                                                    <div class="invalid-feedback">Please select the drivers age.</div>
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
                                    <div class="mb-3">
                                        <label for="flight-number">Flight No.</label>
                                        <input class=" form-control " type="text" name="flight_number" placeholder="AK6304" id="flight-number">
                                        <span class="help-block text-muted">
                                        </span>
                                        <div class="invalid-feedback">
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

                        <div id="step3" class="stepfrom d-none">
                            <div class="col-md-10">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h4 class="text-primary">Customer Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Name</h6>
                                                <div class="border-bottom pb-2" id="summary-name">---</div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <h6>Email</h6>
                                                <div class="border-bottom pb-2" id="summary-email">---</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Country of Origin</h6>
                                                <div class="border-bottom pb-2" id="summary-country">---</div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Phone Number</h6>
                                                <div class="border-bottom pb-2" id="summary-phone">---</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Driver Name</h6>
                                                <div class="border-bottom pb-2" id="summary-driver-name">---</div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <h6>Driver Mobile Number</h6>
                                                <div class="border-bottom pb-2" id="summary-driver-phone">---</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Driver ID/Passport Number</h6>
                                                <div class="border-bottom pb-2" id="summary-driver-id">---</div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <h6>Driver License Number</h6>
                                                <div class="border-bottom pb-2" id="summary-driver-license">---</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>Age</h6>
                                                <div class="border-bottom pb-2" id="summary-age">---</div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <h6>How did you hear about us</h6>
                                                <div class="border-bottom pb-2" id="summary-heard-from">---</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md">
                                                <h6>Note</h6>
                                                <div class="border-bottom pb-2" id="summary-note">---</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


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
                                                        {{ request('pickup_location') ?? $booking->pickup_location }}

                                                        <div class="text-muted">{{ date('h:i A, d M Y', strtotime($booking->pickup_time)) }}</div>
                                                    </div>
                                                    <div class="col-md-2 my-auto">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <h5 class="text-primary">Drop-off Location</h5>
                                                        {{ request('return_location') ??  $booking->dropoff_location }}
                                                        <div class="text-muted">{{ date('h:i A, d M Y', strtotime($booking->dropoff_time)) }}</div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <h5 class="text-primary">Summary of Charges</h5>

                                                <table class="table">
                                                    <tbody>


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
                                                            <td>Discount </td>
                                                            <td class="fw-bold">-{{ number_format($discountAmount, 2) }}</td>
                                                        </tr>
                                                        <tr class="text-end fw-bold">
                                                            <td>Total Amount</td>
                                                            <td class="text-primary">
                                                                RM <span id="total-amount2" data-base-total="{{ $total }}">{{ number_format($total, 2) }}</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- initiate razer payment method selection -->

                                    <input type="hidden" id="paymentType" name="payment_type" value="full">







                                {{--  <div class="row gx-md-8 mt-5">
                                    <div class="col-md border-end">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="text-muted mb-2"><i class="fas fa-hand-holding-usd"></i>
                                                    Place Deposit</div>
                                                <h2 class="text-primary">RM {{ $price }}</h2>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-primary price-selector" data-value="0" value="0"
                                                    id="btn_deposit">
                                                    Place Deposit </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>  --}}
                            </div>

                            <div class="container" style="max-width: 100%; margin: 0 auto;">
                                <div class="row" style="background-color: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                    <div class="col-md-6" style="border-right: 1px solid #eee; padding-right: 20px;">
                                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="fas fa-money-bill-wave" style="color: #6c757d; margin-right: 10px;"></i>
                                            <span style="color: #6c757d; font-size: 14px;">Place Deposit</span>
                                        </div>
                                        <div style="font-size: 24px; font-weight: bold; color: #00c853; margin-bottom: 15px;">RM {{ $price }}</div>
                                        <button class="btn btn-primary price-selector" data-value="0" value="0" id="btn_deposit"> Place Deposit </button>
                                    </div>

                                    <div class="col-md-6" style="padding-left: 20px;">
                                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="fas fa-credit-card" style="color: #6c757d; margin-right: 10px;"></i>
                                            <span style="color: #6c757d; font-size: 14px;">Pay Full</span>
                                        </div>
                                        <div style="font-size: 24px; font-weight: bold; color: #00c853; margin-bottom: 15px;" id="totalwithaddons">RM {{ number_format($total, 2) }}</div>
                                        <button type="submit" class="btn btn-success" onclick="proceedToCheckout()">Pay Full</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="showStep(2)">Previous</button>
                         {{--  <button type="submit" class="btn btn-success" onclick="proceedToCheckout()">Pay Now</button>  --}}


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
    document.addEventListener("DOMContentLoaded", function () {
        const invoiceCheckbox = document.getElementById("invoice");
        const invoiceArea = document.getElementById("invoice-area");

        invoiceCheckbox.addEventListener("change", function () {
            if (this.checked) {
                invoiceArea.style.display = "block";
            } else {
                invoiceArea.style.display = "none";
            }
        });
    });
    </script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputs = document.querySelectorAll(".phone");
        if (window.intlTelInput) {
            inputs.forEach(function(input) {
                window.intlTelInput(input, {
                    separateDialCode: true,
                    initialCountry: "my", // Malaysia as default
                    preferredCountries: ["my", "pk", "in", "us", "gb", "ae"],
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js"
                });
            });
        } else {
            console.error("intlTelInput not loaded");
        }
    });


</script>

<script>
    function validateStep2() {
    const step2 = document.getElementById('step2');
    const inputs = step2.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    return isValid;
}

function showStep(step) {

    if (step === 3) {
        const isStep2Valid = validateStep2();
        $('#rentalamount-sidebar').hide();
        document.getElementById('rentalamount-heading').style.display = 'none';

        if (!isStep2Valid) {
            alert('Please fill out all required fields in Step 2.');
            return;
        }
    }

    if (step === 2) {
        $('#rentalamount-sidebar').show();
        document.getElementById('rentalamount-heading').style.display = 'block';
    }

    // Hide all step content sections
    document.querySelectorAll('.stepfrom').forEach(stepDiv => stepDiv.classList.add('d-none'));
    document.getElementById('step' + step).classList.remove('d-none');

    // Update wizard steps indicator visuals
    const firstStepEl = document.querySelector('.wizard-indicator li.sepfist');
    const firstStepDiv = firstStepEl.querySelector('.step');
    firstStepEl.classList.add('complete');
    firstStepDiv.innerHTML = '<span class="fa fa-check"></span>';

    const wizardSteps = document.querySelectorAll('.wizard-indicator li');

    wizardSteps.forEach((stepLi, index) => {
        if (index === 0) return;

        const stepNumber = index + 1;
        const stepDiv = stepLi.querySelector('.step');

        if (stepNumber < step) {
            stepLi.classList.remove('active');
            stepLi.classList.add('complete');
            stepDiv.innerHTML = '<span class="fa fa-check"></span>';
        } else if (stepNumber === step) {
            stepLi.classList.remove('active');
            stepLi.classList.add('complete');
            stepDiv.innerHTML = '<span class="fa fa-check"></span>';
        } else {
            stepLi.classList.remove('complete', 'active');
            stepDiv.textContent = stepNumber;
        }
    });


    const currentStepIndex = step ;
    const currentCaptionEl = document.querySelectorAll('.wizard-indicator li .caption')[currentStepIndex];
    if (currentCaptionEl) {
        document.getElementById('headingfrom').textContent = currentCaptionEl.textContent.trim();
    }
}





showStep(1);



        function toggleSection(checkboxId, sectionId) {
        const checkbox = document.getElementById(checkboxId);
        const section = document.getElementById(sectionId);

        checkbox.addEventListener("change", function () {
            if (this.checked) {
                section.classList.remove("d-none");
                section.querySelectorAll("input, textarea, select").forEach(el => el.removeAttribute("disabled"));
            } else {
                section.classList.add("d-none");
                section.querySelectorAll("input, textarea, select").forEach(el => el.setAttribute("disabled", "true"));
            }
        });
    }


    toggleSection("invoice", "invoice-area");
    toggleSection("other-driver", "area_driver");

    document.getElementById("btn_deposit").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default redirect
        document.getElementById("paymentType").value = "deposit"; // Set deposit type
        document.getElementById("checkoutForm").submit(); // Submit form
    });

    function proceedToCheckout() {
        const isStep2Valid = validateStep2();

        if (!isStep2Valid) {
            alert('Please fill out all required fields in Step 2.');
            return;
        }

        document.getElementById("paymentType").value = "full"; // Set full payment type
        document.getElementById("checkoutForm").submit();
    }

    document.addEventListener("DOMContentLoaded", function () {
        function updateAddonTotal() {
            let addonsTotal = 0;
            let selectedAddons = [];
            document.querySelectorAll(".input_price_selector").forEach(select => {
                let price = parseFloat(select.dataset.price) || 0;
                let quantity = parseInt(select.value) || 0;
                let addonName = select.closest("tr").querySelector("td b").textContent.trim();

                if (quantity > 0) {
                    addonsTotal += price * quantity;
                    selectedAddons.push({
                        name: addonName,
                        quantity: quantity,
                        price: price,
                        total: (price * quantity).toFixed(2)
                    });
                }
            });

            document.getElementById("addon-price").textContent = addonsTotal.toFixed(2);

            let totalAmountElement = document.getElementById("total-amount");
            let totalAmountElement2 = document.getElementById("total-amount2");
            if (totalAmountElement) {
                let baseTotal = parseFloat(totalAmountElement.dataset.baseTotal) || 0;
                totalAmountElement.textContent = (baseTotal + addonsTotal).toFixed(2);
            }
            if (totalAmountElement2) {
                let baseTotal = parseFloat(totalAmountElement2.dataset.baseTotal) || 0;
                totalAmountElement2.textContent = (baseTotal + addonsTotal).toFixed(2);
            }

            let totalWithAddonsElement = document.getElementById("totalwithaddons");
            if (totalWithAddonsElement) {
                let currentText = totalWithAddonsElement.textContent.replace(/[^\d.]/g, '');
                let currentTotal = parseFloat(currentText) || 0;
                let totalWithAddons = currentTotal + addonsTotal;
                totalWithAddonsElement.textContent = 'RM ' + totalWithAddons.toFixed(2);
            }

            document.getElementById("selected-addons").value = JSON.stringify(selectedAddons);
        }


        document.querySelectorAll(".input_price_selector").forEach(select => {
            select.addEventListener("change", updateAddonTotal);
        });


        updateAddonTotal();
    });


</script>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Function to update summary fields
        function updateSummary() {
            document.getElementById("summary-name").textContent = document.getElementById("name").value || "---";
            document.getElementById("summary-email").textContent = document.getElementById("email").value || "---";
            document.getElementById("summary-country").textContent = document.getElementById("country").value || "---";
            document.getElementById("summary-phone").textContent =
             (document.getElementById("phone").value || "---");

            document.getElementById("summary-driver-name").textContent = document.getElementById("driver-name").value || "---";
            document.getElementById("summary-driver-phone").textContent = document.getElementById("get-driver-mobile-number").value || "---";
            document.getElementById("summary-driver-id").textContent = document.getElementById("driver-ic-number").value || "---";
            document.getElementById("summary-driver-license").textContent = document.getElementById("driver-license-number").value || "---";

            document.getElementById("summary-age").textContent = document.getElementById("user-age").value || "---";
            document.getElementById("summary-heard-from").textContent = document.getElementById("heard-from-id").value || "---";
            document.getElementById("summary-note").textContent = document.getElementById("note").value || "---";
        }

        // Attach event listeners to input fields
        document.querySelectorAll("#name, #email, #country, #phone-number, #country-code, #driver-name, #get-driver-mobile-number, #driver-ic-number, #driver-license-number, #user-age, #heard-from-id, #note").forEach(input => {
            input.addEventListener("input", updateSummary);
        });

        // Also update summary when country code changes
        {{--  document.getElementById("country-code").addEventListener("change", updateSummary);  --}}
    });



    </script>

@endsection
