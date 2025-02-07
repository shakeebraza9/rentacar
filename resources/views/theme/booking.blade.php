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

<div class="booking-main-container my-7">
    <div class="container my-4">
      <div class="row ">
        <div class="col-md-4">
          <div class="card ">

            <div class="card-img-top" style="background-color:#DEEBEA">
                <img src="{{ asset($product->get_thumbnail->path)  }}"
                    class="img-fluid"
                    alt="MRR HOLIDAYS Car Rental in Langkawi Sedan Toyota Vios New Variant 1.5 (A)">
            </div>
            <div class="card-body">
                <h5 class="text-center">{{ $product->get_title  }} </h5>
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
                                <del>{{  $product->price }}</del></h4></span><br>
                        <span class="text-danger fw-bold">RM <h4 class="d-inline-block">{{  $product->selling_price }}
                            </h4></span>
                    </div>
                    <div class="col-md-auto my-auto btnBooking_area">
                        <div class="fw-bold text-danger text-end">
                            <?= htmlspecialchars($product->stock) ?> unit left! </div>
                            <div class="row">
                                @if($isBooked)
                                    <button class="btn btn-secondary" disabled>Already Booked</button>
                                @else
                                <a href="{{ route('customers.orders', ['slug' => $product->slug]) }}" class="btn btn-primary">Book Now</a>


                                @endif
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

                            <input type="text" name="start_date"
                                class="form-control pe-0" placeholder="29 Apr 2021"
                                id="pickup_date">
                            <label class="small" style="padding: 20px 0px; text-wrap: nowrap;">Pickup Date</label>
                        </div>
                    </div>
                    <div class="col-6 col-md ps-md-0">
                        <div class="form-floating input-group">

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
                                <option value="7:   30 PM">7:30 PM</option>
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
                            <label class="small" style="padding: 20px 0px; text-wrap: nowrap;">Pickup Time</label>
                        </div>
                    </div>
                    <div class="col-6 col-md pe-md-0">
                        <div class="form-floating input-group">

                            <input type="text" name="end_date"
                                class="form-control pe-0" placeholder="29 Apr 2021"
                                id="return_date">
                            <label class="small" style="padding: 20px 0px; text-wrap: nowrap;">Return Date</label>
                        </div>
                    </div>
                    <div class="col-6 col-md ps-md-0">
                        <div class="form-floating input-group">

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
                            <label class="small" style="padding: 20px 0px; text-wrap: nowrap;">Return Time</label>
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
                            alt="{{ $similarProduct->name }}">
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">{{ $similarProduct->name }}</h5>
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
                        <div class="row">
                            <div class="col-md">
                                <span class="text-muted fw-bold d-block">From</span>
                                <span class="text-muted fw-bold">RM
                                    <h4 class="d-inline-block">
                                        <del>{{ number_format($similarProduct->price, 2) }}</del>
                                    </h4>
                                </span><br>
                                <span class="text-danger fw-bold">RM
                                    <h4 class="d-inline-block">{{ number_format($similarProduct->discounted_price, 2) }}</h4>
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
            @endforeach
        </div>
    </div>

  </div>
        </div>
      </div>
    </div>

  </div>

  @endsection
  @section('js')

  @endsection
