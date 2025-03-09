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
                                        <button type="button" data-bs-target="#PromoCaptions" data-bs-slide-to="1"
                                            aria-label="Slide 2"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <!-- <img src="..." class="d-block w-100" alt="..."> -->
                                            <img src="../uploads/promotion/20240114_LB_JanAds_Attraction_3228-1736932848.jpg"
                                                class="img-fluid" alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <!-- <img src="..." class="d-block w-100" alt="..."> -->
                                            <img src="../uploads/promotion/20240114_LB_JanAds_CarRental%20(1)_3228-1736925980.jpg"
                                                class="img-fluid" alt="">
                                        </div>
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

                        <div class="wrap-search-form">
                            <div class="search-form">
                                <ul class="nav nav-tabs nav-justified pt-3 px-md-3 mb-2 mb-md-0" id="searchTab"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="../index.html"><button class="nav-link btn " id="car-rental-tab"
                                                type="button" role="tab" aria-controls="car-rental"
                                                aria-selected="false"><span class="icon-circle"><i
                                                        class="fa fa-car"></i></span>
                                                <div>Car Rental</div>
                                            </button></a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a href="../attractions.html"><button class="nav-link btn active"
                                                id="experience-tab" type="button" role="tab" aria-controls="experience"
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
                                            data-bs-target="#chauffeur" type="button" role="tab" aria-controls="chauffeur"
                                            aria-selected="false"><span class="icon-circle">
                                                <span class="soon">COMING SOON</span><i class="fa fa-user-tie"></i></span>
                                            <div>Chauffeur</div>
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content p-3" id="searchTabContent">


                                    <div class="tab-pane fade show active" id="experience" role="tabpanel"
                                        aria-labelledby="experience-tab">
                                        <form method="get" accept-charset="utf-8" id="attractionForm">
                                            <div class="row gx-1">
                                                <div class="col-md">
                                                    <div class="row gx-0 input-group-2-col">
                                                        <div class="col-md mb-2 mb-md-0">
                                                            <div class="input-group select2-floating position-relative">
                                                                <span class="icon position-absolute top-50 start-0 translate-middle-y">
                                                                    <i style="font-size: 20px; margin-left: 35px;" class="fa fa-map-marker-alt text-primary"></i>
                                                                </span>
                                                                <select class="form-control" name="activity" id="activity" required>
                                                                    <option disabled selected value="">Select an Activity</option>
                                                                    <optgroup label="Activity">
                                                                        <option value="all">All Attractions ({{ $attractions->count() }})</option>
                                                                    </optgroup>
                                                                    <optgroup label="Attractions">
                                                                        @foreach ($attractions as $attraction)
                                                                            <option value="{{ $attraction->slug }}">{{ $attraction->title }}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                </select>
                                                                <label>Search activities</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-auto mt-2 mt-md-0">
                                                    <button type="submit" id="search-attraction" class="btn btn-primary h-100 w-100 px-3">Search</button>
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



            <section class="my-5">
                <div class="container">
                    <div class="row align-items-center text-center text-md-start">
                        <h2 class="text-center text-primary mb-5">Why Book With Us?</h2>
                        <div class="col-md">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="../img/icon/icon-suitcase.svg" class="img-fluid" alt="">
                                </div>
                                <div class="col mt-2 mt-md-0">
                                    <h3>Tailored Experience</h3>
                                    <div class="text-muted">
                                        Based on user reviews </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md mt-4 mt-md-0">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="../img/icon/icon-wallet.svg" class="img-fluid" alt="">
                                </div>
                                <div class="col mt-2 mt-md-0">
                                    <h3>Budget-Friendly Price</h3>
                                    <div class="text-muted">
                                        Travel without worrying </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md mt-4 mt-md-0">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="../img/icon/icon-alarm-clock.svg" class="img-fluid" alt="">
                                </div>
                                <div class="col mt-2 mt-md-0">
                                    <h3>Instant Confirmation</h3>
                                    <div class="text-muted">
                                        Booking confirmed instantly </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <hr>
            <section class="my-5">
                <div class="container">
                    <h2 class="text-center text-primary mt-3">Our Attractions</h2>

                    <div id="slider-attractions" class="splide splide-primary mb-4 mb-md-5 mt-4">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($attractions as $attraction)
                                    <li class="splide__slide">
                                        <div class="card mx-3">
                                            @if ($attraction->discount_price && $attraction->selling_price)
                                                <div class="label-discount">
                                                    {{ round((($attraction->selling_price - $attraction->discount_price) / $attraction->selling_price) * 100, 2) }}% OFF
                                                </div>
                                            @endif
                                            <img src="{{ asset($attraction->get_thumbnail->path ?? 'default-image.jpg') }}"
                                                alt="{{ $attraction->title }}" class="card-img-top img-fluid object-fit-lg">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="{{ route('attractions.detail', $attraction->slug) }}" class="text-dark">
                                                        {{ $attraction->title }}
                                                    </a>
                                                </h5>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="text-danger">
                                                            @if ($attraction->selling_price)
                                                                <p class="m-0 text-muted">RM <span class="fs-4">
                                                                    <del>{{ number_format($attraction->selling_price, 2) }}</del>
                                                                </span></p>
                                                            @endif
                                                            <div class="text-danger">
                                                                <span class="text-muted">From</span> RM <span class="fs-3 fw-bold">
                                                                    {{ number_format($attraction->discount_price ?? $attraction->selling_price, 2) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto my-auto">
                                                        <a href="{{ route('attractions.detail', ['slug' => $attraction->slug]) }}" class="btn btn-primary">Book Now</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('attractions.list') }}" class="btn btn-outline-primary">See more attractions</a>
                </div>
            </section>


            <section class="mt-5 bg-light py-4">
                <h2 class="text-center text-primary mt-3">Our Reviews</h2>
                <div class="slider-review">
                    @foreach ($reviews as $review)
                        <div class="m-3">
                            <div class="card rounded-3 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="{{ asset($review->image_path ?? 'default-image.jpg') }}" class="img-fluid w-100" alt="Product Image">
                                            <div class="text-center mt-3">
                                                <div class="stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $review->rating ? 'fas fa-star' : 'far fa-star' }} fa-1x text-primary"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 position-relative">
                                            <div class="mb-7">
                                                <div class="review-body-{{ $review->id }} content-collapse" id="review-{{ $review->id }}">
                                                    "{{ Str::limit($review->review, 150) }}"
                                                </div>
                                                @if (strlen($review->review) > 150)
                                                    <button class="btn btn-sm btn-light btn-toggle-collapse mt-3"
                                                        data-id="{{ $review->id }}"
                                                        data-value="{{ $review->review }}"
                                                        id="buttonRead-{{ $review->id }}">
                                                        Show more
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="fst-italic text-muted position-absolute bottom-0 end-0 p-3">
                                                By {{ $review->user_name }} <span class="flag-icon flag-icon-{{ strtolower($review->country ?? 'us') }}"></span><br>
                                                <span class="small text-dark">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    {{ $review->product_name }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline-primary">See more reviews</a>
                </div>
            </section>


            <section class="mt-7">
                <div class="container">
                    <h2 class="text-center text-primary mt-3">FAQ</h2>

                    {!! getFaqsByType('attraction') !!}
                </div>
            </section>

            <section class="mt-6 bg-light py-5 text-center">
                <div class="container">
                    <img src="../img/logo-langkawibook.svg" class="img-fluid mx-auto mb-4" style="height: 40px" alt="">
                    <p class="h5 mb-3">
                        With Langkawibook, discover the best activities, tours, and attractions that Langkawi has to
                        offer. Get your adrenaline pumping with the <a href="langkawi-skycab-cable-car.html"
                            target="_blank">Langkawi Skycab</a>, the world’s steepest cable car ride that offers
                        breathtaking views of the island. Or, explore the marine life with <a
                            href="underwater-world-langkawi.html" target="_blank">Underwater World Langkawi</a>, one of
                        the largest marine and freshwater aquaria in South East Asia. </p>

                    <p class="h5 mb-3">
                        We also offer bookings for many other attractions and tour packages in Langkawi, such as <a
                            href="langkawi-mangrove-tour.html" target="_blank">Kilim Geoforest Park Mangrove Tour</a>,
                        <a href="island-hopping-langkawi.html" target="_blank">Island Hopping Boat Tours</a>, <a
                            href="jetski-tour-by-mega-water-sports.html" target="_blank">Jetski Tour</a>, <a
                            href="paradise-101-langkawi.html" target="_blank">Adventure 101 Paradise Island</a>, <a
                            href="wildlife-park-langkawi.html" target="_blank">Wildlife Park Langkawi</a> and more!
                    </p>

                    <p class="h5 mb-3">
                        Don't miss out on these unforgettable experiences in Langkawi! Book with us today and take
                        advantage of our amazing deals and discounts. With our easy-to-use booking engine, planning your
                        Langkawi adventure has never been easier. </p>

                    <p class="h5">
                        Check out our list of <a href="../blogs/best-things-to-do-in-langkawi.html" target="_blank">15
                            best things to do in Langkawi</a> to help plan your trip. </p>
                </div>
            </section>

            <script>
                new Splide('#slider-attractions', {
                    perPage: 3,
                    pagination: false,
                    rewind: true,
                    breakpoints: {
                        480: {
                            perPage: 1,
                        },
                    }
                }).mount();

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
@section('js')
<script>
    $(document).ready(function () {
        $('#activity').select2();

        $('#attractionForm').on('submit', function (e) {
            e.preventDefault();
            var selectedActivity = $('#activity').val();

            if (selectedActivity) {
                if (selectedActivity === 'all') {
                    window.location.href = "{{ route('attractions.detail', 'all') }}";
                } else {

                    window.location.href = "{{ url('/attractions/detail/') }}" + "/" + selectedActivity;
                }
            }
        });
    });
</script>
@endsection
