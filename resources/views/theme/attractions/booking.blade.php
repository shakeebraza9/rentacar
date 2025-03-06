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
                                                $selectedDateFormate = date('j F Y, l', strtotime($selectedDate));
                                            echo $selectedDateFormate;
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
                        <div class="card bg-gradient shadow-sm rounded mt-2" id="infoCard" style="display: none;">
                            <div class="card-body">
                                <h4 class="mt-3 mb-0">YOUR INFORMATION</h4>
                                <hr class="bg-primary">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Name:</th>
                                            <td class="text-end" id="info-name"></td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td class="text-end" id="info-email"></td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number:</th>
                                            <td class="text-end" id="info-phone"></td>
                                        </tr>
                                        <tr>
                                            <th>Country:</th>
                                            <td class="text-end" id="info-country"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-7 mt-5 mt-md-0">
                        <h4>YOUR INFORMATION</h4>

                        <hr>
                        <form method="post" accept-charset="utf-8">

                            <div class="step step-1">
                                <h3>Step 1: Personal Details & Add-ons</h3>

                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="name" name="name" placeholder="Full Name as per ID/Passport" required>
                                </div>

                                <!-- Email & Phone -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" id="email" type="email" name="email" placeholder="e.g. john_doe@gmail.com" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone-number">Phone Number</label>
                                        <div class="input-group">
                                            <select class="form-select" name="country_code" id="country_code" required style="width: auto;">
                                                <option value="+1">+1 (USA)</option>
                                                <option value="+44">+44 (UK)</option>
                                                <option value="+60">+60 (Malaysia)</option>
                                                <option value="+92">+92 (Pakistan)</option>
                                                <option value="+91">+91 (India)</option>
                                            </select>
                                            <input class="form-control" type="tel" name="phone_number" id="phone_number" placeholder="1234567890" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Country Selection -->
                                <div class="mb-3">
                                    <label for="country">Country of Origin</label>
                                    <select class="form-select" id="country" name="country" required>
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
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Add-On</th>
                                                        <th>Price</th>
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
                                                                <select name="addons[{{ $index }}][quantity]" class="form-control addon-quantity"
                                                                    data-price="{{ $addon['price'] }}">
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

                                            <!-- Total Amount Display -->
                                            <h4>Total: RM <span id="totalPrice">0.00</span></h4>
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
                                                    <td class="fw-bold text-end">RM {{ number_format($adultQuantity * $adultPrice, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="small">{{ $childQuantity }}x</span> Child(s)</td>
                                                    <td class="fw-bold text-end">RM {{ number_format($childQuantity * $childPrice, 2) }}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Discount</td>
                                                    <th class="text-end text-danger discount_value">-RM {{ number_format(getset('discount_value_Ticket'), 2) }}</th>
                                                </tr>
                                                <tr>
                                                    <td>Add-ons</td>
                                                    <td class="fw-bold text-end"><span id="totalAddon">RM 0.00</span></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-primary" style="font-size: 18px;">Grand Total</th>
                                                    @php
                                                        $totalGrand = ($adultQuantity * $adultPrice) + ($childQuantity * $childPrice) - getset('discount_value_Ticket');
                                                    @endphp
                                                    <th class="text-end" style="font-size: 18px;">RM <span id="total">{{ number_format($totalGrand, 2) }}</span></th>
                                                </tr>
                                                <tr>
                                                    <td><h5>Pay Full</h5></td>
                                                    <th class="text-end text-danger discount_value">
                                                        <button type="button" class="btn btn-primary" id="payNow">
                                                            Pay RM <span id="fullAmount">{{ number_format($totalGrand, 2) }}</span>
                                                        </button>

                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>

                                <button type="button" class="btn btn-secondary prev-step">Back</button>
                                <button type="button" class="btn btn-primary next-step">Next Step</button>
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
    $(document).ready(function () {
        $(".next-step").click(function () {
            let currentStep = $(this).closest(".step");
            let isValid = true;

            currentStep.find("input[required], select[required]").each(function () {
                if (!$(this).val()) {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            if (isValid) {
                currentStep.hide();
                let nextStep = currentStep.next(".step");
                nextStep.show();

                if (nextStep.hasClass("step-2")) {
                    $("#info-name").text($("#name").val());
                    $("#info-email").text($("#email").val());
                    $("#info-phone").text($("#country_code").val() + "-" + $("#phone_number").val());
                    $("#info-country").text($("#country").val());
                    $("#infoCard").fadeIn();

                    // Next Step button hide kar do
                    nextStep.find(".next-step").hide();
                }
            }
        });

        $(".prev-step").click(function () {
            let currentStep = $(this).closest(".step");
            currentStep.hide().prev(".step").show();

            if (currentStep.hasClass("step-2")) {
                $("#infoCard").fadeOut();
                // Wapis Next button show kar do agar user peechay jaye
                $(".step-2 .next-step").show();
            }
        });

        $("input[required], select[required]").on("input change", function () {
            if ($(this).val()) {
                $(this).removeClass("is-invalid");
            }
        });
    });



    document.addEventListener("DOMContentLoaded", function () {
        function calculateTotal() {
            let totalAddon = 0;


            document.querySelectorAll(".addon-quantity").forEach(function (select) {
                let quantity = parseInt(select.value) || 0;
                let price = parseFloat(select.getAttribute("data-price")) || 0;
                totalAddon += quantity * price;
            });


            let adultTotal = parseFloat("{{ $adultQuantity * $adultPrice }}");
            let childTotal = parseFloat("{{ $childQuantity * $childPrice }}");
            let discount = parseFloat("{{ getset('discount_value_Ticket') }}") || 0;

            let totalGrand = adultTotal + childTotal + totalAddon - discount;


            document.getElementById("totalAddon").textContent = totalAddon.toFixed(2);
            document.getElementById("totalPrice").textContent = totalGrand.toFixed(2);
            document.getElementById("fullAmount").textContent = totalGrand.toFixed(2);
        }

        document.querySelectorAll(".addon-quantity").forEach(function (select) {
            select.addEventListener("change", calculateTotal);
        });


        calculateTotal();
    });


    $(document).ready(function () {
        $("#payNow").click(function () {
            let orderData = {
                _token: "{{ csrf_token() }}",
                name: $("#name").val(),
                email: $("#email").val(),
                phone_number: $("#phone_number").val(),
                country_code: $("#country_code").val(),
                country: $("#country").val(),
                heard_from: $("select[name='heard_from']").val(),
                promo_code: $("#promo-code").val(),
                adult_quantity: "{{ $adultQuantity }}",
                child_quantity: "{{ $childQuantity }}",
                ticket_id: "{{ $ticket->id }}",
                ticket_date: "{{ $selectedDate }}",
                discount: "{{ getset('discount_value_Ticket') }}",
                total_amount: $("#total").text(),
                addons: []
            };

            // Loop through all add-ons and add them to the order
            $(".addon-quantity").each(function () {
                let quantity = parseInt($(this).val()) || 0;
                if (quantity > 0) {
                    orderData.addons.push({
                        name: $(this).siblings("input[name^='addons'][name$='[name]']").val(),
                        price: $(this).siblings("input[name^='addons'][name$='[price]']").val(),
                        quantity: quantity
                    });
                }
            });

            // Send AJAX request to place the order
            $.ajax({
                url: "/place-order-ticket",
                type: "POST",
                data: orderData,
                success: function (response) {
                    if (response.status === "success") {

                        window.location.href = "/checkoutticket/" + response.order_id;
                    } else {
                        alert(response.message); // Show error message if order fails
                    }
                },
                error: function () {
                    alert("An error occurred while placing your order. Please try again.");
                }
            });
        });
    });


</script>
@endsection
