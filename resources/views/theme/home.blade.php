<?php

use Illuminate\Support\Facades\DB;



?>

@extends('theme.layout')

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



        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
Launch demo modal
</button> -->

        <!-- Modal -->
        <div class="modal fade" id="PromoModal" tabindex="-1" aria-labelledby="PromoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h4 class="modal-title" id="PromoModalLabel">Welcome!</h4>
                        <button type="button" class="btn-close btn-promo-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-4">
                        <div class="text-center">
                            <div id="PromoCaptions" class="carousel slide slider-promo" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#PromoCaptions" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 1"></button>
                                </div>
                                <div class="carousel-inner">
                                    @if (!empty(getset('popup_image')))
                                        <div class="carousel-item active">
                                            <img src="{{ asset(getset('popup_image')) }}" class="img-fluid" alt="">
                                        </div>
                                    @endif
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#PromoCaptions"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#PromoCaptions"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="row">
                            <div class="col">
                                <input type="checkbox" class="promo-toggle"> Do not show this again
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <section class="hero" style="background: url('{{ asset($randomSlider->image->path) }}') !important">

            <div class="container">
                <div class="text-center">
                    <h1 class="text-white mb-0 display-5 fw-bold">{{ $randomSlider->title }}</h1>
                    <h3 class="text-white mb-4 mt-3">{{ $randomSlider->details }}</h3>
                </div>

                <div>
                    <link rel="stylesheet"
                        href="../cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
                    <script
                        src="../cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
                    <link href="../cdn.jsdelivr.net/npm/select2%404.1.0-rc.0/dist/css/select2.min.css"
                        rel="stylesheet" />
                    <script src="../cdn.jsdelivr.net/npm/select2%404.1.0-rc.0/dist/js/select2.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

                    <div class="wrap-search-form">
                        <div class="search-form">
                            <ul class="nav nav-tabs nav-justified pt-3 px-md-3 mb-2 mb-md-0" id="searchTab"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="{{ route('home') }}"><button class="nav-link btn active" id="car-rental-tab"
                                            type="button" role="tab" aria-controls="car-rental"
                                            aria-selected="false"><span class="icon-circle"><i
                                                    class="fa fa-car"></i></span>
                                            <div>Car Rental</div>
                                        </button></a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a href="{{ route('attractions') }}"><button class="nav-link btn " id="experience-tab"
                                            type="button" role="tab" aria-controls="experience"
                                            aria-selected="false"><span class="icon-circle"><i
                                                    class="fa fa-umbrella-beach"></i></span>
                                            <div>Attractions</div>
                                        </button></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link btn disabled " id="hotel-tab" type="button" role="tab"
                                        aria-controls="hotel" aria-selected="false">
                                        <span class="icon-circle">
                                            <span class="soon">COMING SOON</span><i class="fa fa-hotel"></i></span>
                                        <div>Hotel</div>
                                    </button></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link btn disabled" id="chauffeur-tab" data-bs-toggle="tab"
                                        data-bs-target="#chauffeur" type="button" role="tab"
                                        aria-controls="chauffeur" aria-selected="false"><span class="icon-circle">
                                            <span class="soon">COMING SOON</span><i
                                                class="fa fa-user-tie"></i></span>
                                        <div>Chauffeur</div>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content p-3" id="searchTabContent">
                                <div class="tab-pane fade show active" id="car-rental" role="tabpanel"
                                    aria-labelledby="car-rental-tab">

                                    <form method="get" accept-charset="utf-8" id="bookingForm">
                                        <div class="row gx-1 gy-2 gy-md-0">
                                            <div class="col-md-4" style="min-width: 38%;">
                                                <div class="wrapper-location">
                                                    <div id="pickup_col">
                                                        <div class="input-group select2-floating position-relative">
                                                            <span
                                                                class="icon position-absolute top-50 start-0 translate-middle-y"><i
                                                                style="font-size: 20px;
                                                                margin-left: 35px;" class="fa fa-map-marker-alt text-primary"></i></span>
                                                            <label class="small">Select Pickup Locations</label>
                                                            <select class="form-control input-group border-0"
                                                            name="custom_pickup_location" id="input_pickup"
                                                            required>
                                                        @foreach(explode(',', getset('location')) as $location)
                                                            <option value="{{ trim($location) }}">{{ trim($location) }}</option>
                                                        @endforeach
                                                    </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-none mt-2 mt-md-0" id="return_col">
                                                        <div class="input-group select2-floating position-relative">
                                                            <span style="font-size: 20px;margin-left: 16px;"
                                                                class="icon position-absolute top-50 start-0 translate-middle-y"><i
                                                                    class="fa fa-map-marker-alt text-primary"></i></span>
                                                            <label class="small">Select Return</label>
                                                            <select class="form-control input-group border-0"
                                                            name="custom_pickup_location" id="input_return">
                                                            <option value="" selected>Select return location</option>
                                                        @foreach(explode(',', getset('location')) as $location)
                                                            <option value="{{ trim($location) }}">{{ trim($location) }}</option>
                                                        @endforeach
                                                    </select>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#input_pickup').select2();
                                                $('#input_return').select2();
                                            </script>
                                            <div class="col-md">
                                                <div class="row gx-1 gy-2 gy-md-0 input-group-2-col">
                                                    <div class="col-6 col-md pe-md-0">
                                                        <div class="form-floating input-group">
                                                            <span class="input-group-text"><i
                                                                    class="far fa-calendar-alt text-primary"></i></span>
                                                            <input type="text" name="start_date"
                                                                class="form-control pe-0" placeholder="29 Apr 2021"
                                                                id="pickup_date">
                                                            <label class="small">Pickup Date</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md ps-md-0">
                                                        <div class="form-floating input-group">
                                                            <span class="input-group-text"><i
                                                                    class="far fa-clock text-primary"></i></span>
                                                            <!-- <input type="text" name="start_time" class="form-control pe-0" placeholder="10:00 AM" value="10:00 AM" id="pickup_time"> -->
                                                            <select name="start_time" class="form-control pe-0"
                                                                id="start-time">
                                                                <option value="6:00 AM">6:00 AM</option>
                                                                <option value="6:15 AM">6:15 AM</option>
                                                                <option value="6:30 AM">6:30 AM</option>
                                                                <option value="6:45 AM">6:45 AM</option>
                                                                <option value="7:00 AM">7:00 AM</option>
                                                                <option value="7:15 AM">7:15 AM</option>
                                                                <option value="7:30 AM">7:30 AM</option>
                                                                <option value="7:45 AM">7:45 AM</option>
                                                                <option value="8:00 AM">8:00 AM</option>
                                                                <option value="8:15 AM">8:15 AM</option>
                                                                <option value="8:30 AM">8:30 AM</option>
                                                                <option value="8:45 AM">8:45 AM</option>
                                                                <option value="9:00 AM">9:00 AM</option>
                                                                <option value="9:15 AM">9:15 AM</option>
                                                                <option value="9:30 AM">9:30 AM</option>
                                                                <option value="9:45 AM">9:45 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="10:15 AM">10:15 AM</option>
                                                                <option value="10:30 AM">10:30 AM</option>
                                                                <option value="10:45 AM">10:45 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="11:15 AM">11:15 AM</option>
                                                                <option value="11:30 AM">11:30 AM</option>
                                                                <option value="11:45 AM">11:45 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="12:15 PM">12:15 PM</option>
                                                                <option value="12:30 PM">12:30 PM</option>
                                                                <option value="12:45 PM">12:45 PM</option>
                                                                <option value="1:00 PM">1:00 PM</option>
                                                                <option value="1:15 PM">1:15 PM</option>
                                                                <option value="1:30 PM">1:30 PM</option>
                                                                <option value="1:45 PM">1:45 PM</option>
                                                                <option value="2:00 PM">2:00 PM</option>
                                                                <option value="2:15 PM">2:15 PM</option>
                                                                <option value="2:30 PM">2:30 PM</option>
                                                                <option value="2:45 PM">2:45 PM</option>
                                                                <option value="3:00 PM">3:00 PM</option>
                                                                <option value="3:15 PM">3:15 PM</option>
                                                                <option value="3:30 PM">3:30 PM</option>
                                                                <option value="3:45 PM">3:45 PM</option>
                                                                <option value="4:00 PM">4:00 PM</option>
                                                                <option value="4:15 PM">4:15 PM</option>
                                                                <option value="4:30 PM">4:30 PM</option>
                                                                <option value="4:45 PM">4:45 PM</option>
                                                                <option value="5:00 PM">5:00 PM</option>
                                                                <option value="5:15 PM">5:15 PM</option>
                                                                <option value="5:30 PM">5:30 PM</option>
                                                                <option value="5:45 PM">5:45 PM</option>
                                                                <option value="6:00 PM">6:00 PM</option>
                                                                <option value="6:15 PM">6:15 PM</option>
                                                                <option value="6:30 PM">6:30 PM</option>
                                                                <option value="6:45 PM">6:45 PM</option>
                                                                <option value="7:00 PM">7:00 PM</option>
                                                                <option value="7:15 PM">7:15 PM</option>
                                                                <option value="7:30 PM">7:30 PM</option>
                                                                <option value="7:45 PM">7:45 PM</option>
                                                                <option value="8:00 PM">8:00 PM</option>
                                                                <option value="8:15 PM">8:15 PM</option>
                                                                <option value="8:30 PM">8:30 PM</option>
                                                                <option value="8:45 PM">8:45 PM</option>
                                                                <option value="9:00 PM">9:00 PM</option>
                                                                <option value="9:15 PM">9:15 PM</option>
                                                                <option value="9:30 PM">9:30 PM</option>
                                                                <option value="9:45 PM">9:45 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="10:15 PM">10:15 PM</option>
                                                                <option value="10:30 PM">10:30 PM</option>
                                                                <option value="10:45 PM">10:45 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                            </select>
                                                            <label class="small">Pickup Time</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md pe-md-0">
                                                        <div class="form-floating input-group">
                                                            <span class="input-group-text"><i
                                                                    class="far fa-calendar-alt text-primary"></i></span>
                                                            <input type="text" name="end_date"
                                                                class="form-control pe-0" placeholder="29 Apr 2021"
                                                                id="return_date">
                                                            <label class="small">Return Date</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md ps-md-0">
                                                        <div class="form-floating input-group">
                                                            <span class="input-group-text"><i
                                                                    class="far fa-clock text-primary"></i></span>
                                                            <!-- <input type="text" name="end_time" class="form-control pe-0" placeholder="10:00 AM" value="10:00 AM" id="return_time"> -->
                                                            <select name="end_time" class="form-control pe-0"
                                                                id="end-time">
                                                                <option value="6:00 AM">6:00 AM</option>
                                                                <option value="6:15 AM">6:15 AM</option>
                                                                <option value="6:30 AM">6:30 AM</option>
                                                                <option value="6:45 AM">6:45 AM</option>
                                                                <option value="7:00 AM">7:00 AM</option>
                                                                <option value="7:15 AM">7:15 AM</option>
                                                                <option value="7:30 AM">7:30 AM</option>
                                                                <option value="7:45 AM">7:45 AM</option>
                                                                <option value="8:00 AM">8:00 AM</option>
                                                                <option value="8:15 AM">8:15 AM</option>
                                                                <option value="8:30 AM">8:30 AM</option>
                                                                <option value="8:45 AM">8:45 AM</option>
                                                                <option value="9:00 AM">9:00 AM</option>
                                                                <option value="9:15 AM">9:15 AM</option>
                                                                <option value="9:30 AM">9:30 AM</option>
                                                                <option value="9:45 AM">9:45 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="10:15 AM">10:15 AM</option>
                                                                <option value="10:30 AM">10:30 AM</option>
                                                                <option value="10:45 AM">10:45 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="11:15 AM">11:15 AM</option>
                                                                <option value="11:30 AM">11:30 AM</option>
                                                                <option value="11:45 AM">11:45 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="12:15 PM">12:15 PM</option>
                                                                <option value="12:30 PM">12:30 PM</option>
                                                                <option value="12:45 PM">12:45 PM</option>
                                                                <option value="1:00 PM">1:00 PM</option>
                                                                <option value="1:15 PM">1:15 PM</option>
                                                                <option value="1:30 PM">1:30 PM</option>
                                                                <option value="1:45 PM">1:45 PM</option>
                                                                <option value="2:00 PM">2:00 PM</option>
                                                                <option value="2:15 PM">2:15 PM</option>
                                                                <option value="2:30 PM">2:30 PM</option>
                                                                <option value="2:45 PM">2:45 PM</option>
                                                                <option value="3:00 PM">3:00 PM</option>
                                                                <option value="3:15 PM">3:15 PM</option>
                                                                <option value="3:30 PM">3:30 PM</option>
                                                                <option value="3:45 PM">3:45 PM</option>
                                                                <option value="4:00 PM">4:00 PM</option>
                                                                <option value="4:15 PM">4:15 PM</option>
                                                                <option value="4:30 PM">4:30 PM</option>
                                                                <option value="4:45 PM">4:45 PM</option>
                                                                <option value="5:00 PM">5:00 PM</option>
                                                                <option value="5:15 PM">5:15 PM</option>
                                                                <option value="5:30 PM">5:30 PM</option>
                                                                <option value="5:45 PM">5:45 PM</option>
                                                                <option value="6:00 PM">6:00 PM</option>
                                                                <option value="6:15 PM">6:15 PM</option>
                                                                <option value="6:30 PM">6:30 PM</option>
                                                                <option value="6:45 PM">6:45 PM</option>
                                                                <option value="7:00 PM">7:00 PM</option>
                                                                <option value="7:15 PM">7:15 PM</option>
                                                                <option value="7:30 PM">7:30 PM</option>
                                                                <option value="7:45 PM">7:45 PM</option>
                                                                <option value="8:00 PM">8:00 PM</option>
                                                                <option value="8:15 PM">8:15 PM</option>
                                                                <option value="8:30 PM">8:30 PM</option>
                                                                <option value="8:45 PM">8:45 PM</option>
                                                                <option value="9:00 PM">9:00 PM</option>
                                                                <option value="9:15 PM">9:15 PM</option>
                                                                <option value="9:30 PM">9:30 PM</option>
                                                                <option value="9:45 PM">9:45 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="10:15 PM">10:15 PM</option>
                                                                <option value="10:30 PM">10:30 PM</option>
                                                                <option value="10:45 PM">10:45 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                            </select>
                                                            <label class="small">Return Time</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-auto">
                                                <button class="btn btn-primary h-100 w-100 px-3"><i
                                                        class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-auto">
                                                <input type="checkbox" name="use_different_return_location"
                                                    id="diff_loc" value="1">
                                                <label for="diff_loc">Return to another location</label>
                                            </div>
                                        </div>

                                    </form>
                                </div>





                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <section class="mt-5 text-center">
            <div class="container">
                <div class="row gx-xl-10 mb-4">
                    <div class="col">
                        <h2>Rent a car at your fingertips</h2>
                    </div>
                </div>
                <div class="row gx-xl-10">
                    <div class="col-md">
                        <div class="shadow p-3 d-inline-block rounded-3 mb-3 mb-md-4 box-icon">
                            <img src="theme/asset/img/icon/icon-choose-car.svg" class="img-fluid" alt="">
                        </div>
                        <h3>Search & Explore</h3>
                        <div>Find vehicles and get quotes that suits your budget and style.</div>
                    </div>

                    <div class="col-md mt-4 mt-md-0">
                        <div class="shadow p-3 d-inline-block rounded-3 mb-3 mb-md-4 box-icon">
                            <img src="theme/asset/img/icon/icon-payment-secure.svg" class="img-fluid" alt="">
                        </div>
                        <h3>Book & Pay</h3>
                        <div>Select and confirm your dates and book securely.</div>
                    </div>

                    <div class="col-md mt-4 mt-md-0">
                        <div class="shadow p-3 d-inline-block rounded-3 mb-3 mb-md-4 box-icon">
                            <img src="theme/asset/img/icon/icon-car.svg" class="img-fluid" alt="">
                        </div>
                        <h3>Travel & Enjoy</h3>
                        <div>Collect your car and live like a local anywhere Langkawi.</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="my-7">
            <div class="container">
                <h2 class="text-center text-primary p-3">Our Vehicles</h2>

                @php
                    // Clean and normalize type before grouping
                    $products = $products->map(function ($product) {
                        $product->type = strtolower(trim($product->type)); // Normalize type
                        return $product;
                    });

                    $vehicleTypes = $products->groupBy('type'); // Group by cleaned type
                @endphp

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="vehicleTabs" role="tablist">
                    @foreach($vehicleTypes as $type => $vehicles)
                        @php
                            $typeSlug = Str::slug($type);
                        @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if ($loop->first) active @endif"
                                    id="tab-{{ $typeSlug }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#content-{{ $typeSlug }}"
                                    type="button"
                                    role="tab"
                                    aria-controls="content-{{ $typeSlug }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ Str::title(str_replace('_', ' ', $type)) }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <div class="tab-content" id="vehicleTabContent">
            @foreach($vehicleTypes as $type => $vehicles)
                @php
                    $typeSlug = Str::slug($type);
                @endphp
                <div class="tab-pane fade @if ($loop->first) show active @endif mb-5"
                     id="content-{{ $typeSlug }}"
                     role="tabpanel"
                     aria-labelledby="tab-{{ $typeSlug }}">
                    <div class="container mt-3">
                        <div class="row gy-4">
                            @foreach($vehicles as $product)
                                <div class="col-md-3">
                                    <div class="card">
                                        @if(!empty($product->discount_text))
                                        <div class="label-fleet-deals text-uppercase">
                                            {{ htmlspecialchars($product->discount_text) }}
                                        </div>
                                        @endif

                                        <div class="card-img-top" style="background-color:#DEEBEA">
                                            @if($product->get_thumbnail)
                                                <img src="{{ asset($product->get_thumbnail->path) }}"
                                                     alt="{{ htmlspecialchars($product->title) }}"
                                                     class="img-fluid">
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h5 class="text-center">{{ htmlspecialchars($product->title) }}</h5>
                                            <ul class="list-fleet-specs">
                                                @foreach ($product->productDetails as $detail)
                                                    <li>
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                              title="{{ htmlspecialchars(ucwords(str_replace('_', ' ', $detail->key_title))) }}"
                                                              class="icon">
                                                            <img src="{{ asset('theme/asset/img/icon/' . $detail->key_title . '.svg') }}"
                                                                 class="img-fluid" alt="">
                                                        </span>
                                                        {{ htmlspecialchars($detail->value) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md">
                                                    <span class="text-muted fw-bold d-block">From</span>
                                                    <span class="text-muted fw-bold">RM
                                                        <h4 class="d-inline-block">
                                                            <del>{{ number_format($product->price, 2) }}</del>
                                                        </h4>
                                                    </span><br>
                                                    <span class="text-danger fw-bold">RM
                                                        <h4 class="d-inline-block">{{ number_format($product->selling_price, 2) }}</h4>
                                                    </span>
                                                </div>
                                                <div class="col-md-auto my-auto btnBooking_area">
                                                    <div class="fw-bold text-danger text-end">
                                                        @if(!empty($product->discount_text))
                                                        {{ $product->stock }} unit left!
                                                        @endif
                                                    </div>
                                                    <div class="row">
                                                        @php
                                                            $today = now()->format('Y-m-d H:i:s');
                                                            $nextDay = now()->addDay()->format('Y-m-d H:i:s');
                                                        @endphp
                                                        <a href="{{ route('booking', ['slug' => $product->slug, 'today' => $today, 'from' => $nextDay]) }}"
                                                           class="btn btn-primary">
                                                            Book Now
                                                        </a>
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
            @endforeach
        </div>




<section class="mt-5 bg-light py-4">
    <h2 class="text-center text-primary mt-3">Our Reviews</h2>
    <div class="slider-review">
        @foreach($reviews as $review)
        <div class="m-3">
            <div class="card rounded-3 shadow-sm h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <!-- Product Image -->
                            <img src="{{ asset( $review->image_path) }}"
                                 class="img-fluid w-100"
                                 alt="{{ $review->product->title }}"
                                 loading="lazy">
                            <div class="text-center mt-3">
                                <div class="stars">
                                    <!-- Display Star Rating -->
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star fa-1x {{ $i <= $review->star ? 'text-primary' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 position-relative">
                            <div class="mb-7">
                                <!-- Review Text -->
                                <p class="" id="review-{{ $review->id }}">
                                    {{ Str::limit($review->review, 100) }}
                                </p>
                                @if(strlen($review->review) > 100)
                                <button class="btn btn-sm btn-light btn-toggle-collapse mt-3"
                                        data-id="{{ $review->id }}"
                                        data-value="{{ $review->review }}">
                                    Show more
                                </button>
                                @endif
                            </div>
                            <!-- Reviewer Information -->
                            <div class="fst-italic text-muted position-absolute bottom-0 end-0 p-3">
                                By {{ $review->user->name }}
                                @if (!empty($review->user->country_code))
                                <span class="flag-icon flag-icon-{{ strtolower($review->user->country_code) }}"></span>
                                @endif
                                <br>
                                <span class="small text-dark">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Name -->
                <div class="card-footer text-center">
                    {{ $review->product->title }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>


       <section class="my-5">
            <div class="container">
                <h2 class="text-center text-primary mt-3">News & Promotions</h2>

                <div class="row gx-lg-8 mt-4 mt-md-5">
                    <?php
                    $blogs = collect($blogs)->shuffle();


                    $bigBlog = $blogs->shift();
                    ?>

                    <div class="row gx-lg-8 mt-4 mt-md-5">
                        {{-- Big Image --}}
                        <div class="col-md-6 order-md-2">
                            <img src="<?php echo $bigBlog->image_path; ?>" class="img-fluid" alt="">
                            <h5 class="mt-3">
                                <a href="blogs/<?php echo $bigBlog->slug; ?>" class="link-dark"><?php echo $bigBlog->title; ?></a>
                            </h5>
                            <div class="mb-1">
                                <a href="blogs/<?php echo $bigBlog->slug; ?>" class="text-dark">
                                    <?php echo substr($bigBlog->description, 0, 200); ?>...
                                </a>
                            </div>
                            <a href="blogs/<?php echo $bigBlog->slug; ?>" class="btn btn-light btn-sm">Read more</a>
                        </div>

                        {{-- Small Images --}}
                        <div class="col-md-6 mt-4 mt-md-0 d-flex flex-column gap-4 order-md-1">
                            <?php foreach ($blogs as $blog): ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?php echo $blog->image_path; ?>" style="height: 120px; width: 100%; object-fit: cover;" class="img-fluid" alt="">
                                </div>
                                <div class="col-md">
                                    <h5 class="mt-3 mt-md-0">
                                        <a href="blogs/<?php echo $blog->slug; ?>" class="link-dark"><?php echo $blog->title; ?></a>
                                    </h5>
                                    <div class="mb-1">
                                        <a href="blogs/<?php echo $blog->slug; ?>" class="text-dark">
                                            <?php echo substr($blog->description, 0, 100); ?>...
                                        </a>
                                    </div>
                                    <a href="blogs/<?php echo $blog->slug; ?>" class="btn btn-light btn-sm">Read more</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="my-5">
            <div class="container">
                <h2 class="text-center text-primary mt-3">FAQ</h2>

                {!! getFaqsByType('car') !!}
            </div>
        </section>

        <section class="bg-light py-5 text-center">
            <div class="container">
                <img src="img/logo/logo.png" class="img-fluid mx-auto mb-4" style="height:100px" alt="">
                {!! nl2br(getset('footer_text')) !!}
            </div>
        </section>
        <script>



            document.getElementById("bookingForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Form ka default submit behavior rokna
                let pickupLocation = document.getElementById("input_pickup").value;
                let returnLocation = document.getElementById("input_return").value;
                let pickupDate = document.getElementById("pickup_date").value;
                let pickupTime = document.getElementById("start-time").value;
                let returnDate = document.getElementById("return_date").value;
                let returnTime = document.getElementById("end-time").value;

                let formData = {
                    pickup_location: pickupLocation,
                    return_location: returnLocation,
                    pickup_date: pickupDate,
                    pickup_time: pickupTime,
                    return_date: returnDate,
                    return_time: returnTime
                };

                let encodedData = encodeURIComponent(JSON.stringify(formData));
                let redirectUrl = "{{ url('/bookingfilter') }}/" + encodedData;
                window.location.href = redirectUrl;
            });

            document.addEventListener("DOMContentLoaded", function() {
                let diffLocCheckbox = document.getElementById("diff_loc");
                let returnCol = document.getElementById("return_col");

                diffLocCheckbox.addEventListener("change", function() {
                    if (this.checked) {
                        returnCol.classList.remove("d-none");
                    } else {
                        returnCol.classList.add("d-none");
                    }
                });
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
        </script>
    </div>
</main>
@endsection
