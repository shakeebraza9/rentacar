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
                                    @if (!empty($global_d['popup_image']) && !empty($global_d['popup_image']->path))
                                        <div class="carousel-item active">
                                            <img src="{{ asset($global_d['popup_image']->path) }}" class="img-fluid" alt="">
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
                                    <a href="index.html"><button class="nav-link btn active" id="car-rental-tab"
                                            type="button" role="tab" aria-controls="car-rental"
                                            aria-selected="false"><span class="icon-circle"><i
                                                    class="fa fa-car"></i></span>
                                            <div>Car Rental</div>
                                        </button></a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a href="attractions.html"><button class="nav-link btn " id="experience-tab"
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
                                    <form method="get" accept-charset="utf-8"
                                        action="https://www.MRR HOLIDAYS.my/customer/fleets">
                                        <div class="row gx-1 gy-2 gy-md-0">
                                            <div class="col-md-4" style="min-width: 38%;">
                                                <div class="wrapper-location">
                                                    <div id="pickup_col">
                                                        <div class="input-group select2-floating position-relative">
                                                            <span
                                                                class="icon position-absolute top-50 start-0 translate-middle-y"><i
                                                                    class="fa fa-map-marker-alt text-primary"></i></span>
                                                            <label class="small">Select Pickup Locations</label>
                                                            <select class="form-control input-group border-0"
                                                                name="custom_pickup_location" id="input_pickup"
                                                                required>
                                                                <option disabled selected value="">- Choose a
                                                                    location - </option>
                                                                <optgroup label="Popular Pickup Location">
                                                                    <option value="Langkawi Airport (Door 3)">
                                                                        Langkawi Airport (Door 3)</option>
                                                                    <option value="Langkawi Ferry Jetty">Langkawi
                                                                        Ferry Jetty</option>
                                                                </optgroup>
                                                                <optgroup label="Others">
                                                                    <option value=" De Greenish Village"> De
                                                                        Greenish Village</option>
                                                                    <option value="A Rock Resort">A Rock Resort
                                                                    </option>
                                                                    <option value="AB Motel">AB Motel</option>
                                                                    <option value="Adya Hotel Chenang">Adya Hotel
                                                                        Chenang</option>
                                                                    <option value="Adya Hotel Kuah">Adya Hotel Kuah
                                                                    </option>
                                                                    <option value="Airis Santuary Resort Langkawi">
                                                                        Airis Santuary Resort Langkawi</option>
                                                                    <option value="Aislinn Villa ">Aislinn Villa
                                                                    </option>
                                                                    <option value="Akademi Koreksional Langkawi">
                                                                        Akademi Koreksional Langkawi</option>
                                                                    <option value="Al Saffa Homestay">Al Saffa
                                                                        Homestay</option>
                                                                    <option value="Alamanda Villa Langkawi">Alamanda
                                                                        Villa Langkawi</option>
                                                                    <option value="Alia Residence">Alia Residence
                                                                    </option>
                                                                    <option value="Aloft Langkawi Pantai Tengah">
                                                                        Aloft Langkawi Pantai Tengah</option>
                                                                    <option value="Alpha Motel">Alpha Motel</option>
                                                                    <option value="Ambong Rainforest Retreat">Ambong
                                                                        Rainforest Retreat</option>
                                                                    <option value="Ambong-Ambong Pool Villas">
                                                                        Ambong-Ambong Pool Villas</option>
                                                                    <option value="Aneeda Inn">Aneeda Inn</option>
                                                                    <option value="Api-Api Eco Resort">Api-Api Eco
                                                                        Resort</option>
                                                                    <option value="Arch Studio ">Arch Studio
                                                                    </option>
                                                                    <option value="Aseania Resort & Spa Langkawi">
                                                                        Aseania Resort & Spa Langkawi</option>
                                                                    <option value="Asia Hotel Langkawi ">Asia Hotel
                                                                        Langkawi </option>
                                                                    <option value="Atma Alam Batik Village">Atma
                                                                        Alam Batik Village</option>
                                                                    <option value="Attitude Resort Langkawi">
                                                                        Attitude Resort Langkawi</option>
                                                                    <option value="Bamboo Cottage Langkawi">Bamboo
                                                                        Cottage Langkawi</option>
                                                                    <option value="Bayview Hotel Langkawi">Bayview
                                                                        Hotel Langkawi</option>
                                                                    <option value="Bed Attitude Hostel Cenang">Bed
                                                                        Attitude Hostel Cenang</option>
                                                                    <option value="Beliza Apartment Langkawi">Beliza
                                                                        Apartment Langkawi</option>
                                                                    <option value="Bella Vista Express Hotel ">Bella
                                                                        Vista Express Hotel </option>
                                                                    <option value="Bella Vista Waterfront Langkawi">
                                                                        Bella Vista Waterfront Langkawi</option>
                                                                    <option value="Berjaya Langkawi Resort">Berjaya
                                                                        Langkawi Resort</option>
                                                                    <option value="Best Star Resort ">Best Star
                                                                        Resort </option>
                                                                    <option value="Blissful Guesthouse's">Blissful
                                                                        Guesthouse's</option>
                                                                    <option value="Bon Ton Resort">Bon Ton Resort
                                                                    </option>
                                                                    <option value="Camar Resort">Camar Resort
                                                                    </option>
                                                                    <option value="Camellia Holiday Apartment">
                                                                        Camellia Holiday Apartment</option>
                                                                    <option value="Casa Del Mar Langkawi">Casa Del
                                                                        Mar Langkawi</option>
                                                                    <option value="Casa Fina Fine Homes">Casa Fina
                                                                        Fine Homes</option>
                                                                    <option value="Casa Idaman Motel">Casa Idaman
                                                                        Motel</option>
                                                                    <option
                                                                        value="Cenang Home Stay @ Cenang Village">
                                                                        Cenang Home Stay @ Cenang Village</option>
                                                                    <option value="Cenang Terminal To Rebak Island">
                                                                        Cenang Terminal To Rebak Island</option>
                                                                    <option value="Cenang View Hotel">Cenang View
                                                                        Hotel</option>
                                                                    <option
                                                                        value="Century Langkasuka Resort Langkawi">
                                                                        Century Langkasuka Resort Langkawi</option>
                                                                    <option
                                                                        value="Century Suria Apartment Langkawi ">
                                                                        Century Suria Apartment Langkawi </option>
                                                                    <option value="Chalet Bayu Inn">Chalet Bayu Inn
                                                                    </option>
                                                                    <option value="Chenang CK Homestay">Chenang CK
                                                                        Homestay</option>
                                                                    <option value="Chenang Clinic Kuah">Chenang
                                                                        Clinic Kuah</option>
                                                                    <option value="Chenang Hill Langkawi">Chenang
                                                                        Hill Langkawi</option>
                                                                    <option value="Chenang Mall, Langkawi">Chenang
                                                                        Mall, Langkawi</option>
                                                                    <option value="Chenang Plaza Beach Hotel ">
                                                                        Chenang Plaza Beach Hotel </option>
                                                                    <option value="Chill Box Hotel ">Chill Box Hotel
                                                                    </option>
                                                                    <option value="Chill Suite">Chill Suite</option>
                                                                    <option value="Chogm Villa Langkawi">Chogm Villa
                                                                        Langkawi</option>
                                                                    <option value="Chuu Pun Village Resort ">Chuu
                                                                        Pun Village Resort </option>
                                                                    <option value="Cloud9 Holiday Cottage">Cloud9
                                                                        Holiday Cottage</option>
                                                                    <option value="Coconut Beach Villa Langkawi">
                                                                        Coconut Beach Villa Langkawi</option>
                                                                    <option value="Cocotop Hotel">Cocotop Hotel
                                                                    </option>
                                                                    <option value="Corrie Chalet Langkawi ">Corrie
                                                                        Chalet Langkawi </option>
                                                                    <option value="Cruise Pier Langkawi">Cruise Pier
                                                                        Langkawi</option>
                                                                    <option value="D Hayaa Chenang">D Hayaa Chenang
                                                                    </option>
                                                                    <option value="D Villa Guest House ">D Villa
                                                                        Guest House </option>
                                                                    <option value="D' Chenang Inn">D' Chenang Inn
                                                                    </option>
                                                                    <option value="D' Village Cottage Langkawi">D'
                                                                        Village Cottage Langkawi</option>
                                                                    <option value="D'lima Beach Inn">D'lima Beach
                                                                        Inn</option>
                                                                    <option value="Dani Cottage Langkawi">Dani
                                                                        Cottage Langkawi</option>
                                                                    <option value="Dash Resort Langkawi">Dash Resort
                                                                        Langkawi</option>
                                                                    <option value="Dataran Lang">Dataran Lang
                                                                    </option>
                                                                    <option value="Dayang Bay Resort Langkawi">
                                                                        Dayang Bay Resort Langkawi</option>
                                                                    <option
                                                                        value="De Balqis Chalet Tanjung Rhu Langkawi">
                                                                        De Balqis Chalet Tanjung Rhu Langkawi
                                                                    </option>
                                                                    <option value="De Baron Resort Langkawi">De
                                                                        Baron Resort Langkawi</option>
                                                                    <option value="De Bleu Hotel">De Bleu Hotel
                                                                    </option>
                                                                    <option value="De Blue Hotel">De Blue Hotel
                                                                    </option>
                                                                    <option value="Delta Chenang Resort ">Delta
                                                                        Chenang Resort </option>
                                                                    <option value="Dermaga Tanjung Lembung">Dermaga
                                                                        Tanjung Lembung</option>
                                                                    <option value="Desa Motel">Desa Motel</option>
                                                                    <option value="Destini Akef Villa">Destini Akef
                                                                        Villa</option>
                                                                    <option value="Dhania Motel">Dhania Motel
                                                                    </option>
                                                                    <option value="Dian Homestay">Dian Homestay
                                                                    </option>
                                                                    <option value="FAMA ">FAMA </option>
                                                                    <option
                                                                        value="Farmers Management Institute (Institut Pengurusan Peladang Langkawi)">
                                                                        Farmers Management Institute (Institut
                                                                        Pengurusan Peladang Langkawi)</option>
                                                                    <option value="Fish Landing Jetty Penarak">Fish
                                                                        Landing Jetty Penarak</option>
                                                                    <option value="Found Mansion Langkawi ">Found
                                                                        Mansion Langkawi </option>
                                                                    <option value="Four Seasons Resort Langkawi">
                                                                        Four Seasons Resort Langkawi</option>
                                                                    <option value="Fuuka Villa">Fuuka Villa</option>
                                                                    <option value="Fuxi Villa Langkawi ">Fuxi Villa
                                                                        Langkawi </option>
                                                                    <option value="GeoPark Hotel, Kuah">GeoPark
                                                                        Hotel, Kuah</option>
                                                                    <option value="Golden Cenang Village">Golden
                                                                        Cenang Village</option>
                                                                    <option value="Goldsands Hotel Langkawi">
                                                                        Goldsands Hotel Langkawi</option>
                                                                    <option value="Grand Lodge Langkawi">Grand Lodge
                                                                        Langkawi</option>
                                                                    <option value="Grand Village Inn">Grand Village
                                                                        Inn</option>
                                                                    <option value="Greenish Hotel">Greenish Hotel
                                                                    </option>
                                                                    <option value="Hadramawt Langkawi">Hadramawt
                                                                        Langkawi</option>
                                                                    <option value="Haji Ismail Group Hotel ">Haji
                                                                        Ismail Group Hotel </option>
                                                                    <option value="Harmony Guest House ">Harmony
                                                                        Guest House </option>
                                                                    <option value="Hillview Cube Langkawi">Hillview
                                                                        Cube Langkawi</option>
                                                                    <option
                                                                        value="Holiday Villa Beach Resort & Spa Langkawi ">
                                                                        Holiday Villa Beach Resort & Spa Langkawi
                                                                    </option>
                                                                    <option value="Hornbill Retreat Villa">Hornbill
                                                                        Retreat Villa</option>
                                                                    <option value="Hotel Bahagia Langkawi">Hotel
                                                                        Bahagia Langkawi</option>
                                                                    <option value="Hotel Grand Continental">Hotel
                                                                        Grand Continental</option>
                                                                    <option value="Hotel Langkasuka Langkawi ">Hotel
                                                                        Langkasuka Langkawi </option>
                                                                    <option value="Idaman Guest House">Idaman Guest
                                                                        House</option>
                                                                    <option value="Idul Homestay Langkawi">Idul
                                                                        Homestay Langkawi</option>
                                                                    <option value="Inapan Aishah ">Inapan Aishah
                                                                    </option>
                                                                    <option
                                                                        value="Islandish Family Seafood Restaurant ">
                                                                        Islandish Family Seafood Restaurant
                                                                    </option>
                                                                    <option value="J's Home 1">J's Home 1</option>
                                                                    <option value="Jetty APMM Langkawi ">Jetty APMM
                                                                        Langkawi </option>
                                                                    <option
                                                                        value="Jetty Dato' Syed Omar (Jetty Marble)">
                                                                        Jetty Dato' Syed Omar (Jetty Marble)
                                                                    </option>
                                                                    <option value="Jetty Pelancongan Pekan Rabu">
                                                                        Jetty Pelancongan Pekan Rabu</option>
                                                                    <option value="Kampung Berjaya ">Kampung Berjaya
                                                                    </option>
                                                                    <option value="Kampung Guest House">Kampung
                                                                        Guest House</option>
                                                                    <option
                                                                        value="Kedawang Village Resort Langkawi">
                                                                        Kedawang Village Resort Langkawi</option>
                                                                    <option value="Kenangan Inn Hotel ">Kenangan Inn
                                                                        Hotel </option>
                                                                    <option value="Kilim Geoforest Park">Kilim
                                                                        Geoforest Park</option>
                                                                    <option value="Kolej Komuniti Langkawi">Kolej
                                                                        Komuniti Langkawi</option>
                                                                    <option value="Kondo Sri Idaman">Kondo Sri
                                                                        Idaman</option>
                                                                    <option value="Kuala Melaka Inn ">Kuala Melaka
                                                                        Inn </option>
                                                                    <option value="Kunang Kunang Heritage Villas">
                                                                        Kunang Kunang Heritage Villas</option>
                                                                    <option value="La Pari Pari Hotel ">La Pari Pari
                                                                        Hotel </option>
                                                                    <option value="La Villa">La Villa</option>
                                                                    <option value="Landcons Hotel">Landcons Hotel
                                                                    </option>
                                                                    <option value="Langgura Baron Resort">Langgura
                                                                        Baron Resort</option>
                                                                    <option value="Langkapuri Resort Langkawi">
                                                                        Langkapuri Resort Langkawi</option>
                                                                    <option value="Langkawi Chantique,">Langkawi
                                                                        Chantique,</option>
                                                                    <option value="Langkawi Country Lodge">Langkawi
                                                                        Country Lodge</option>
                                                                    <option value="Langkawi Fair Shopping Center ">
                                                                        Langkawi Fair Shopping Center </option>
                                                                    <option
                                                                        value="Langkawi International Convention Centre">
                                                                        Langkawi International Convention Centre
                                                                    </option>
                                                                    <option value="Langkawi Lagoon Resort ">Langkawi
                                                                        Lagoon Resort </option>
                                                                    <option value="Langkawi Lovely Garden Villas">
                                                                        Langkawi Lovely Garden Villas</option>
                                                                    <option value="Langkawi Parade">Langkawi Parade
                                                                    </option>
                                                                    <option value="Langkawi Tourism Academy">
                                                                        Langkawi Tourism Academy</option>
                                                                    <option value="MRR HOLIDAYS Office">MRR HOLIDAYS
                                                                        Office</option>
                                                                    <option value="Lavanya Residence">Lavanya
                                                                        Residence</option>
                                                                    <option value="Lavigo Resort">Lavigo Resort
                                                                    </option>
                                                                    <option value="LB Hub">LB Hub</option>
                                                                    <option value="Looma Private Pool Villa">Looma
                                                                        Private Pool Villa</option>
                                                                    <option value="Looma Private Pool Villas">Looma
                                                                        Private Pool Villas</option>
                                                                    <option value="Lorong Simfoni 2 Homestay">Lorong
                                                                        Simfoni 2 Homestay</option>
                                                                    <option value="Lot 33 Boutique Hotel">Lot 33
                                                                        Boutique Hotel</option>
                                                                    <option value="M-Residence">M-Residence</option>
                                                                    <option
                                                                        value="Mahsuri International Exhibition Centre">
                                                                        Mahsuri International Exhibition Centre
                                                                    </option>
                                                                    <option value="Makam Mahsuri">Makam Mahsuri
                                                                    </option>
                                                                    <option value="Malibest Resort">Malibest Resort
                                                                    </option>
                                                                    <option value="Maneh Villa Langkawi ">Maneh
                                                                        Villa Langkawi </option>
                                                                    <option value="Masjid Al Hana">Masjid Al Hana
                                                                    </option>
                                                                    <option value="Mercure Hotel">Mercure Hotel
                                                                    </option>
                                                                    <option value="MIMPIMOON BUNK BEDS & HOME">
                                                                        MIMPIMOON BUNK BEDS & HOME</option>
                                                                    <option value="My Villa Langkawi">My Villa
                                                                        Langkawi</option>
                                                                    <option
                                                                        value="Myangkasa Akademi & Resort Langkawi">
                                                                        Myangkasa Akademi & Resort Langkawi</option>
                                                                    <option value="Myrus Resort Langkawi ">Myrus
                                                                        Resort Langkawi </option>
                                                                    <option value="Nabila Homestay">Nabila Homestay
                                                                    </option>
                                                                    <option value="Nadias Hotel Cenang Langkawi">
                                                                        Nadias Hotel Cenang Langkawi</option>
                                                                    <option value="Nivasa@251">Nivasa@251</option>
                                                                    <option value="Norshah Village Resort">Norshah
                                                                        Village Resort</option>
                                                                    <option value="NU Melati Hotel ">NU Melati Hotel
                                                                    </option>
                                                                    <option value="Ombak Villa Resort">Ombak Villa
                                                                        Resort</option>
                                                                    <option value="Oriental Village Langkawi ">
                                                                        Oriental Village Langkawi </option>
                                                                    <option value="Pangkalan TLDM Langkawi">
                                                                        Pangkalan TLDM Langkawi</option>
                                                                    <option
                                                                        value="Panji Panji Tropical Wooden Home">
                                                                        Panji Panji Tropical Wooden Home</option>
                                                                    <option
                                                                        value="Panorama Hotel & Resort Langkawi">
                                                                        Panorama Hotel & Resort Langkawi</option>
                                                                    <option value="Pantai Labu Labi">Pantai Labu
                                                                        Labi</option>
                                                                    <option value="Paretto Seaview Hotel">Paretto
                                                                        Seaview Hotel</option>
                                                                    <option value="Park Royal Hotel">Park Royal
                                                                        Hotel</option>
                                                                    <option
                                                                        value="Pejabat Pelajaran Daerah Langkawi">
                                                                        Pejabat Pelajaran Daerah Langkawi</option>
                                                                    <option value="Pelangi Beach Resort & Spa">
                                                                        Pelangi Beach Resort & Spa</option>
                                                                    <option value="Perdana Residence ">Perdana
                                                                        Residence </option>
                                                                    <option value="Pondok Keladi Guest House ">
                                                                        Pondok Keladi Guest House </option>
                                                                    <option value="Pondok Muara Chalet">Pondok Muara
                                                                        Chalet</option>
                                                                    <option value="Pondok Muara Chalet ">Pondok
                                                                        Muara Chalet </option>
                                                                    <option value="Primrose Seaview Langkawi">
                                                                        Primrose Seaview Langkawi</option>
                                                                    <option value="Pulapol Langkawi">Pulapol
                                                                        Langkawi</option>
                                                                    <option
                                                                        value="Pusat Latihan Kenegaraan Langkawi">
                                                                        Pusat Latihan Kenegaraan Langkawi</option>
                                                                    <option value="Qattleya Langkawi Homestay">
                                                                        Qattleya Langkawi Homestay</option>
                                                                    <option value="R Hotel Langkawi">R Hotel
                                                                        Langkawi</option>
                                                                    <option value="Rahsia Motel">Rahsia Motel
                                                                    </option>
                                                                    <option
                                                                        value="Ramada By Wyndham Langkawi Marina">
                                                                        Ramada By Wyndham Langkawi Marina</option>
                                                                    <option value="Ranis Lodge">Ranis Lodge</option>
                                                                    <option value="Rasa Senang Villa ">Rasa Senang
                                                                        Villa </option>
                                                                    <option value="Rebak Island Terminal ">Rebak
                                                                        Island Terminal </option>
                                                                    <option value="Red Coral Cottage">Red Coral
                                                                        Cottage</option>
                                                                    <option value="Rembulan Langkawi Hotel">Rembulan
                                                                        Langkawi Hotel</option>
                                                                    <option value="Resort World Langkawi ">Resort
                                                                        World Langkawi </option>
                                                                    <option value="Riverra Inn">Riverra Inn</option>
                                                                    <option value="Royal Agate Hotel ">Royal Agate
                                                                        Hotel </option>
                                                                    <option value="Royal Chenang">Royal Chenang
                                                                    </option>
                                                                    <option value="Royale Riviera Resort">Royale
                                                                        Riviera Resort</option>
                                                                    <option value="Sal Estate">Sal Estate</option>
                                                                    <option value="Salsa Resort ">Salsa Resort
                                                                    </option>
                                                                    <option value="Salsa Resort Langkawi ">Salsa
                                                                        Resort Langkawi </option>
                                                                    <option value="Sandy Beach Resort">Sandy Beach
                                                                        Resort</option>
                                                                    <option value="Sari Village Jungle Retreat">Sari
                                                                        Village Jungle Retreat</option>
                                                                    <option
                                                                        value="Saujana Private Villas Datai Bay">
                                                                        Saujana Private Villas Datai Bay</option>
                                                                    <option value="Seaview Hotel">Seaview Hotel
                                                                    </option>
                                                                    <option value="Sehijau Chenang">Sehijau Chenang
                                                                    </option>
                                                                    <option value="Sembilan Villa Langkawi">Sembilan
                                                                        Villa Langkawi</option>
                                                                    <option value="Senari Bay Resort ">Senari Bay
                                                                        Resort </option>
                                                                    <option value="Seven Stones Langkawi">Seven
                                                                        Stones Langkawi</option>
                                                                    <option value="Shell Out Chenang Beach Resort">
                                                                        Shell Out Chenang Beach Resort</option>
                                                                    <option value="Simfoni Resort">Simfoni Resort
                                                                    </option>
                                                                    <option value="Sri Embun Resort">Sri Embun
                                                                        Resort</option>
                                                                    <option value="Sri Kijang Resort BNM">Sri Kijang
                                                                        Resort BNM</option>
                                                                    <option value="Sri Lagenda Apartment">Sri
                                                                        Lagenda Apartment</option>
                                                                    <option value="Sunset Beach Resort Langkawi">
                                                                        Sunset Beach Resort Langkawi</option>
                                                                    <option value="S’kar Pinang">S’kar Pinang
                                                                    </option>
                                                                    <option value="Taman Desa Impian">Taman Desa
                                                                        Impian</option>
                                                                    <option value="Taman Indah">Taman Indah</option>
                                                                    <option value="Taman Simfoni">Taman Simfoni
                                                                    </option>
                                                                    <option value="Tanabendang Banglos Langkawi">
                                                                        Tanabendang Banglos Langkawi</option>
                                                                    <option value="Tanjung Puteri Motel">Tanjung
                                                                        Puteri Motel</option>
                                                                    <option value="Tanjung Rhu Resort, Langkawi">
                                                                        Tanjung Rhu Resort, Langkawi</option>
                                                                    <option value="Tanjung Rhu Villa">Tanjung Rhu
                                                                        Villa</option>
                                                                    <option value="Telaga Harbour Marina">Telaga
                                                                        Harbour Marina</option>
                                                                    <option value="Telaga Terrace Boutique Hotel">
                                                                        Telaga Terrace Boutique Hotel</option>
                                                                    <option
                                                                        value="Temple Tree Boutique Resort Langkawi">
                                                                        Temple Tree Boutique Resort Langkawi
                                                                    </option>
                                                                    <option value="The Bayou Hotel Langkawi">The
                                                                        Bayou Hotel Langkawi</option>
                                                                    <option value="The Concept Hotel Langkawi ">The
                                                                        Concept Hotel Langkawi </option>
                                                                    <option value="The Cottage Langkawi">The Cottage
                                                                        Langkawi</option>
                                                                    <option value="The Danna">The Danna</option>
                                                                    <option value="The Datai Langkawi">The Datai
                                                                        Langkawi</option>
                                                                    <option value="The Daun Resort">The Daun Resort
                                                                    </option>
                                                                    <option value="The Denai Langkawi ">The Denai
                                                                        Langkawi </option>
                                                                    <option value="The Frangipani Langkawi Resort">
                                                                        The Frangipani Langkawi Resort</option>
                                                                    <option value="The Gemalai Village">The Gemalai
                                                                        Village</option>
                                                                    <option value="The Groove House Langkawi">The
                                                                        Groove House Langkawi</option>
                                                                    <option value="The Laguna">The Laguna</option>
                                                                    <option value="The Monte">The Monte</option>
                                                                    <option value="The Nutshell Chalet Langkawi">The
                                                                        Nutshell Chalet Langkawi</option>
                                                                    <option value="The Ocean Residence Langkawi ">
                                                                        The Ocean Residence Langkawi </option>
                                                                    <option value="The Ritz-Carlton, Langkawi">The
                                                                        Ritz-Carlton, Langkawi</option>
                                                                    <option
                                                                        value="The Riyaz Lavanya Langkawi Hotel ">
                                                                        The Riyaz Lavanya Langkawi Hotel </option>
                                                                    <option value="The Smith Hotel">The Smith Hotel
                                                                    </option>
                                                                    <option value="The St. Regis Langkawi">The St.
                                                                        Regis Langkawi</option>
                                                                    <option value="The Villa Langkawi">The Villa
                                                                        Langkawi</option>
                                                                    <option value="The Weekend Langkawi">The Weekend
                                                                        Langkawi</option>
                                                                    <option
                                                                        value="The Westin Langkawi Resort & Spa">The
                                                                        Westin Langkawi Resort & Spa</option>
                                                                    <option
                                                                        value="The White House Homestay Langkawi">
                                                                        The White House Homestay Langkawi</option>
                                                                    <option value="Tok Cheng Cottage ">Tok Cheng
                                                                        Cottage </option>
                                                                    <option value="Traditional Homestay Chenang ">
                                                                        Traditional Homestay Chenang </option>
                                                                    <option value="Tropical Resort Langkawi">
                                                                        Tropical Resort Langkawi</option>
                                                                    <option value="Tropicana Chenang Office">
                                                                        Tropicana Chenang Office</option>
                                                                    <option value="Tubotel Langkawi">Tubotel
                                                                        Langkawi</option>
                                                                    <option value="Turkish Restaurant & Bazaar">
                                                                        Turkish Restaurant & Bazaar</option>
                                                                    <option value="Ulu Melaka">Ulu Melaka</option>
                                                                    <option value="UnderwaterWorld Langkawi">
                                                                        UnderwaterWorld Langkawi</option>
                                                                    <option value="Villa Abadi Langkawi ">Villa
                                                                        Abadi Langkawi </option>
                                                                    <option value="Villa Paddy">Villa Paddy</option>
                                                                    <option value="Virgo Star Resort">Virgo Star
                                                                        Resort</option>
                                                                    <option value="Vitatree Cottage">Vitatree
                                                                        Cottage</option>
                                                                    <option value="Wang Valley Resort Langkawi ">
                                                                        Wang Valley Resort Langkawi </option>
                                                                    <option value="Wave Langkawi Inn Roomstay">Wave
                                                                        Langkawi Inn Roomstay</option>
                                                                    <option value="We Hotel Langkawi">We Hotel
                                                                        Langkawi</option>
                                                                    <option value="White Lodge Chalet Langkawi">
                                                                        White Lodge Chalet Langkawi</option>
                                                                    <option
                                                                        value="Wings By Croske Resort Langkawi,">
                                                                        Wings By Croske Resort Langkawi,</option>
                                                                    <option value="Y-Connect Cafe Langkawi">
                                                                        Y-Connect Cafe Langkawi</option>
                                                                    <option value="Zen 11 Homestay ">Zen 11 Homestay
                                                                    </option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-none mt-2 mt-md-0" id="return_col">
                                                        <div class="input-group select2-floating position-relative">
                                                            <span
                                                                class="icon position-absolute top-50 start-0 translate-middle-y"><i
                                                                    class="fa fa-map-marker-alt text-primary"></i></span>
                                                            <label class="small">Select Return Locations</label>
                                                            <select class="form-control input-group border-0"
                                                                name="custom_return_location" id="input_return">
                                                                <option disabled selected value="">- Choose a
                                                                    location - </option>
                                                                <optgroup label="Popular Pickup Location">
                                                                    <option value="Langkawi Airport (Door 3)">
                                                                        Langkawi Airport (Door 3)</option>
                                                                    <option value="Langkawi Ferry Jetty">Langkawi
                                                                        Ferry Jetty</option>
                                                                </optgroup>
                                                                <optgroup label="Others">
                                                                    <option value=" De Greenish Village"> De
                                                                        Greenish Village</option>
                                                                    <option value="A Rock Resort">A Rock Resort
                                                                    </option>
                                                                    <option value="AB Motel">AB Motel</option>
                                                                    <option value="Adya Hotel Chenang">Adya Hotel
                                                                        Chenang</option>
                                                                    <option value="Adya Hotel Kuah">Adya Hotel Kuah
                                                                    </option>
                                                                    <option value="Airis Santuary Resort Langkawi">
                                                                        Airis Santuary Resort Langkawi</option>
                                                                    <option value="Aislinn Villa ">Aislinn Villa
                                                                    </option>
                                                                    <option value="Akademi Koreksional Langkawi">
                                                                        Akademi Koreksional Langkawi</option>
                                                                    <option value="Al Saffa Homestay">Al Saffa
                                                                        Homestay</option>
                                                                    <option value="Alamanda Villa Langkawi">Alamanda
                                                                        Villa Langkawi</option>
                                                                    <option value="Alia Residence">Alia Residence
                                                                    </option>
                                                                    <option value="Aloft Langkawi Pantai Tengah">
                                                                        Aloft Langkawi Pantai Tengah</option>
                                                                    <option value="Alpha Motel">Alpha Motel</option>
                                                                    <option value="Ambong Rainforest Retreat">Ambong
                                                                        Rainforest Retreat</option>
                                                                    <option value="Ambong-Ambong Pool Villas">
                                                                        Ambong-Ambong Pool Villas</option>
                                                                    <option value="Aneeda Inn">Aneeda Inn</option>
                                                                    <option value="Api-Api Eco Resort">Api-Api Eco
                                                                        Resort</option>
                                                                    <option value="Arch Studio ">Arch Studio
                                                                    </option>
                                                                    <option value="Aseania Resort & Spa Langkawi">
                                                                        Aseania Resort & Spa Langkawi</option>
                                                                    <option value="Asia Hotel Langkawi ">Asia Hotel
                                                                        Langkawi </option>
                                                                    <option value="Atma Alam Batik Village">Atma
                                                                        Alam Batik Village</option>
                                                                    <option value="Attitude Resort Langkawi">
                                                                        Attitude Resort Langkawi</option>
                                                                    <option value="Bamboo Cottage Langkawi">Bamboo
                                                                        Cottage Langkawi</option>
                                                                    <option value="Bayview Hotel Langkawi">Bayview
                                                                        Hotel Langkawi</option>
                                                                    <option value="Bed Attitude Hostel Cenang">Bed
                                                                        Attitude Hostel Cenang</option>
                                                                    <option value="Beliza Apartment Langkawi">Beliza
                                                                        Apartment Langkawi</option>
                                                                    <option value="Bella Vista Express Hotel ">Bella
                                                                        Vista Express Hotel </option>
                                                                    <option value="Bella Vista Waterfront Langkawi">
                                                                        Bella Vista Waterfront Langkawi</option>
                                                                    <option value="Berjaya Langkawi Resort">Berjaya
                                                                        Langkawi Resort</option>
                                                                    <option value="Best Star Resort ">Best Star
                                                                        Resort </option>
                                                                    <option value="Blissful Guesthouse's">Blissful
                                                                        Guesthouse's</option>
                                                                    <option value="Bon Ton Resort">Bon Ton Resort
                                                                    </option>
                                                                    <option value="Camar Resort">Camar Resort
                                                                    </option>
                                                                    <option value="Camellia Holiday Apartment">
                                                                        Camellia Holiday Apartment</option>
                                                                    <option value="Casa Del Mar Langkawi">Casa Del
                                                                        Mar Langkawi</option>
                                                                    <option value="Casa Fina Fine Homes">Casa Fina
                                                                        Fine Homes</option>
                                                                    <option value="Casa Idaman Motel">Casa Idaman
                                                                        Motel</option>
                                                                    <option
                                                                        value="Cenang Home Stay @ Cenang Village">
                                                                        Cenang Home Stay @ Cenang Village</option>
                                                                    <option value="Cenang Terminal To Rebak Island">
                                                                        Cenang Terminal To Rebak Island</option>
                                                                    <option value="Cenang View Hotel">Cenang View
                                                                        Hotel</option>
                                                                    <option
                                                                        value="Century Langkasuka Resort Langkawi">
                                                                        Century Langkasuka Resort Langkawi</option>
                                                                    <option
                                                                        value="Century Suria Apartment Langkawi ">
                                                                        Century Suria Apartment Langkawi </option>
                                                                    <option value="Chalet Bayu Inn">Chalet Bayu Inn
                                                                    </option>
                                                                    <option value="Chenang CK Homestay">Chenang CK
                                                                        Homestay</option>
                                                                    <option value="Chenang Clinic Kuah">Chenang
                                                                        Clinic Kuah</option>
                                                                    <option value="Chenang Hill Langkawi">Chenang
                                                                        Hill Langkawi</option>
                                                                    <option value="Chenang Mall, Langkawi">Chenang
                                                                        Mall, Langkawi</option>
                                                                    <option value="Chenang Plaza Beach Hotel ">
                                                                        Chenang Plaza Beach Hotel </option>
                                                                    <option value="Chill Box Hotel ">Chill Box Hotel
                                                                    </option>
                                                                    <option value="Chill Suite">Chill Suite</option>
                                                                    <option value="Chogm Villa Langkawi">Chogm Villa
                                                                        Langkawi</option>
                                                                    <option value="Chuu Pun Village Resort ">Chuu
                                                                        Pun Village Resort </option>
                                                                    <option value="Cloud9 Holiday Cottage">Cloud9
                                                                        Holiday Cottage</option>
                                                                    <option value="Coconut Beach Villa Langkawi">
                                                                        Coconut Beach Villa Langkawi</option>
                                                                    <option value="Cocotop Hotel">Cocotop Hotel
                                                                    </option>
                                                                    <option value="Corrie Chalet Langkawi ">Corrie
                                                                        Chalet Langkawi </option>
                                                                    <option value="Cruise Pier Langkawi">Cruise Pier
                                                                        Langkawi</option>
                                                                    <option value="D Hayaa Chenang">D Hayaa Chenang
                                                                    </option>
                                                                    <option value="D Villa Guest House ">D Villa
                                                                        Guest House </option>
                                                                    <option value="D' Chenang Inn">D' Chenang Inn
                                                                    </option>
                                                                    <option value="D' Village Cottage Langkawi">D'
                                                                        Village Cottage Langkawi</option>
                                                                    <option value="D'lima Beach Inn">D'lima Beach
                                                                        Inn</option>
                                                                    <option value="Dani Cottage Langkawi">Dani
                                                                        Cottage Langkawi</option>
                                                                    <option value="Dash Resort Langkawi">Dash Resort
                                                                        Langkawi</option>
                                                                    <option value="Dataran Lang">Dataran Lang
                                                                    </option>
                                                                    <option value="Dayang Bay Resort Langkawi">
                                                                        Dayang Bay Resort Langkawi</option>
                                                                    <option
                                                                        value="De Balqis Chalet Tanjung Rhu Langkawi">
                                                                        De Balqis Chalet Tanjung Rhu Langkawi
                                                                    </option>
                                                                    <option value="De Baron Resort Langkawi">De
                                                                        Baron Resort Langkawi</option>
                                                                    <option value="De Bleu Hotel">De Bleu Hotel
                                                                    </option>
                                                                    <option value="De Blue Hotel">De Blue Hotel
                                                                    </option>
                                                                    <option value="Delta Chenang Resort ">Delta
                                                                        Chenang Resort </option>
                                                                    <option value="Dermaga Tanjung Lembung">Dermaga
                                                                        Tanjung Lembung</option>
                                                                    <option value="Desa Motel">Desa Motel</option>
                                                                    <option value="Destini Akef Villa">Destini Akef
                                                                        Villa</option>
                                                                    <option value="Dhania Motel">Dhania Motel
                                                                    </option>
                                                                    <option value="Dian Homestay">Dian Homestay
                                                                    </option>
                                                                    <option value="FAMA ">FAMA </option>
                                                                    <option
                                                                        value="Farmers Management Institute (Institut Pengurusan Peladang Langkawi)">
                                                                        Farmers Management Institute (Institut
                                                                        Pengurusan Peladang Langkawi)</option>
                                                                    <option value="Fish Landing Jetty Penarak">Fish
                                                                        Landing Jetty Penarak</option>
                                                                    <option value="Found Mansion Langkawi ">Found
                                                                        Mansion Langkawi </option>
                                                                    <option value="Four Seasons Resort Langkawi">
                                                                        Four Seasons Resort Langkawi</option>
                                                                    <option value="Fuuka Villa">Fuuka Villa</option>
                                                                    <option value="Fuxi Villa Langkawi ">Fuxi Villa
                                                                        Langkawi </option>
                                                                    <option value="GeoPark Hotel, Kuah">GeoPark
                                                                        Hotel, Kuah</option>
                                                                    <option value="Golden Cenang Village">Golden
                                                                        Cenang Village</option>
                                                                    <option value="Goldsands Hotel Langkawi">
                                                                        Goldsands Hotel Langkawi</option>
                                                                    <option value="Grand Lodge Langkawi">Grand Lodge
                                                                        Langkawi</option>
                                                                    <option value="Grand Village Inn">Grand Village
                                                                        Inn</option>
                                                                    <option value="Greenish Hotel">Greenish Hotel
                                                                    </option>
                                                                    <option value="Hadramawt Langkawi">Hadramawt
                                                                        Langkawi</option>
                                                                    <option value="Haji Ismail Group Hotel ">Haji
                                                                        Ismail Group Hotel </option>
                                                                    <option value="Harmony Guest House ">Harmony
                                                                        Guest House </option>
                                                                    <option value="Hillview Cube Langkawi">Hillview
                                                                        Cube Langkawi</option>
                                                                    <option
                                                                        value="Holiday Villa Beach Resort & Spa Langkawi ">
                                                                        Holiday Villa Beach Resort & Spa Langkawi
                                                                    </option>
                                                                    <option value="Hornbill Retreat Villa">Hornbill
                                                                        Retreat Villa</option>
                                                                    <option value="Hotel Bahagia Langkawi">Hotel
                                                                        Bahagia Langkawi</option>
                                                                    <option value="Hotel Grand Continental">Hotel
                                                                        Grand Continental</option>
                                                                    <option value="Hotel Langkasuka Langkawi ">Hotel
                                                                        Langkasuka Langkawi </option>
                                                                    <option value="Idaman Guest House">Idaman Guest
                                                                        House</option>
                                                                    <option value="Idul Homestay Langkawi">Idul
                                                                        Homestay Langkawi</option>
                                                                    <option value="Inapan Aishah ">Inapan Aishah
                                                                    </option>
                                                                    <option
                                                                        value="Islandish Family Seafood Restaurant ">
                                                                        Islandish Family Seafood Restaurant
                                                                    </option>
                                                                    <option value="J's Home 1">J's Home 1</option>
                                                                    <option value="Jetty APMM Langkawi ">Jetty APMM
                                                                        Langkawi </option>
                                                                    <option
                                                                        value="Jetty Dato' Syed Omar (Jetty Marble)">
                                                                        Jetty Dato' Syed Omar (Jetty Marble)
                                                                    </option>
                                                                    <option value="Jetty Pelancongan Pekan Rabu">
                                                                        Jetty Pelancongan Pekan Rabu</option>
                                                                    <option value="Kampung Berjaya ">Kampung Berjaya
                                                                    </option>
                                                                    <option value="Kampung Guest House">Kampung
                                                                        Guest House</option>
                                                                    <option
                                                                        value="Kedawang Village Resort Langkawi">
                                                                        Kedawang Village Resort Langkawi</option>
                                                                    <option value="Kenangan Inn Hotel ">Kenangan Inn
                                                                        Hotel </option>
                                                                    <option value="Kilim Geoforest Park">Kilim
                                                                        Geoforest Park</option>
                                                                    <option value="Kolej Komuniti Langkawi">Kolej
                                                                        Komuniti Langkawi</option>
                                                                    <option value="Kondo Sri Idaman">Kondo Sri
                                                                        Idaman</option>
                                                                    <option value="Kuala Melaka Inn ">Kuala Melaka
                                                                        Inn </option>
                                                                    <option value="Kunang Kunang Heritage Villas">
                                                                        Kunang Kunang Heritage Villas</option>
                                                                    <option value="La Pari Pari Hotel ">La Pari Pari
                                                                        Hotel </option>
                                                                    <option value="La Villa">La Villa</option>
                                                                    <option value="Landcons Hotel">Landcons Hotel
                                                                    </option>
                                                                    <option value="Langgura Baron Resort">Langgura
                                                                        Baron Resort</option>
                                                                    <option value="Langkapuri Resort Langkawi">
                                                                        Langkapuri Resort Langkawi</option>
                                                                    <option value="Langkawi Chantique,">Langkawi
                                                                        Chantique,</option>
                                                                    <option value="Langkawi Country Lodge">Langkawi
                                                                        Country Lodge</option>
                                                                    <option value="Langkawi Fair Shopping Center ">
                                                                        Langkawi Fair Shopping Center </option>
                                                                    <option
                                                                        value="Langkawi International Convention Centre">
                                                                        Langkawi International Convention Centre
                                                                    </option>
                                                                    <option value="Langkawi Lagoon Resort ">Langkawi
                                                                        Lagoon Resort </option>
                                                                    <option value="Langkawi Lovely Garden Villas">
                                                                        Langkawi Lovely Garden Villas</option>
                                                                    <option value="Langkawi Parade">Langkawi Parade
                                                                    </option>
                                                                    <option value="Langkawi Tourism Academy">
                                                                        Langkawi Tourism Academy</option>
                                                                    <option value="MRR HOLIDAYS Office">MRR HOLIDAYS
                                                                        Office</option>
                                                                    <option value="Lavanya Residence">Lavanya
                                                                        Residence</option>
                                                                    <option value="Lavigo Resort">Lavigo Resort
                                                                    </option>
                                                                    <option value="LB Hub">LB Hub</option>
                                                                    <option value="Looma Private Pool Villa">Looma
                                                                        Private Pool Villa</option>
                                                                    <option value="Looma Private Pool Villas">Looma
                                                                        Private Pool Villas</option>
                                                                    <option value="Lorong Simfoni 2 Homestay">Lorong
                                                                        Simfoni 2 Homestay</option>
                                                                    <option value="Lot 33 Boutique Hotel">Lot 33
                                                                        Boutique Hotel</option>
                                                                    <option value="M-Residence">M-Residence</option>
                                                                    <option
                                                                        value="Mahsuri International Exhibition Centre">
                                                                        Mahsuri International Exhibition Centre
                                                                    </option>
                                                                    <option value="Makam Mahsuri">Makam Mahsuri
                                                                    </option>
                                                                    <option value="Malibest Resort">Malibest Resort
                                                                    </option>
                                                                    <option value="Maneh Villa Langkawi ">Maneh
                                                                        Villa Langkawi </option>
                                                                    <option value="Masjid Al Hana">Masjid Al Hana
                                                                    </option>
                                                                    <option value="Mercure Hotel">Mercure Hotel
                                                                    </option>
                                                                    <option value="MIMPIMOON BUNK BEDS & HOME">
                                                                        MIMPIMOON BUNK BEDS & HOME</option>
                                                                    <option value="My Villa Langkawi">My Villa
                                                                        Langkawi</option>
                                                                    <option
                                                                        value="Myangkasa Akademi & Resort Langkawi">
                                                                        Myangkasa Akademi & Resort Langkawi</option>
                                                                    <option value="Myrus Resort Langkawi ">Myrus
                                                                        Resort Langkawi </option>
                                                                    <option value="Nabila Homestay">Nabila Homestay
                                                                    </option>
                                                                    <option value="Nadias Hotel Cenang Langkawi">
                                                                        Nadias Hotel Cenang Langkawi</option>
                                                                    <option value="Nivasa@251">Nivasa@251</option>
                                                                    <option value="Norshah Village Resort">Norshah
                                                                        Village Resort</option>
                                                                    <option value="NU Melati Hotel ">NU Melati Hotel
                                                                    </option>
                                                                    <option value="Ombak Villa Resort">Ombak Villa
                                                                        Resort</option>
                                                                    <option value="Oriental Village Langkawi ">
                                                                        Oriental Village Langkawi </option>
                                                                    <option value="Pangkalan TLDM Langkawi">
                                                                        Pangkalan TLDM Langkawi</option>
                                                                    <option
                                                                        value="Panji Panji Tropical Wooden Home">
                                                                        Panji Panji Tropical Wooden Home</option>
                                                                    <option
                                                                        value="Panorama Hotel & Resort Langkawi">
                                                                        Panorama Hotel & Resort Langkawi</option>
                                                                    <option value="Pantai Labu Labi">Pantai Labu
                                                                        Labi</option>
                                                                    <option value="Paretto Seaview Hotel">Paretto
                                                                        Seaview Hotel</option>
                                                                    <option value="Park Royal Hotel">Park Royal
                                                                        Hotel</option>
                                                                    <option
                                                                        value="Pejabat Pelajaran Daerah Langkawi">
                                                                        Pejabat Pelajaran Daerah Langkawi</option>
                                                                    <option value="Pelangi Beach Resort & Spa">
                                                                        Pelangi Beach Resort & Spa</option>
                                                                    <option value="Perdana Residence ">Perdana
                                                                        Residence </option>
                                                                    <option value="Pondok Keladi Guest House ">
                                                                        Pondok Keladi Guest House </option>
                                                                    <option value="Pondok Muara Chalet">Pondok Muara
                                                                        Chalet</option>
                                                                    <option value="Pondok Muara Chalet ">Pondok
                                                                        Muara Chalet </option>
                                                                    <option value="Primrose Seaview Langkawi">
                                                                        Primrose Seaview Langkawi</option>
                                                                    <option value="Pulapol Langkawi">Pulapol
                                                                        Langkawi</option>
                                                                    <option
                                                                        value="Pusat Latihan Kenegaraan Langkawi">
                                                                        Pusat Latihan Kenegaraan Langkawi</option>
                                                                    <option value="Qattleya Langkawi Homestay">
                                                                        Qattleya Langkawi Homestay</option>
                                                                    <option value="R Hotel Langkawi">R Hotel
                                                                        Langkawi</option>
                                                                    <option value="Rahsia Motel">Rahsia Motel
                                                                    </option>
                                                                    <option
                                                                        value="Ramada By Wyndham Langkawi Marina">
                                                                        Ramada By Wyndham Langkawi Marina</option>
                                                                    <option value="Ranis Lodge">Ranis Lodge</option>
                                                                    <option value="Rasa Senang Villa ">Rasa Senang
                                                                        Villa </option>
                                                                    <option value="Rebak Island Terminal ">Rebak
                                                                        Island Terminal </option>
                                                                    <option value="Red Coral Cottage">Red Coral
                                                                        Cottage</option>
                                                                    <option value="Rembulan Langkawi Hotel">Rembulan
                                                                        Langkawi Hotel</option>
                                                                    <option value="Resort World Langkawi ">Resort
                                                                        World Langkawi </option>
                                                                    <option value="Riverra Inn">Riverra Inn</option>
                                                                    <option value="Royal Agate Hotel ">Royal Agate
                                                                        Hotel </option>
                                                                    <option value="Royal Chenang">Royal Chenang
                                                                    </option>
                                                                    <option value="Royale Riviera Resort">Royale
                                                                        Riviera Resort</option>
                                                                    <option value="Sal Estate">Sal Estate</option>
                                                                    <option value="Salsa Resort ">Salsa Resort
                                                                    </option>
                                                                    <option value="Salsa Resort Langkawi ">Salsa
                                                                        Resort Langkawi </option>
                                                                    <option value="Sandy Beach Resort">Sandy Beach
                                                                        Resort</option>
                                                                    <option value="Sari Village Jungle Retreat">Sari
                                                                        Village Jungle Retreat</option>
                                                                    <option
                                                                        value="Saujana Private Villas Datai Bay">
                                                                        Saujana Private Villas Datai Bay</option>
                                                                    <option value="Seaview Hotel">Seaview Hotel
                                                                    </option>
                                                                    <option value="Sehijau Chenang">Sehijau Chenang
                                                                    </option>
                                                                    <option value="Sembilan Villa Langkawi">Sembilan
                                                                        Villa Langkawi</option>
                                                                    <option value="Senari Bay Resort ">Senari Bay
                                                                        Resort </option>
                                                                    <option value="Seven Stones Langkawi">Seven
                                                                        Stones Langkawi</option>
                                                                    <option value="Shell Out Chenang Beach Resort">
                                                                        Shell Out Chenang Beach Resort</option>
                                                                    <option value="Simfoni Resort">Simfoni Resort
                                                                    </option>
                                                                    <option value="Sri Embun Resort">Sri Embun
                                                                        Resort</option>
                                                                    <option value="Sri Kijang Resort BNM">Sri Kijang
                                                                        Resort BNM</option>
                                                                    <option value="Sri Lagenda Apartment">Sri
                                                                        Lagenda Apartment</option>
                                                                    <option value="Sunset Beach Resort Langkawi">
                                                                        Sunset Beach Resort Langkawi</option>
                                                                    <option value="S’kar Pinang">S’kar Pinang
                                                                    </option>
                                                                    <option value="Taman Desa Impian">Taman Desa
                                                                        Impian</option>
                                                                    <option value="Taman Indah">Taman Indah</option>
                                                                    <option value="Taman Simfoni">Taman Simfoni
                                                                    </option>
                                                                    <option value="Tanabendang Banglos Langkawi">
                                                                        Tanabendang Banglos Langkawi</option>
                                                                    <option value="Tanjung Puteri Motel">Tanjung
                                                                        Puteri Motel</option>
                                                                    <option value="Tanjung Rhu Resort, Langkawi">
                                                                        Tanjung Rhu Resort, Langkawi</option>
                                                                    <option value="Tanjung Rhu Villa">Tanjung Rhu
                                                                        Villa</option>
                                                                    <option value="Telaga Harbour Marina">Telaga
                                                                        Harbour Marina</option>
                                                                    <option value="Telaga Terrace Boutique Hotel">
                                                                        Telaga Terrace Boutique Hotel</option>
                                                                    <option
                                                                        value="Temple Tree Boutique Resort Langkawi">
                                                                        Temple Tree Boutique Resort Langkawi
                                                                    </option>
                                                                    <option value="The Bayou Hotel Langkawi">The
                                                                        Bayou Hotel Langkawi</option>
                                                                    <option value="The Concept Hotel Langkawi ">The
                                                                        Concept Hotel Langkawi </option>
                                                                    <option value="The Cottage Langkawi">The Cottage
                                                                        Langkawi</option>
                                                                    <option value="The Danna">The Danna</option>
                                                                    <option value="The Datai Langkawi">The Datai
                                                                        Langkawi</option>
                                                                    <option value="The Daun Resort">The Daun Resort
                                                                    </option>
                                                                    <option value="The Denai Langkawi ">The Denai
                                                                        Langkawi </option>
                                                                    <option value="The Frangipani Langkawi Resort">
                                                                        The Frangipani Langkawi Resort</option>
                                                                    <option value="The Gemalai Village">The Gemalai
                                                                        Village</option>
                                                                    <option value="The Groove House Langkawi">The
                                                                        Groove House Langkawi</option>
                                                                    <option value="The Laguna">The Laguna</option>
                                                                    <option value="The Monte">The Monte</option>
                                                                    <option value="The Nutshell Chalet Langkawi">The
                                                                        Nutshell Chalet Langkawi</option>
                                                                    <option value="The Ocean Residence Langkawi ">
                                                                        The Ocean Residence Langkawi </option>
                                                                    <option value="The Ritz-Carlton, Langkawi">The
                                                                        Ritz-Carlton, Langkawi</option>
                                                                    <option
                                                                        value="The Riyaz Lavanya Langkawi Hotel ">
                                                                        The Riyaz Lavanya Langkawi Hotel </option>
                                                                    <option value="The Smith Hotel">The Smith Hotel
                                                                    </option>
                                                                    <option value="The St. Regis Langkawi">The St.
                                                                        Regis Langkawi</option>
                                                                    <option value="The Villa Langkawi">The Villa
                                                                        Langkawi</option>
                                                                    <option value="The Weekend Langkawi">The Weekend
                                                                        Langkawi</option>
                                                                    <option
                                                                        value="The Westin Langkawi Resort & Spa">The
                                                                        Westin Langkawi Resort & Spa</option>
                                                                    <option
                                                                        value="The White House Homestay Langkawi">
                                                                        The White House Homestay Langkawi</option>
                                                                    <option value="Tok Cheng Cottage ">Tok Cheng
                                                                        Cottage </option>
                                                                    <option value="Traditional Homestay Chenang ">
                                                                        Traditional Homestay Chenang </option>
                                                                    <option value="Tropical Resort Langkawi">
                                                                        Tropical Resort Langkawi</option>
                                                                    <option value="Tropicana Chenang Office">
                                                                        Tropicana Chenang Office</option>
                                                                    <option value="Tubotel Langkawi">Tubotel
                                                                        Langkawi</option>
                                                                    <option value="Turkish Restaurant & Bazaar">
                                                                        Turkish Restaurant & Bazaar</option>
                                                                    <option value="Ulu Melaka">Ulu Melaka</option>
                                                                    <option value="UnderwaterWorld Langkawi">
                                                                        UnderwaterWorld Langkawi</option>
                                                                    <option value="Villa Abadi Langkawi ">Villa
                                                                        Abadi Langkawi </option>
                                                                    <option value="Villa Paddy">Villa Paddy</option>
                                                                    <option value="Virgo Star Resort">Virgo Star
                                                                        Resort</option>
                                                                    <option value="Vitatree Cottage">Vitatree
                                                                        Cottage</option>
                                                                    <option value="Wang Valley Resort Langkawi ">
                                                                        Wang Valley Resort Langkawi </option>
                                                                    <option value="Wave Langkawi Inn Roomstay">Wave
                                                                        Langkawi Inn Roomstay</option>
                                                                    <option value="We Hotel Langkawi">We Hotel
                                                                        Langkawi</option>
                                                                    <option value="White Lodge Chalet Langkawi">
                                                                        White Lodge Chalet Langkawi</option>
                                                                    <option
                                                                        value="Wings By Croske Resort Langkawi,">
                                                                        Wings By Croske Resort Langkawi,</option>
                                                                    <option value="Y-Connect Cafe Langkawi">
                                                                        Y-Connect Cafe Langkawi</option>
                                                                    <option value="Zen 11 Homestay ">Zen 11 Homestay
                                                                    </option>
                                                                </optgroup>
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


                                <div class="tab-pane fade " id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                                    <form method="get" accept-charset="utf-8"
                                        action="https://www.MRR HOLIDAYS.my/customer/hotels/list">
                                        <div class="row gx-1">
                                            <div class="col-md-4">
                                                <div class="row gx-0 input-group-2-col">
                                                    <div class="col-md mb-2 mb-md-0">
                                                        <div class="input-group select2-floating position-relative">
                                                            <span
                                                                class="icon position-absolute top-50 start-0 translate-middle-y"><i
                                                                    class="fa fa-map-marker-alt text-primary"></i></span>
                                                            <label>Select Hotel Types</label>
                                                            <!-- <input type="text" class="form-control" placeholder="Langkawi" value="Langkawi"> -->
                                                            <select class="form-control input-group border-0"
                                                                name="location" id="location" required>
                                                                <optgroup label="Areas">
                                                                    <option value="2">Kuah (5)</option>
                                                                    <option value="6">Padang Matsirat (1)</option>
                                                                    <option value="3">Pantai Cenang (4)</option>
                                                                    <option value="1">Pantai Kok (2)</option>
                                                                    <option value="7">Pantai Tengah (1)</option>
                                                                </optgroup>
                                                                <optgroup label="Hotels">
                                                                    <option value="Adya Hotel Langkawi">Adya Hotel
                                                                        Langkawi</option>
                                                                    <option value="Aseania Resort & Spa Langkawi ">
                                                                        Aseania Resort & Spa Langkawi </option>
                                                                    <option value="Bayview Hotel Langkawi">Bayview
                                                                        Hotel Langkawi</option>
                                                                    <option
                                                                        value="Bella Vista Waterfront Langkawi ">
                                                                        Bella Vista Waterfront Langkawi </option>
                                                                    <option value="Berjaya Langkawi Resort">Berjaya
                                                                        Langkawi Resort</option>
                                                                    <option value="Best Star Resort ">Best Star
                                                                        Resort </option>
                                                                    <option value="DeBaron Resort Langkawi">DeBaron
                                                                        Resort Langkawi</option>
                                                                    <option value="Goldsands Hotel langkawi">
                                                                        Goldsands Hotel langkawi</option>
                                                                    <option
                                                                        value="Holiday Villa Beach Resort & Spa Langkawi ">
                                                                        Holiday Villa Beach Resort & Spa Langkawi
                                                                    </option>
                                                                    <option value="Nadias Hotel Cenang Langkawi">
                                                                        Nadias Hotel Cenang Langkawi</option>
                                                                    <option value="Ombak Villa Langkawi ">Ombak
                                                                        Villa Langkawi </option>
                                                                    <option
                                                                        value="Pelangi Beach Resort & Spa, Langkawi">
                                                                        Pelangi Beach Resort & Spa, Langkawi
                                                                    </option>
                                                                    <option value="The Danna Hotel ">The Danna Hotel
                                                                    </option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#location').select2();
                                            </script>
                                            <div class="col-md">
                                                <div class="row gx-1 gy-2 gy-md-0 input-group-2-col">
                                                    <div class="col-md ">
                                                        <div class="form-floating input-group">
                                                            <span class="input-group-text"><i
                                                                    class="far fa-calendar-alt text-primary"></i></span>
                                                            <input type="text" name="check_in"
                                                                class="form-control pe-0" id="check_in"
                                                                placeholder="Add dates" value="2021-08-04">
                                                            <label>Check-in Date</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-floating input-group">
                                                            <span class="input-group-text"><i
                                                                    class="far fa-calendar-alt text-primary"></i></span>
                                                            <input type="text" name="check_out"
                                                                class="form-control pe-0" id="check_out"
                                                                placeholder="Add dates" value="2021-08-06">
                                                            <label>Check-out Date</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-2 mt-md-0">
                                                <div class="row gx-1 input-group-2-col">
                                                    <div class="col-md pe-md-0">
                                                        <div
                                                            class="form-floating input-group dropdown dropdown-guest-qty">
                                                            <span class="input-group-text"><i
                                                                    class="fas fa-user-friends text-primary"></i></span>
                                                            <input type="text" class="form-control pe-0"
                                                                id="add-guest" data-bs-toggle="dropdown"
                                                                value="2 Adult, 1 Children, 1 Room">

                                                            <div class="dropdown-menu p-4">
                                                                <div class="row gx-2 align-items-center">
                                                                    <div class="col-5 col-md-12 col-lg-5">
                                                                        Adult </div>
                                                                    <div class="col">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <button
                                                                                    class="btn btn-decrement btn-light btn-circle"
                                                                                    id="btn-minus-adult"
                                                                                    type="button"><strong>−</strong></button>
                                                                            </div>
                                                                            <input type="text" id="adult"
                                                                                name="no_of_adult" placeholder="0"
                                                                                value="2" data-min="0"
                                                                                class="form-control qty text-center adult mx-2  ?>">
                                                                            <div class="input-group-append">
                                                                                <button
                                                                                    class="btn btn-increment btn-light btn-circle"
                                                                                    id="btn-plus-adult"
                                                                                    type="button"><strong>+</strong>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr class="dropdown-divider">
                                                                <div class="row gx-2 align-items-center">
                                                                    <div class="col-5 col-md-12 col-lg-5">
                                                                        Children </div>
                                                                    <div class="col">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <button
                                                                                    class="btn btn-decrement btn-light btn-circle"
                                                                                    id="btn-minus-child"
                                                                                    type="button"><strong>−</strong></button>
                                                                            </div>
                                                                            <input type="text" id="child"
                                                                                name="no_of_child" placeholder="0"
                                                                                value="1" data-min="0"
                                                                                class="form-control text-center child mx-2 qty ?>">
                                                                            <div class="input-group-append">
                                                                                <button
                                                                                    class="btn btn-increment btn-light btn-circle"
                                                                                    id="btn-plus-child"
                                                                                    type="button"><strong>+</strong>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr class="dropdown-divider">
                                                                <div class="row gx-2 align-items-center">
                                                                    <div class="col-5 col-md-12 col-lg-5">
                                                                        Room </div>
                                                                    <div class="col">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <button
                                                                                    class="btn btn-decrement btn-light btn-circle"
                                                                                    id="btn-minus-room"
                                                                                    type="button"><strong>−</strong></button>
                                                                            </div>
                                                                            <input type="text" id="room"
                                                                                name="no_of_room" placeholder="0"
                                                                                value="1" data-min="0"
                                                                                class="form-control text-center room mx-2 qty ?>">
                                                                            <div class="input-group-append">
                                                                                <button
                                                                                    class="btn btn-increment btn-light btn-circle"
                                                                                    id="btn-plus-room"
                                                                                    type="button"><strong>+</strong>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-grid mt-3 d-md-none">
                                                                    <button
                                                                        class="btn btn-primary close-drop-travellers">Ok</button>
                                                                </div>
                                                            </div>
                                                            <label>No Guests</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-auto mt-2 mt-md-0">
                                                <button class="btn btn-primary h-100 w-100 px-3">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script>
                                        $(document).ready(function () {
                                            flatpickr("#check_in", {
                                                altInput: true,
                                                altFormat: "j M Y",
                                                dateFormat: "Y-m-d",
                                                defaultDate: ["today"],
                                                minDate: "today",
                                                disableMobile: "true"

                                            });

                                            var currentDate = new Date();
                                            flatpickr("#check_out", {
                                                altInput: true,
                                                altFormat: "j M Y",
                                                dateFormat: "Y-m-d",
                                                defaultDate: currentDate.setDate(currentDate.getDate() + 1),
                                                minDate: "today",
                                                disableMobile: "true"
                                            });

                                            $("#check_in").on('change', function () {
                                                var p = $(this).val();
                                                var r = $("#check_out").val();

                                                var pickup_d = new Date(p);
                                                var return_d = new Date(r);

                                                if (pickup_d >= return_d) {
                                                    pickup_d.setDate(pickup_d.getDate() + 1);

                                                    var result = pickup_d.getFullYear() + '-' + (pickup_d.getMonth() + 1) + '-' + pickup_d.getDate();

                                                    flatpickr("#check_out", {
                                                        altInput: true,
                                                        altFormat: "j M Y",
                                                        dateFormat: "Y-m-d",
                                                        defaultDate: result,
                                                        minDate: p,
                                                        disableMobile: "true"

                                                    });
                                                } else {
                                                    flatpickr("#check_out", {
                                                        altInput: true,
                                                        altFormat: "j M Y",
                                                        dateFormat: "Y-m-d",
                                                        minDate: p,
                                                        disableMobile: "true"
                                                    });
                                                }
                                            });
                                        });
                                    </script>
                                </div>

                                <div class="tab-pane fade " id="experience" role="tabpanel"
                                    aria-labelledby="experience-tab">
                                    <form method="get" accept-charset="utf-8"
                                        action="https://www.MRR HOLIDAYS.my/attractions/all">
                                        <div class="row gx-1">
                                            <div class="col-md">
                                                <div class="row gx-0 input-group-2-col">
                                                    <div class="col-md mb-2 mb-md-0">
                                                        <div class="input-group select2-floating position-relative">
                                                            <span
                                                                class="icon position-absolute top-50 start-0 translate-middle-y"><i
                                                                    class="fa fa-map-marker-alt text-primary"></i></span>
                                                            <select class="form-control" name="activity"
                                                                id="activity" required>
                                                                <optgroup label="Activity">
                                                                    <option value="2">All Attractions (24)</option>
                                                                </optgroup>
                                                                <optgroup label="Attractions">
                                                                    <option value="ATV Adventure Ride">ATV Adventure
                                                                        Ride</option>
                                                                    <option
                                                                        value="Crocodile Adventureland Langkawi">
                                                                        Crocodile Adventureland Langkawi</option>
                                                                    <option
                                                                        value="Dayang Bunting Marble Geoforest Park">
                                                                        Dayang Bunting Marble Geoforest Park
                                                                    </option>
                                                                    <option value="Dream Forest Langkawi">Dream
                                                                        Forest Langkawi</option>
                                                                    <option
                                                                        value="Eco Adventure by Darulaman Sanctuary">
                                                                        Eco Adventure by Darulaman Sanctuary
                                                                    </option>
                                                                    <option value="Langkawi Halal Cruise">Langkawi
                                                                        Halal Cruise</option>
                                                                    <option value="Langkawi Island Hopping">Langkawi
                                                                        Island Hopping</option>
                                                                    <option
                                                                        value="Langkawi Jet Ski Tour By Mega Water Sports ">
                                                                        Langkawi Jet Ski Tour By Mega Water Sports
                                                                    </option>
                                                                    <option
                                                                        value="Langkawi Jetski & Watersports Tour">
                                                                        Langkawi Jetski & Watersports Tour</option>
                                                                    <option value="Langkawi Mangrove Tour">Langkawi
                                                                        Mangrove Tour</option>
                                                                    <option value="Langkawi Premium Cruise">Langkawi
                                                                        Premium Cruise</option>
                                                                    <option
                                                                        value="Langkawi SkyCab Cable Car Ticket">
                                                                        Langkawi SkyCab Cable Car Ticket</option>
                                                                    <option value="Langkawi Sunset Cruise">Langkawi
                                                                        Sunset Cruise</option>
                                                                    <option value="Maha Tower Langkawi">Maha Tower
                                                                        Langkawi</option>
                                                                    <option value="Makam Mahsuri">Makam Mahsuri
                                                                    </option>
                                                                    <option value="Mangrove Kayaking Tour">Mangrove
                                                                        Kayaking Tour</option>
                                                                    <option value="Morac Adventure Park ">Morac
                                                                        Adventure Park </option>
                                                                    <option value="Paradise 101 Langkawi">Paradise
                                                                        101 Langkawi</option>
                                                                    <option value="Pulau Payar Langkawi Tickets">
                                                                        Pulau Payar Langkawi Tickets</option>
                                                                    <option value="Skytrex Adventure Langkawi">
                                                                        Skytrex Adventure Langkawi</option>
                                                                    <option value="Splash Out Langkawi Ticket">
                                                                        Splash Out Langkawi Ticket</option>
                                                                    <option value="The Els Club Teluk Datai">The Els
                                                                        Club Teluk Datai</option>
                                                                    <option
                                                                        value="Underwater World Langkawi Ticket">
                                                                        Underwater World Langkawi Ticket</option>
                                                                    <option value="Wildlife Park Langkawi">Wildlife
                                                                        Park Langkawi</option>
                                                                </optgroup>
                                                            </select>
                                                            <label>Search activities</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-auto mt-2 mt-md-0">
                                                <button id="search-attraction"
                                                    class="btn btn-primary h-100 w-100 px-3">Search</button>
                                            </div>
                                            <script>
                                                $('#activity').select2();
                                            </script>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function () {
                            var target_time = '2:15 AM';
                            $('#start-time option[value="' + target_time + '"]').prop('selected', true);
                            $('#end-time  option[value="' + target_time + '"]').prop('selected', true);



                            flatpickr("#pickup_date", {
                                altInput: true,
                                altFormat: "j M Y",
                                dateFormat: "Y-m-d",
                                defaultDate: ["today"],
                                minDate: "today",
                                disableMobile: "true"

                            });

                            var currentDate = new Date();
                            flatpickr("#return_date", {
                                altInput: true,
                                altFormat: "j M Y",
                                dateFormat: "Y-m-d",
                                defaultDate: currentDate.setDate(currentDate.getDate() + 1),
                                minDate: "today",
                                disableMobile: "true"
                            });

                            $("#pickup_date").on('change', function () {
                                var p = $(this).val();
                                var r = $("#return_date").val();

                                var pickup_d = new Date(p);
                                var return_d = new Date(r);

                                if (pickup_d >= return_d) {
                                    pickup_d.setDate(pickup_d.getDate() + 1);

                                    var result = pickup_d.getFullYear() + '-' + (pickup_d.getMonth() + 1) + '-' + pickup_d.getDate();

                                    flatpickr("#return_date", {
                                        altInput: true,
                                        altFormat: "j M Y",
                                        dateFormat: "Y-m-d",
                                        defaultDate: result,
                                        minDate: p,
                                        disableMobile: "true"

                                    });
                                } else {
                                    flatpickr("#return_date", {
                                        altInput: true,
                                        altFormat: "j M Y",
                                        dateFormat: "Y-m-d",
                                        minDate: p,
                                        disableMobile: "true"
                                    });
                                }


                            });

                            $('#diff_loc').on('change', function () {
                                if ($(this).prop('checked') === true) {
                                    $('#return_col').removeClass('d-none').addClass('narrow').find(':input').prop('disabled', false);
                                    $('#pickup_col').addClass('narrow');
                                } else {
                                    $('#return_col').addClass('d-none').removeClass('narrow').find(':input').prop('disabled', true);
                                    $('#pickup_col').removeClass('narrow');
                                }
                            });

                            //experience
                            flatpickr("#date", {
                                altInput: true,
                                altFormat: "j M Y",
                                dateFormat: "Y-m-d",
                                defaultDate: ["today"],
                                minDate: "today",
                                disableMobile: "true"
                            });
                        });

                        $(document).scroll(function () {
                            var y = $(this).scrollTop();
                            if (y > 5) {
                                $('.wrap-search-form').addClass('expand');
                                //$('.to-top').fadeIn();
                            } else {
                                $('.wrap-search-form').removeClass('expand');
                                //$('.to-top').hide();
                            }
                        });
                    </script>
                    <!-- Car Rental End -->

                    <!-- Hotel -->
                    <script>
                        $(document).ready(function () {
                            $('.dropdown-menu').on("click.bs.dropdown", function (e) {
                                e.stopPropagation();
                                // e.preventDefault();
                            });


                            $("#btn-plus-adult").click(function () {
                                let adult = parseInt($("#adult").val());
                                let child = parseInt($("#child").val());
                                let room = parseInt($("#room").val());

                                adult = adult + 1;

                                $("#adult").val(adult);
                                $("#add-guest").val(adult + ' Adult, ' + child + ' Children, ' + room + ' Room');
                            });

                            $("#btn-minus-adult").click(function () {
                                let adult = parseInt($("#adult").val());
                                let child = parseInt($("#child").val());
                                let room = parseInt($("#room").val());

                                adult = adult - 1;

                                if (adult < 1) {
                                    $("#adult").val(1);
                                    $("#add-guest").val(1 + ' Adult, ' + child + ' Children, ' + room + ' Room');
                                } else {
                                    $("#adult").val(adult);
                                    $("#add-guest").val(adult + ' Adult, ' + child + ' Children, ' + room + ' Room');
                                }
                            });

                            $("#btn-plus-child").click(function () {
                                let adult = parseInt($("#adult").val());
                                let child = parseInt($("#child").val());
                                let room = parseInt($("#room").val());

                                child = child + 1;

                                $("#child").val(child);
                                $("#add-guest").val(adult + ' Adult, ' + child + ' Children, ' + room + ' Room');
                            });

                            $("#btn-minus-child").click(function () {
                                let adult = parseInt($("#adult").val());
                                let child = parseInt($("#child").val());
                                let room = parseInt($("#room").val());

                                child = child - 1;

                                if (child < 1) {
                                    $("#child").val(0);
                                    $("#add-guest").val(adult + ' Adult, ' + 0 + ' Children, ' + room + ' Room');
                                } else {
                                    $("#child").val(child);
                                    $("#add-guest").val(adult + ' Adult, ' + child + ' Children, ' + room + ' Room');
                                }
                            });


                            $("#btn-plus-room").click(function () {
                                let adult = parseInt($("#adult").val());
                                let child = parseInt($("#child").val());
                                let room = parseInt($("#room").val());

                                room = room + 1;

                                $("#room").val(room);
                                $("#add-guest").val(adult + ' Adult, ' + child + ' Children, ' + room + ' Room');
                            });

                            $("#btn-minus-room").click(function () {
                                let adult = parseInt($("#adult").val());
                                let child = parseInt($("#child").val());
                                let room = parseInt($("#room").val());

                                room = room - 1;

                                if (room < 1) {
                                    $("#room").val(1);
                                    $("#add-guest").val(adult + ' Adult, ' + child + ' Children, ' + 1 + ' Room');
                                } else {
                                    $("#room").val(room);
                                    $("#add-guest").val(adult + ' Adult, ' + child + ' Children, ' + room + ' Room');
                                }
                            });

                            $(".close-drop-travellers").click(function () {
                                $(".dropdown-guest-qty .dropdown-menu, .dropdown-guest-qty .form-control").removeClass("show");
                            });
                        });
                    </script>
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
                            <img src="img/icon/icon-choose-car.svg" class="img-fluid" alt="">
                        </div>
                        <h3>Search & Explore</h3>
                        <div>Find vehicles and get quotes that suits your budget and style.</div>
                    </div>

                    <div class="col-md mt-4 mt-md-0">
                        <div class="shadow p-3 d-inline-block rounded-3 mb-3 mb-md-4 box-icon">
                            <img src="img/icon/icon-payment-secure.svg" class="img-fluid" alt="">
                        </div>
                        <h3>Book & Pay</h3>
                        <div>Select and confirm your dates and book securely.</div>
                    </div>

                    <div class="col-md mt-4 mt-md-0">
                        <div class="shadow p-3 d-inline-block rounded-3 mb-3 mb-md-4 box-icon">
                            <img src="img/icon/icon-car.svg" class="img-fluid" alt="">
                        </div>
                        <h3>Travel & Enjoy</h3>
                        <div>Collect your car and live like a local anywhere Langkawi.</div>
                    </div>
                </div>
            </div>
        </section>

        {{--  <section class="my-7">
            <div class="container">
                <h2 class="text-center text-primary p-3">Our Vehicles</h2>
                <?php
                $ourTypes = getProductTypesByCategoryww(44);
                $isActive = true;
                ?>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php foreach ($ourTypes as $index => $type): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $isActive ? 'active' : '' ?>"
                                    id="<?= strtolower($type) ?>-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#<?= strtolower($type) ?>"
                                    type="button"
                                    role="tab"
                                    aria-controls="<?= strtolower($type) ?>"
                                    aria-selected="<?= $isActive ? 'true' : 'false' ?>">
                                <?= ucfirst($type) ?>
                            </button>
                        </li>
                        <?php $isActive = false; ?>
                    <?php endforeach; ?>
                </ul>


            </div>
        </section>  --}}

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mb-5" id="sedan" role="tabpanel" aria-labelledby="sedan-tab">
                <div class="container mt-3">
                    <div class="row gy-4">
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-3">
                                <div class="card ">
                                    <div class="label-fleet-deals text-uppercase">
                                        <?= htmlspecialchars($product->discount_text) ?>
                                    </div>
                                    <div class="card-img-top" style="background-color:#DEEBEA">
                                        <?php
                                            $image = $product->get_thumbnail;
                                            if ($image):
                                        ?>
                                            <img src="<?= asset($image->path) ?>" alt="<?= htmlspecialchars($product->title) ?>" class="img-fluid">
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="text-center"><?= htmlspecialchars($product->title) ?></h5>
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
                                                <span class="text-muted fw-bold">RM
                                                    <h4 class="d-inline-block">
                                                        <del><?= htmlspecialchars(number_format($product->price, 2)) ?></del>
                                                    </h4>
                                                </span><br>
                                                <span class="text-danger fw-bold">RM
                                                    <h4 class="d-inline-block"><?= htmlspecialchars(number_format($product->selling_price, 2)) ?></h4>
                                                </span>
                                            </div>
                                            <div class="col-md-auto my-auto btnBooking_area">
                                                <div class="fw-bold text-danger text-end">
                                                    <?= htmlspecialchars($product->stock) ?> unit left!
                                                </div>
                                                <div class="row">
                                                    <?php
                                                    // Current date and time
                                                    $today = date('Y-m-d H:i:s');

                                                    // Next day with the same time
                                                    $nextDay = date('Y-m-d H:i:s', strtotime('+1 day'));
                                                    ?>
                                                    <a href="<?= route('booking', ['slug' => $product->slug, 'today' => $today, 'from' => $nextDay]) ?>"
                                                       class="btn btn-primary">
                                                        Book Now
                                                    </a>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
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

                <div class="accordion alt mt-4" id="accordionFaq">
                    <div class="accordion-item shadow-sm">
                        <h2 class="accordion-header" id="heading-12">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-12" aria-expanded="false" aria-controls="collapse-12">
                                How much does it cost to rent a car in Langkawi? </button>
                        </h2>
                        <div id="collapse-12" class="accordion-collapse collapse" aria-labelledby="heading-12"
                            data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                The starting price for an average rental car is RM70.00 per day.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item shadow-sm">
                        <h2 class="accordion-header" id="heading-13">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-13" aria-expanded="false" aria-controls="collapse-13">
                                Is it necessary to rent a car in Langkawi?
                            </button>
                        </h2>
                        <div id="collapse-13" class="accordion-collapse collapse" aria-labelledby="heading-13"
                            data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Renting a car in Langkawi is highly advisable as it is cheaper and more convenient
                                than using public transportation. </div>
                        </div>
                    </div>
                    <div class="accordion-item shadow-sm">
                        <h2 class="accordion-header" id="heading-14">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-14" aria-expanded="false" aria-controls="collapse-14">
                                What are the most affordable cars to rent in Langkawi?
                            </button>
                        </h2>
                        <div id="collapse-14" class="accordion-collapse collapse" aria-labelledby="heading-14"
                            data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                Smaller cars, such as the Perodua Axia, Proton Saga, and Perodua Bezza are the most
                                affordable options for rental in Langkawi. </div>
                        </div>
                    </div>
                    <div class="accordion-item shadow-sm">
                        <h2 class="accordion-header" id="heading-15">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-15" aria-expanded="false" aria-controls="collapse-15">
                                What are the required documents to rent a car in Langkawi?
                            </button>
                        </h2>
                        <div id="collapse-15" class="accordion-collapse collapse" aria-labelledby="heading-15"
                            data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                You will need to provide a valid driving license and a passport or identity card to
                                rent a car in Langkawi. </div>
                        </div>
                    </div>
                    <div class="accordion-item shadow-sm">
                        <h2 class="accordion-header" id="heading-16">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-16" aria-expanded="false" aria-controls="collapse-16">
                                What are the types of cars available to rent in Langkawi?
                            </button>
                        </h2>
                        <div id="collapse-16" class="accordion-collapse collapse" aria-labelledby="heading-16"
                            data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                We offer a wide range of cars including Compact, Sedans, MPVs, SUVs, and Luxury
                                cars.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light py-5 text-center">
            <div class="container">
                <img src="img/logo/logo.png" class="img-fluid mx-auto mb-4" style="height:100px" alt="">
                <p class="h5 mb-3">
                    MRR HOLIDAYS is your premier online destination for budget-friendly car rental solutions in
                    Langkawi, Kedah. Our platform offers seamless access to Langkawi car rental services along with
                    convenient hotel bookings, exciting tour activities, and tickets to renowned attractions accross
                    the island, including <a href="#"
                        target="_blank">Langkawi Skycab Cable Car</a>,
                    <a href="#" target="_blank">Island Hopping Tour</a>,
                    and <a href="#" target="_blank">Mangrove Tour</a>.
                </p>
                <p class="h5">
                    Experience hassle-free travel with our diverse range of vehicles, including Sedans, SUVs, MPVs
                    and Compact cars, all at competitive pricing. At MRR HOLIDAYS, we prioritize your convenience.
                    Opt for our airport pickup service for a seamless transition from your flight to the road.
                    Alternatively, choose from our various drop-off locations scattered conveniently accross
                    Langkawi, ensuring a smooth start to your exploration of this enchanting island. </p>
            </div>
        </section>
        <script>
            $(document).ready(function () {
                $('.slider-review').slick({
                    centerMode: true,
                    infinite: true,
                    slidesToShow: 3,
                    autoplay: false,
                    autoplaySpeed: 5000,
                    arrows: false,
                    dots: true,
                    adaptiveHeight: true,
                    responsive: [{
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: false,
                        }
                    }
                    ]
                });

                $('[data-bs-toggle="tooltip"]').tooltip();

                $('.btnBooking_area').on('click', '.btn_booking', function (e) {
                    e.preventDefault();
                    var link = 'customer/fleets/book.html';

                    var pickup_loc = $('#input_pickup').val();
                    var return_loc = $('#input_return').val();
                    var pickup_date = $('#pickup_date').val();
                    var pickup_time = $('#start-time').val();
                    var return_date = $('#return_date').val();
                    var return_time = $('#end-time').val();
                    // var diff_loc    = $('#diff_loc').val();

                    var id = $(this).data('id');

                    if (pickup_loc == '') {
                        pickup_loc = 'Langkawi Airport (Door 3)';
                    }

                    if (return_loc == '') {
                        return_loc = 'Langkawi Airport (Door 3)';
                    }

                    if ($('#diff_loc').prop('checked') == false) {
                        diff_loc = '0'
                    } else {
                        diff_loc = '1'
                    }

                    var redirect = link + '/' + id + '?custom_pickup_location=' + pickup_loc + '&custom_return_location=' + return_loc + '&start_date=' + pickup_date + '&start_time=' + pickup_time + '&end_date=' + return_date + '&end_time=' + return_time + '&use_different_return_location=' + diff_loc;

                    window.location.href = redirect;
                });

                $(".btn_hotel_booking").on('click', function (a) {
                    a.preventDefault();
                    var link = '/customer/hotels';

                    var hotel_id = $(this).data('id');
                    var hotel_name = $(this).data('name').replace(/[^a-zA-Z ]/g, "");
                    var check_in = $("#check_in").val();
                    var check_out = $("#check_out").val();
                    var no_of_adult = '2';
                    var no_of_child = '1';
                    var no_of_room = '1';
                    // console.log(hotel_name);
                    // console.log(hotel_id);
                    var redirect = link + '?location=' + hotel_name + '&check_in=' + check_in + '&check_out=' + check_out + '&no_of_adult=' + no_of_adult + '&no_of_child= ' + no_of_child + '&no_of_room=' + no_of_room + '&hotel_id=' + hotel_id;

                    window.location.href = redirect;

                });

                $(".btn-toggle-collapse").click(function () {
                    $('.review-body-' + $(this).attr('data-id')).toggleClass('expand');
                    var reviewBody = document.getElementById("review-" + $(this).attr('data-id'));
                    if (reviewBody.classList.contains('expand')) {
                        document.querySelector('#buttonRead-' + $(this).attr('data-id')).textContent = 'Show less';
                    } else {
                        document.querySelector('#buttonRead-' + $(this).attr('data-id')).textContent = 'Show more';
                    }
                });
            });
        </script>
    </div>
</main>
@endsection
