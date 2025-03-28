
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
@php
use Carbon\Carbon;
use App\Helpers\PeakSeasonHelper;

$pickupDateTime2 = Carbon::parse($pickupDateTime);
$returnDateTime2 = Carbon::parse($returnDateTime);

$totalHours = $pickupDateTime2->diffInHours($returnDateTime2);
$extraHours = max(0, $totalHours - 24);
$baseHours = 24;
$extraCharge = 0;
$sellingPrice = $product->selling_price;
$price = $product->price;
$extra_hour = $global_d['extra_hour'] ?? 0;

@endphp



<div class="booking-main-container my-7">
    <div class="container my-4">
        @if($numberOfRecords > 0)
      <div class="row ">
        <div class="col-md-4">
          <div class="card ">

            <div class="card-img-top" style="background-color:#DEEBEA">
                <img src="{{ asset($product->get_thumbnail->path)  }}"
                    class="img-fluid"
                    alt="MRR HOLIDAYS Car Rental in Langkawi Sedan Toyota Vios New Variant 1.5 (A)">
            </div>
            <div class="card-body">
                <h5 class="text-center">{{ $product->title  }} </h5>
                <ul class="list-fleet-specs">
                    <?php foreach ($product->productDetails as $detail): ?>
                                                <li>
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars(ucwords(str_replace('_', ' ', htmlspecialchars($detail->key_title))) ) ?>" class="icon">
                                                        <img src="{{ asset('theme/asset/img/icon/' . $detail->key_title . '.svg') }}" class="img-fluid" alt="">
                                                    </span>
                                                    <?= htmlspecialchars($detail->value) ?>
                                                </li>
                <?php endforeach; ?>
                </ul>
                <hr>
                <div class="row">
                    <div class="col-md">
                        <span class="text-muted fw-bold d-block">From</span>
                        <span class="text-muted fw-bold">RM <h4 class="d-inline-block">

                            @php
                            if ($totalHours > 24) {
                                $fullDays = floor($totalHours / 24);
                                $remainingHours = $totalHours % 24;

                                $extraCharge = $sellingPrice * ($fullDays - 1); // Base day included, extra days charged

                                if ($remainingHours >= 1 && $remainingHours <= 5) {
                                    $hourlyCharge = ($sellingPrice * ($remainingHours * $extra_hour)) / 100;
                                    $extraCharge += $hourlyCharge;
                                } elseif ($remainingHours > 5) {
                                    $extraCharge += $sellingPrice; // Add one more day charge
                                }
                            }

                            $sellingPrice += $extraCharge;
                            $price += $extraCharge;
                            $peakseasonprice = PeakSeasonHelper::getPrice($product->type, $pickupDateTime2->format('Y-m-d'), $returnDateTime2->format('Y-m-d'));
                            $price += $peakseasonprice;
                            $sellingPrice += $peakseasonprice;
                            @endphp
                                <del>{{  $price }}</del></h4></span><br>
                        <span class="text-danger fw-bold">RM <h4 class="d-inline-block">{{ $sellingPrice }}
                            </h4></span>
                    </div>
                    <div class="col-md-auto my-auto btnBooking_area">
                        <div class="fw-bold text-danger text-end">
                            <?= htmlspecialchars($product->stock) ?> unit left! </div>
                            <div class="row">

                                <a href="{{ route('customers.orders', [
                                    'slug' => $product->slug,
                                    'today' => $pickupDateTime,
                                    'from' => $returnDateTime,
                                    'pickup_location' => $pickupLocation,
                                    'return_location' => $returnLocation
                                ]) }}" class="btn btn-primary">Book Now</a>



                            </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-8  ">
  <div class="booking-nn-ct-right">
    <section class="booking-form-bk32">
      <div class="container">
        @include('theme.filter')
      </div>
    </section>
    <div class="similar-product">
        <div class="hd-smlr-pd">
            <h3>Similar Listings</h3>
        </div>
        <div class="row">
            @foreach ($similarProducts as $similarProduct)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-img-top" style="background-color:#DEEBEA">
                        <img src="{{ asset( $similarProduct->get_thumbnail->path) }}"
                            class="img-fluid"
                            alt="{{ $similarProduct->title }}">
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">{{ $similarProduct->title }}</h5>
                        <ul class="list-fleet-specs">
                            <?php foreach ($similarProduct->productDetails as $detail): ?>
                                                <li>
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars(ucwords(str_replace('_', ' ', htmlspecialchars($detail->key_title))) ) ?>" class="icon">
                                                        <img src="{{ asset('theme/asset/img/icon/' . $detail->key_title . '.svg') }}" class="img-fluid" alt="">
                                                    </span>
                                                    <?= htmlspecialchars($detail->value) ?>
                                                </li>
                                            <?php endforeach; ?>
                        </ul>
                        <hr>

                        @php
                        $similarProductBasePrice = $similarProduct->price;
                        $similarProductSellingPrice = $similarProduct->selling_price;
                        $extraCharge = 0;
                        $extraCharge = 0;

                        if ($totalHours > 24) {
                            $fullDays = floor($totalHours / 24);
                            $remainingHours = $totalHours % 24;

                            // Base full day charges (excluding first day)
                            $extraCharge += $similarProductSellingPrice * ($fullDays - 1);

                            if ($remainingHours >= 1 && $remainingHours <= 5) {
                                // 10% per hour for 1–5 hrs
                                $hourlyCharge = ($similarProductSellingPrice * ($remainingHours * $extra_hour)) / 100;
                                $extraCharge += $hourlyCharge;
                            } elseif ($remainingHours > 5) {
                                // Add 1 extra day charge for >5 hrs
                                $extraCharge += $similarProductSellingPrice;
                            }
                        }


                        // Final calculated prices
                        $similarProductFinalPrice = $similarProductBasePrice + $extraCharge;
                        $similarProductFinalSellingPrice = $similarProductSellingPrice + $extraCharge;

                        $peakseasonpricemul = PeakSeasonHelper::getPrice($similarProduct->type, $pickupDateTime2->format('Y-m-d'), $returnDateTime2->format('Y-m-d'));
                        $similarProductFinalPrice += $peakseasonpricemul;
                        $similarProductFinalSellingPrice += $peakseasonpricemul;

                        @endphp

                        <div class="row">
                            <div class="col-md">
                                <span class="text-muted fw-bold d-block">From</span>
                                <span class="text-muted fw-bold">RM
                                    <h4 class="d-inline-block">
                                        <del>{{ number_format($similarProductFinalPrice, 2) }}</del>
                                    </h4>
                                </span><br>
                                <span class="text-danger fw-bold">RM
                                    <h4 class="d-inline-block">{{ number_format($similarProductFinalSellingPrice, 2) }}</h4>
                                </span>
                            </div>
                            <div class="col-md-auto my-auto btnBooking_area">
                                <div class="fw-bold text-danger text-end">
                                    {{ $similarProduct->stock > 0 ? $similarProduct->stock . ' units left!' : 'Out of stock' }}
                                </div>
                                <div class="row">
                                    <?php
                                        $today = date('Y-m-d H:i:s');

                                        $nextDay = date('Y-m-d H:i:s', strtotime('+1 day'));
                                        ?>
                                        <a href="{{ route('customers.orders', [
                                            'slug' => $similarProduct->slug,
                                            'today' => $pickupDateTime,
                                            'from' => $returnDateTime,
                                            'pickup_location' => $pickupLocation,
                                            'return_location' => $returnLocation
                                        ]) }}" class="btn btn-primary">Book Now</a>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

  </div>
        </div>
      </div>
      @else
      <div class="no-car-found text-center p-5 mt-4" style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 10px;">
          <h3 class="text-danger">No cars found</h3>
          <p class="text-muted">Currently, there are no similar cars available for booking.</p>
      </div>
  @endif
    </div>

  </div>

  @endsection
  @section('js')
  <script>

    function convertTime(elementId) {
        let timeStr = document.getElementById(elementId).value.trim();
        let regex = /(\d{1,2}):(\d{2})(?::(\d{2}))?\s*(AM|PM)/i;
        let parts = timeStr.match(regex);

        if (!parts) {
            console.error("Time format is invalid:", timeStr);
            return timeStr;
        }

        let hours = parseInt(parts[1], 10);
        let minutes = parseInt(parts[2], 10);
        let seconds = parts[3] ? parseInt(parts[3], 10) : 0;
        let period = parts[4].toUpperCase();
        if (period === 'PM' && hours < 12) {
            hours += 12;
        }
        if (period === 'AM' && hours === 12) {
            hours = 0;
        }
        let hStr = hours.toString().padStart(2, '0');
        let mStr = minutes.toString().padStart(2, '0');
        let sStr = seconds.toString().padStart(2, '0');

        return `${hStr}:${mStr}:${sStr}`;
    }
    document.getElementById("bookingForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Form ka default submit behavior rokna
        let pickupLocation = document.getElementById("input_pickup").value;
        let returnLocation = document.getElementById("input_return").value;
        let pickupDate = document.getElementById("pickup_date").value;
        let returnDate = document.getElementById("return_date").value;


        let formData = {
            pickup_location: pickupLocation,
            return_location: returnLocation,
            pickup_date: pickupDate,
            pickup_time: convertTime("start-time"),
            return_date: returnDate,
            return_time: convertTime("end-time")
        };

     let encodedData = encodeURIComponent(JSON.stringify(formData));
        let redirectUrl = "{{ url('/bookingfilter') }}/" + encodedData;
        window.location.href = redirectUrl;
    });

    flatpickr("#pickup_date", {
        altInput: true,
        altFormat: "j M Y",
        dateFormat: "Y-m-d",
        defaultDate: ["today"],
        minDate: "today",
        disableMobile: "true"

    });
    flatpickr("#return_date", {
        altInput: true,
        altFormat: "j M Y",
        dateFormat: "Y-m-d",
        defaultDate: ["today"],
        minDate: "today",
        disableMobile: "true"

    });

        document.addEventListener("DOMContentLoaded", function() {
            let diffLocCheckbox = document.getElementById("diff_loc");
            let returnCol = document.getElementById("return_col");
            let locationmaindiv = document.getElementById("locationmaindiv");
            let input_pickup = document.getElementById("pickup_col");

            diffLocCheckbox.addEventListener("change", function() {
                if (this.checked) {
                    returnCol.classList.remove("d-none");
                    returnCol.style.setProperty("position", "fixed", "important");
                    returnCol.style.setProperty("right", "43%", "important");
                    returnCol.style.setProperty("width", "10%", "important");
                    input_pickup.style.setProperty("width", "10%", "important");
                    locationmaindiv.style.setProperty("display", "flex", "important");
                    locationmaindiv.style.setProperty("justifyContent", "space-between", "important");
                    locationmaindiv.style.setProperty("width", "40%", "important");



                } else {
                    returnCol.classList.add("d-none");

            // Remove applied styles
            returnCol.style.removeProperty("position");
            returnCol.style.removeProperty("right");
            returnCol.style.removeProperty("width");

            input_pickup.style.removeProperty("width");

            locationmaindiv.style.removeProperty("display");
            locationmaindiv.style.removeProperty("justify-content");
            locationmaindiv.style.removeProperty("width");
                }
            });
        });

</script>
  @endsection
