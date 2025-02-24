@extends('admin.layout')
@section('css')
@php
use Carbon\Carbon;
@endphp

<style>

    table td{
        /* border: 1px solid lightgray; */
    }

    table th{
        /* border: 1px solid lightgray; */
    }

    @media (max-width: 767px){
        .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {

            overflow: scroll!important;
        }
    }


    .dataTables_filter{
        display: none!important;
    }
    button {
        padding: 8px 12px;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, opacity 0.3s;
    }

    #pickupCarBtn {
        background-color: green;
    }

    #deliverCarBtn {
        background-color: blue;
    }

    /* Disable Button Styling */
    button:disabled {
        background-color: lightgray !important;
        cursor: not-allowed;
        opacity: 0.6;
        color: black;
    }

    /* Remove hover effect for disabled buttons */
    button:disabled:hover {
        background-color: lightgray !important;

    }

</style>
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">(#{{$data->id}})
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div>
    <div style="display: flex; gap: 10px;">
        <!-- 30% Section for Product Information -->
        <div style="width: 30%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
            <h3>Product Information</h3>
            <div style="text-align: center; margin-bottom: 10px;">
                <img src="{{ asset($data->product->get_thumbnail->path) ?? asset('placeholder.jpg') }}" alt="Product Image" style="width: 100%; max-width: 200px; height: auto; border-radius: 8px;">
            </div>
            <p><strong>Product Name:</strong> {{ $data->product->title ?? 'N/A' }}</p>
            <p><strong>Price:</strong> {{ $data->product->selling_price ?? 'N/A' }}</p>
            <p><strong>Description:</strong> {!! $data->product->description ?? 'N/A' !!}</p>

            <hr style="margin: 15px 0; border: 0; border-top: 1px solid #ddd;">

            <h3>User Information</h3>
            @if ($data->user)
                <p><strong>Name:</strong> {{ $data->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $data->user->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $data->user->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $data->user->address ?? 'N/A' }}</p>
            @else
                <p>No user information found.</p>
            @endif
            @php

            $pickup = Carbon::parse($data->pickup_car_date);
            $delivery = Carbon::parse($data->deliver_car_date);
            $diff = $pickup->diff($delivery);

            $pickupDays = $diff->d;
            $pickupHours = $diff->h;
            $pickupMinutes = $diff->i;
            $pickupSeconds = $diff->s;

            $totalElapsedHours = ($pickupDays * 24) + $pickupHours + ($pickupMinutes / 60) + ($pickupSeconds / 3600);

            $elapsedTime = "{$pickupDays} days, {$pickupHours} hours, {$pickupMinutes} minutes, {$pickupSeconds} seconds";

            $to_date = Carbon::parse($data->to_date);
            $from_date = Carbon::parse($data->from_date);
            $clientDiff = $to_date->diff($from_date);

            $clientDays = $clientDiff->d;
            $clientHours = $clientDiff->h;
            $clientMinutes = $clientDiff->i;
            $clientSeconds = $clientDiff->s;

            $totalClientElapsedHours = ($clientDays * 24) + $clientHours + ($clientMinutes / 60) + ($clientSeconds / 3600);

            $figelapsedTime = "{$clientDays} days, {$clientHours} hours, {$clientMinutes} minutes, {$clientSeconds} seconds";
            @endphp




        <h4 style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 10px;">Client Date Information</h4>

        <table border="1" width="100%" style="border-collapse: collapse; text-align: center; font-family: Arial, sans-serif; border: 2px solid #ddd;">
            <thead>
                <tr style="background-color: #f4f4f4; color: #333; font-weight: bold;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Client To Date</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Client From Date</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Elapsed Time</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #fff;">
                    <td style="padding: 10px; border: 1px solid #ddd; color: #333;">{{ $to_date->format('Y-m-d H:i:s') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; color: #333;">{{ $from_date->format('Y-m-d H:i:s') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: green;">{{ $figelapsedTime }}</td>
                </tr>
            </tbody>
        </table>

        @php
        $pickuptostring = $pickup->toIso8601String();

    @endphp
            @if($data->payment_status == 1 && $data->status == 'apporve')

                <div style="margin-top: 10px;">


                    <button id="pickupCarBtn"
                            data-update-route="{{ route('admin.orders.updatePickupDeliver', Crypt::encryptString($data->id)) }}"
                            @if($data->pickup_car_date) disabled @endif>
                        Pickup Car
                    </button>

                    <button id="deliverCarBtn"
                            data-update-route="{{ route('admin.orders.updatePickupDeliver', Crypt::encryptString($data->id)) }}"
                            @if(!$data->pickup_car_date || $data->deliver_car_date) disabled @endif>
                        Deliver Car
                    </button>



                    <p id="countup" style="margin-top: 10px; font-weight: bold;"
                    data-basetime="{{ !is_null($data->pickup_car_date) ?  $pickuptostring  :'0:0:0:0:0' }}" data-stop="{{ !is_null($data->deliver_car_date) ?  1  :'0'  }}">
                        Elapsed Time: 0h 0m 0s
                    </p>


                    @if($data->pickup_car_date != NULL && $data->deliver_car_date != NULL)


                    <h4 style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 10px;">Pickup & Delivery Information</h4>

                    <table border="1" width="100%" style="border-collapse: collapse; text-align: center; font-family: Arial, sans-serif; border: 2px solid #ddd;">
                        <thead>
                            <tr style="background-color: #f4f4f4; color: #333; font-weight: bold;">
                                <th style="padding: 10px; border: 1px solid #ddd;">Pickup Date</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Delivery Date</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Elapsed Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color: #fff;">
                                <td style="padding: 10px; border: 1px solid #ddd; color: #333;">{{ $pickup->format('Y-m-d H:i:s') }}</td>
                                <td style="padding: 10px; border: 1px solid #ddd; color: #333;">{{ $delivery->format('Y-m-d H:i:s') }}</td>
                                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: green;">{{ $elapsedTime }}</td>
                            </tr>
                        </tbody>
                    </table>


                @endif
            </div>

        @endif
        </div>


        <!-- 70% Section for Order Details -->
        <div style="width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
            <h3>Edit Order</h3>
            <form method="POST" action="{{ route('admin.orders.update', Crypt::encryptString($data->id)) }}">
                @csrf
                @method('PUT')
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="buyer_name" style="display: block; margin-bottom: 5px;">Buyer Name</label>
                        <input type="text" id="buyer_name" name="buyer_name" value="{{ $data->buyer_name }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="buyer_email" style="display: block; margin-bottom: 5px;">Buyer Email</label>
                        <input type="email" id="buyer_email" name="buyer_email" value="{{ $data->buyer_email }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="passport" style="display: block; margin-bottom: 5px;">Passport</label>
                        <input type="text" id="passport" name="passport" value="{{ $data->passport }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="license" style="display: block; margin-bottom: 5px;">License</label>
                        <input type="text" id="license" name="license" value="{{ $data->license }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="buyer_phone_number" style="display: block; margin-bottom: 5px;">Phone Number</label>
                        <input type="text" id="buyer_phone_number" name="buyer_phone_number" value="{{ $data->buyer_phone_number }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="buyer_country_of_origin" style="display: block; margin-bottom: 5px;">Country of Origin</label>
                        <input type="text" id="buyer_country_of_origin" name="buyer_country_of_origin" value="{{ $data->buyer_country_of_origin }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="buyer_sec_name" style="display: block; margin-bottom: 5px;">Secondary Name</label>
                        <input type="text" id="buyer_sec_name" name="buyer_sec_name" value="{{ $data->buyer_sec_name }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="buyer_sec_phone_number" style="display: block; margin-bottom: 5px;">Secondary Phone</label>
                        <input type="text" id="buyer_sec_phone_number" name="buyer_sec_phone_number" value="{{ $data->buyer_sec_phone_number }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="driver_name" style="display: block; margin-bottom: 5px;">Driver Name</label>
                        <input type="text" id="driver_name" name="driver_name" value="{{ $data->driver_name }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="driver_license_number" style="display: block; margin-bottom: 5px;">Driver License</label>
                        <input type="text" id="driver_license_number" name="driver_license_number" value="{{ $data->driver_license_number }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="from_date" style="display: block; margin-bottom: 5px;">From Date & Time</label>
                        <input type="datetime-local" id="from_date" name="from_date"
                               value="{{ $data->from_date ? date('Y-m-d\TH:i', strtotime($data->from_date)) : '' }}"
                               style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="to_date" style="display: block; margin-bottom: 5px;">To Date & Time</label>
                        <input type="datetime-local" id="to_date" name="to_date"
                               value="{{ $data->to_date ? date('Y-m-d\TH:i', strtotime($data->to_date)) : '' }}"
                               style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="status" style="display: block; margin-bottom: 5px;">Status</label>
                        <select id="status" name="status" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="apporve" {{ $data->status == 'apporve' ? 'selected' : '' }}>Apporve</option>


                            <option value="confirmed" {{ $data->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $data->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div style="flex: 1;">
                        <label for="payment_status" style="display: block; margin-bottom: 5px;">Payment Status</label>
                        <select id="payment_status" name="payment_status" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="0" {{ $data->payment_status == 0 ? 'selected' : '' }}>Unpaid</option>
                            <option value="1" {{ $data->payment_status == 1 ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>



                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <div style="flex: 1;">
                        <label for="amount" style="display: block; margin-bottom: 5px;">Amount</label>
                        <input type="text" id="amount" name="amount" value="{{ $data->amount }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div style="flex: 1;">
                        <label for="flight_no" style="display: block; margin-bottom: 5px;">Flight Number</label>
                        <input type="text" id="flight_no" name="flight_no" value="{{ $data->flight_no }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
                <button type="submit" style="padding: 10px 15px; background-color: #28a745; color: #fff; border: none; border-radius: 4px;">Update Order</button>
            </form>

        </div>
    </div>

    @if($data->payment_status == 1 && $data->status != 'pending')
    <h4 style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 10px;">Pickup & Client Date Comparison</h4>

    <table border="1" width="100%" style="border-collapse: collapse; text-align: center; font-family: Arial, sans-serif; border: 2px solid #ddd;">
        <thead>
            <tr style="background-color: #f4f4f4; color: #333; font-weight: bold;">
                <th style="padding: 10px; border: 1px solid #ddd;">Pickup Date</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Delivery Date</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Elapsed Time (Pickup & Delivery)</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Client To Date</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Client From Date</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Elapsed Time (Client)</th>
                @if ($data->extra_amount > 0)

                <th style="padding: 10px; border: 1px solid #ddd;">Extra Emount</th>
                @endif
                <th style="padding: 10px; border: 1px solid #ddd;">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #fff;">
                @if($data->pickup_car_date != NULL && $data->deliver_car_date != NULL)
                <td style="padding: 10px; border: 1px solid #ddd; color: #333;">{{ $pickup->format('Y-m-d H:i:s') }}</td>
                <td style="padding: 10px; border: 1px solid #ddd; color: #333;">{{ $delivery->format('Y-m-d H:i:s') }}</td>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: green;">{{ $elapsedTime }} hours</td>
                @else
                <td style="padding: 10px; border: 1px solid #ddd; color: #333;">-</td>
                <td style="padding: 10px; border: 1px solid #ddd; color: #333;">-</td>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: green;">0 hours</td>

                @endif
                <td style="padding: 10px; border: 1px solid #ddd; color: #333;">{{ $to_date->format('Y-m-d H:i:s') }}</td>
                <td style="padding: 10px; border: 1px solid #ddd; color: #333;">{{ $from_date->format('Y-m-d H:i:s') }}</td>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: green;">{{ $figelapsedTime }} hours</td>

                @if ($data->extra_amount > 0)
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: rgb(249, 10, 10);">{{ $data->extra_amount }}</td>
                @endif
                <td style="padding: 10px; border: 1px solid #ddd;">
                    @if($totalElapsedHours - $totalClientElapsedHours >= 1)
                    <button class="sendMailBtn" data-id="{{ $data->id }}" style="padding: 8px 12px; background-color: red; color: white; border: none; cursor: pointer; border-radius: 5px;">
                        Add Extra Payment
                    </button>
                @else
                    <span style="color: green; font-weight: bold;">No Extra Charge</span>
                @endif
                </td>
            </tr>
        </tbody>
    </table>

    @endif

@endsection
 @section('js')


       <script>
        document.addEventListener("DOMContentLoaded", function () {
            const pickupCarBtn = document.getElementById("pickupCarBtn");
            const deliverCarBtn = document.getElementById("deliverCarBtn");
            const countupDisplay = document.getElementById("countup");

            let startTime = null;
            let timerInterval = null;

            // Get base time and stop flag from dataset
            let baseTime = countupDisplay.dataset.basetime;
            let stopFlag = countupDisplay.dataset.stop;

            console.log("Base Time from dataset:", baseTime);
            console.log("Stop Flag:", stopFlag);

            // If stopFlag is 1, hide the counter
            if (stopFlag === "1") {
                countupDisplay.style.display = "none";
                return;
            }

            if( baseTime =="0:0:0:0:0"){
                countupDisplay.style.display = "none";

            }else{

                countupDisplay.style.display = "block";
            }

            if (baseTime && baseTime !== "0:0:0:0:0") {
                let parsedTime = new Date(baseTime);
                if (!isNaN(parsedTime)) {
                    startTime = parsedTime;
                    localStorage.setItem("pickupTime", startTime.toISOString());
                }
            } else {
                let storedTime = localStorage.getItem("pickupTime");
                if (storedTime) {
                    startTime = new Date(storedTime);
                }
            }

            if (startTime && !isNaN(startTime)) {
                startTimer();
            }

            pickupCarBtn?.addEventListener("click", function () {
                countupDisplay.style.display = "block";
                startTime = new Date();
                localStorage.setItem("pickupTime", startTime.toISOString());
                updateOrder(this.dataset.updateRoute, "pickup_car_date", startTime.toISOString());
                startTimer();
            });

            deliverCarBtn?.addEventListener("click", function () {
                if (startTime) {
                    clearInterval(timerInterval);
                    showElapsedTime(startTime, new Date());
                    localStorage.removeItem("pickupTime");
                }
                updateOrder(this.dataset.updateRoute, "deliver_car_date", new Date().toISOString());
            });

            function startTimer() {
                if (timerInterval) clearInterval(timerInterval);
                timerInterval = setInterval(() => {
                    if (!startTime) return;
                    showElapsedTime(startTime, new Date());
                }, 1000);
            }

            function showElapsedTime(start, end) {
                if (!start || isNaN(start)) return;
                const elapsedMilliseconds = end - start;
                const elapsedSeconds = Math.floor(elapsedMilliseconds / 1000);
                const elapsedMinutes = Math.floor(elapsedSeconds / 60);
                const elapsedHours = Math.floor(elapsedMinutes / 60);
                countupDisplay.textContent = `Elapsed Time: ${elapsedHours}h ${elapsedMinutes % 60}m ${elapsedSeconds % 60}s`;
            }

            function updateOrder(route, field, value) {
                fetch(route, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ field, value }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Car status updated successfully!");
                        if (field === "deliver_car_date") clearInterval(timerInterval);
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });



        $(document).ready(function() {
            $('.sendMailBtn').click(function() {
                let orderId = $(this).data('id');

                $.ajax({
                    url: '/admin/send-extra-payment-email/' + orderId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function() {
                        alert('Failed to send email.');
                    }
                });
            });
        });
    </script>
@endsection
