@extends('theme.attractions.layout')

@php

@endphp

@section('metatags')
    <title>{{$global_d['site_title']}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('css')

    <style>

    </style>

@endsection
@section('content')


    <main class="main">
        <div>



            <div class="bg-light pt-4 pb-1 mb-3">
                <div class="container">
                    <form method="get" accept-charset="utf-8">
                        <div class="row align-items-end">
                            <div class="col-md mb-3">
                                <label>Search activities</label>
                                <select class="form-control" name="activity" id="activity" required="">
                                    <option value="">Select Activity</option>
                                    <?php

    foreach ($allAttractions as $attraction) {
        echo '<option value="' . $attraction->id . '">' . htmlspecialchars($attraction->title) . '</option>';
    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <button class="mb-3 btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="container my-4">
                <h1>{{ $attraction->title }}</h1>

                <div class="row mb-5 mt-4">
                    <!-- Carousel Section -->
                    <div class="col-md-6">
                        <div id="slider-hero-experience-details" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-inner h-100">
                                @foreach($attraction->get_images() as $index => $image)
                                    <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}" data-bs-interval="5000">
                                        <img src="{{ asset($image->path) }}" class="img-fluid d-block w-100 rounded-3"
                                            alt="{{ $attraction->title }} Image {{ $index + 1 }}"
                                            style="width:100%; height:100%; object-fit:cover">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#slider-hero-experience-details" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#slider-hero-experience-details" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <!-- Gallery Section -->
                    <div class="col-md-6 mt-4 mt-md-0">
                        <div class="gallery">
                            <div class="row gy-3">
                                {{-- {{ $attraction->get_images() }} --}}
                                @foreach($attraction->get_images() as $index => $image)
                                    <div class="col-6" id="fancy-img{{ $index + 1 }}">
                                        <a data-fancybox="gallery" href="{{ asset($image->path) }}"
                                            data-caption="{{ $attraction->title }} Image {{ $index + 1 }}">
                                            <img src="{{ asset($image->path) }}"
                                                alt="{{ $attraction->title }} Image {{ $index + 1 }}"
                                                class="img-fluid rounded-3" id="img{{ $index + 1 }}">
                                            <span class="overlay-text" id="overlay{{ $index + 1 }}"></span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


                <hr>
                <div class="alert alert-warning mb-4">
                    <h5>Important Notice</h5><br>
                    {{ $attraction->note }}
                </div>
                <div class="card rounded-3">
                    <div class="card-header bg-light">
                        <h2>Overview</h2>
                    </div>
                    <div class="card-body py-1">
                        {!! $attraction->description !!}
                    </div>
                </div>

                <hr class="mt-3">
                <div class="row mt-4">
                    <h2>{{ $attraction->title }} - Availability</h2>
                </div>

                @foreach ($tickets as $ticket)
                    <div class="card mb-3 mt-3">
                        <div class="card-header bg-light">
                            <div class="row mt-2">
                                <div class="col">
                                    <h3>{{ $ticket->title }}</h3>
                                    <h6 class="text-primary btn-detail" style="cursor:pointer;" data-id="{{ $ticket->id }}">View
                                        Details</h6>
                                </div>
                                <div class="col-auto">
                                    <h5 id="individual-slash-price-{{ $ticket->id }}">
                                        @if ($ticket->discount_price)
                                            <p class="m-0 text-muted"><del>RM {{ number_format($ticket->selling_price, 2) }}</del>
                                            </p>
                                        @endif
                                    </h5>
                                    <h5 class="text-danger fs-4 fw-bold" id="individual-big-price-{{ $ticket->id }}">
                                        RM {{ number_format($ticket->discount_price ?? $ticket->selling_price, 2) }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row details-{{ $ticket->id }}" style="display:none;">
                                <div class="col-md-3 border-end mb-2">
                                    <ul class="nav flex-column nav-pills" id="pills-tab-{{ $ticket->id }}" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link link-dark active" id="ticket-tab-{{ $ticket->id }}"
                                                data-bs-toggle="pill" data-bs-target="#ticket-{{ $ticket->id }}" type="button"
                                                role="tab" aria-controls="ticket-{{ $ticket->id }}" aria-selected="true">Ticket
                                                Details</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link link-dark" id="validity-tab-{{ $ticket->id }}"
                                                data-bs-toggle="pill" data-bs-target="#validity-{{ $ticket->id }}" type="button"
                                                role="tab" aria-controls="validity-{{ $ticket->id }}"
                                                aria-selected="false">Validity
                                                Information</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link link-dark" id="reservation-tab-{{ $ticket->id }}"
                                                data-bs-toggle="pill" data-bs-target="#reservation-{{ $ticket->id }}"
                                                type="button" role="tab" aria-controls="reservation-{{ $ticket->id }}"
                                                aria-selected="false">Reservation
                                                Information</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link link-dark" id="cancellation-tab-{{ $ticket->id }}"
                                                data-bs-toggle="pill" data-bs-target="#cancellation-{{ $ticket->id }}"
                                                type="button" role="tab" aria-controls="cancellation-{{ $ticket->id }}"
                                                aria-selected="false">Cancellation
                                                Policy</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link link-dark" id="redemption-tab-{{ $ticket->id }}"
                                                data-bs-toggle="pill" data-bs-target="#redemption-{{ $ticket->id }}"
                                                type="button" role="tab" aria-controls="redemption-{{ $ticket->id }}"
                                                aria-selected="false">Redemption
                                                Method</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md mt-4 mt-md-0">
                                    <div class="tab-content" id="pills-tabContent-{{ $ticket->id }}">
                                        <div class="tab-pane fade show active" id="ticket-{{ $ticket->id }}" role="tabpanel"
                                            aria-labelledby="ticket-tab-{{ $ticket->id }}">
                                            <p><strong>Details:</strong></p>
                                            <ul>
                                                <li>{{ $ticket->description ?? 'No details available.' }}</li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="validity-{{ $ticket->id }}" role="tabpanel"
                                            aria-labelledby="validity-tab-{{ $ticket->id }}">
                                            <ul>
                                                <li>Valid for {{ $ticket->validity ?? 'the duration specified' }}</li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="reservation-{{ $ticket->id }}" role="tabpanel"
                                            aria-labelledby="reservation-tab-{{ $ticket->id }}">
                                            <ul>
                                                <li>Reservation details:
                                                    {{ $ticket->reservation_info ?? 'Please contact us for more details.' }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="cancellation-{{ $ticket->id }}" role="tabpanel"
                                            aria-labelledby="cancellation-tab-{{ $ticket->id }}">
                                            <ul>
                                                <li>{{ $ticket->cancellation_policy ?? 'No cancellation policy available.' }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane fade" id="redemption-{{ $ticket->id }}" role="tabpanel"
                                            aria-labelledby="redemption-tab-{{ $ticket->id }}">
                                            <ul>
                                                <li>{{ $ticket->redemption_info ?? 'No redemption information available.' }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                    <div class="row mt-2 gy-2 gy-md-0">

                                        <div class="col-md-3">
                                            <div class="row gx-1 gy-2 gy-md-0 input-group-2-col">
                                                <div class="col-md pe-md-0">
                                                    <div class="form-floating input-group dropdown dropdown-guest-qty">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-user-friends text-primary"></i></span>
                                                        <input type="text" class="form-control pe-0" id="visitor-1"
                                                            data-bs-toggle="dropdown" value="1 Adult, 0 Children"
                                                            readonly="true" style="font-size: 13px;">
                                                            <div class="dropdown-menu p-4 border">
                                                                <?php foreach ($tickets[0]['variations'] as $variation): ?>
                                                                    <div class="row gx-2 align-items-center">
                                                                        <div class="col-5 col-md-12 col-lg-5">
                                                                            <?= ucfirst($variation['type']) ?> <br>
                                                                            <span class="small text-muted fw-bold">(RM <?= number_format($variation['price'], 2) ?>)</span>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <button class="btn btn-decrement btn-light btn-circle btn-minuss" type="button" data-id="<?= $ticket->id ?>" data-varictionid="<?= $variation['id'] ?>" data-type="<?= $variation['type'] ?>"><strong>−</strong></button>
                                                                                </div>
                                                                                <input type="text" id="<?= $variation['type'] ?>-<?= $ticket->id ?><?= $variation['id'] ?>" name="no_of_<?= $variation['type'] ?>" value="0" data-min="0" class="form-control text-center qty mx-2">
                                                                                <input type="hidden" data-varid="<?= $variation['id'] ?>">
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-increment btn-light btn-circle btn-plus" type="button" data-id="<?= $ticket->id ?>" data-varictionid="<?= $variation['id'] ?>" data-type="<?= $variation['type'] ?>"><strong>+</strong></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <hr class="dropdown-divider">
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <label style="padding-left: 35px;">No of Visitors</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row gx-1 input-group-2-col">
                                                <div class="col-md pe-md-0">
                                                    <div class="form-floating input-group dropdown dropdown-guest-qty">
                                                        <span class="input-group-text"><i
                                                                class="far fa-calendar-alt text-primary"></i></span>
                                                        <input type="hidden" class="form-control pe-0 flatpickr flatpickr-input datapicker-{{ $ticket->id }}"
                                                            data-bs-toggle="dropdown" name="ticket_date" id="flatpickr-1"
                                                            data-id="{{ $ticket->id }}" data-blocked="Array" value="2025-03-04"
                                                            data-gtm-form-interact-field-id="0"><input class="form-control"
                                                            placeholder="" tabindex="0" type="text" readonly="readonly">
                                                        <label style="padding-left: 35px;">Ticket Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md">

                                        </div>

                                        <div class="col-md-auto text-end py-2">

                                            <button type="button" class="btn btn-primary check-availability" data-ticket-id="{{ $ticket->id }}">
                                                Book Now
                                            </button>
                                        </div>
                                    </div>


                        </div>
                    </div>
                @endforeach



                <hr>
                <div class="row mt-3">
                    <div class="col-md-7">
                        <div class="card rounded-3">
                            <div class="card-header bg-light">
                                <h2>Highlights</h2>
                            </div>
                            <div class="card-body">
                                <ul class="mb-1 px-4">
                                    <li>Langkawi SkyCab Cable Car is one of the most-visited attractions on Langkawi Island
                                    </li>
                                    <li>Enjoy the most-exciting cable car ride on the longest free-span ride in Malaysia of
                                        the entire length of 2.2 Km with a continuous spectacular view of Mount Machinchang
                                        at 708m above sea level and surrounding islands</li>
                                    <li>To those who dare, book a glass bottom gondola and enjoy the ride on one of the
                                        steepest cable car slopes in the world</li>
                                    <li>Go up 708m above sea level to catch views of the entire archipelago and Southern
                                        Thailand while enjoying scrumptious food and drinks at the SkyBistro</li>
                                    <li>Explore other attractions like the Eagle’s Nest SkyWalk, SkyBridge, 3D Art, SkyRex,
                                        SkyDome and many more.</li>
                                    <li>Enjoy scrumptious food and hot drinks at the top of the mountain with a spectacular
                                        view.</li>
                                    <li>Any partial refund due to bad weather requires a refund form from the counter.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mt-3 mt-md-0">
                        <div class="card rounded-3">
                            <div class="card-header bg-light">
                                <!-- Things to note -->
                                <h2>Attentive</h2>
                            </div>
                            <div class="card-body">
                                <ul class="mb-1 px-4">
                                    <li>Confirmation will be issued at time of booking</li>
                                    <li>Each Standard Gondola can accommodate 6 persons with a total weight of 480kg</li>
                                    <li>The availability of Skybridge is subject to change depending on weather conditions
                                        (it might be closed for a short period of time)</li>
                                    <li>Please expect a long queue during holiday season</li>
                                    <li>Please reach the station earlier to redeem the cable car tickets.</li>
                                    <li>Children aged 0-2 can enter free of charge Child ticket: aged 3-12 Children aged 13+
                                        will be charged the same rate as adults</li>
                                    <li>SkyCab Cable Car Opening Hours: 10:00-18:00 Everyday. Last admission: 18:00.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="mt-5 bg-light py-4">
                <h2 class="text-center text-primary mt-3">Our Reviews</h2>
                <div class="slider-review">
                    @foreach ($reviews as $review)
                        <div class="m-3">
                            <div class="card rounded-3 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="{{ asset($review->image_path ?? 'default-image.jpg') }}"
                                                class="img-fluid w-100" alt="Product Image">
                                            <div class="text-center mt-3">
                                                <div class="stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="{{ $i <= $review->rating ? 'fas fa-star' : 'far fa-star' }} fa-1x text-primary"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 position-relative">
                                            <div class="mb-7">
                                                <div class="review-body-{{ $review->id }} content-collapse"
                                                    id="review-{{ $review->id }}">
                                                    "{{ Str::limit($review->review, 150) }}"
                                                </div>
                                                @if (strlen($review->review) > 150)
                                                    <button class="btn btn-sm btn-light btn-toggle-collapse mt-3"
                                                        data-id="{{ $review->id }}" data-value="{{ $review->review }}"
                                                        id="buttonRead-{{ $review->id }}">
                                                        Show more
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="fst-italic text-muted position-absolute bottom-0 end-0 p-3">
                                                By {{ $review->user_name }} <span
                                                    class="flag-icon flag-icon-{{ strtolower($review->country ?? 'us') }}"></span><br>
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

            <section class="mt-5 mb-5">
                <div class="container">
                    <h2 class="text-center text-primary mt-3">FAQ</h2>

                    <div class="accordion alt mt-4" id="accordionFaq">
                        <div class="accordion-item shadow-sm">
                            <h2 class="accordion-header" id="heading-1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                                    If I come with my family, can we choose to take the same cable car gondola?
                                </button>
                            </h2>
                            <div id="collapse-1" class="accordion-collapse collapse" aria-labelledby="heading-1"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p>Yes, in most cases, the staff will arrange the family to be in the same gondola. If
                                        that's not the case, you may also ask the on-site staff and request for that.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item shadow-sm">
                            <h2 class="accordion-header" id="heading-2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                    Is the SkyCab cable car suitable for people with acrophobia (fear of heights)? </button>
                            </h2>
                            <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p>The SkyCab cable car ride involves a significant elevation and offers panoramic views
                                        from a high altitude. While it's entirely safe, it might not be comfortable for
                                        people with a fear of heights.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item shadow-sm">
                            <h2 class="accordion-header" id="heading-3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                    What is the best time to visit to avoid long queues? </button>
                            </h2>
                            <div id="collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p>Peak hours are typically during the mid-day and on public holidays or long weekends.
                                        For a more relaxed visit, we recommend visiting early in the morning on a weekday.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item shadow-sm">
                            <h2 class="accordion-header" id="heading-4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                    What happens if the weather is bad on the day of my visit? </button>
                            </h2>
                            <div id="collapse-4" class="accordion-collapse collapse" aria-labelledby="heading-4"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p>The SkyCab cable car operation is subject to weather conditions. In case of extreme
                                        weather, the cable cars may be temporarily closed for safety reasons. But not to
                                        worry, any changes we can assist you by reaching our hotline.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item shadow-sm">
                            <h2 class="accordion-header" id="heading-5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                    How to get to the SkyCab cable car station?

                                </button>
                            </h2>
                            <div id="collapse-5" class="accordion-collapse collapse" aria-labelledby="heading-5"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p>You may navigate to the following locations to get to the cable car station. For <a
                                            href="https://goo.gl/maps/Y3jjJVHCUPS3JSsEA">Google Maps</a>. For <a
                                            href="https://ul.waze.com/ul?preview_venue_id=65339456.653197949.2091659&amp;navigate=yes&amp;utm_campaign=default&amp;utm_source=waze_website&amp;utm_medium=lm_share_location">Waze</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="my-7">
                <div class="container">
                    <h2 class="text-primary mt-3">Other Attractions You May Like</h2>
                    <div id="slider-attractions" class="splide splide-primary mb-4 mb-md-5 mt-4" role="region"
                        aria-roledescription="carousel">
                        <div class="splide__track" id="slider-attractions-track" aria-live="polite" aria-atomic="true">
                            <ul class="splide__list" id="slider-attractions-list">

                                @foreach ($allAttractions as $attraction)
                                    <li class="splide__slide">
                                        <div class="card mx-3">
                                            @if ($attraction->discount_price && $attraction->selling_price)
                                                <div class="label-discount">
                                                    {{ round((($attraction->selling_price - $attraction->discount_price) / $attraction->selling_price) * 100, 2) }}%
                                                    OFF
                                                </div>
                                            @endif
                                            <img src="{{ asset($attraction->get_thumbnail->path ?? 'default-image.jpg') }}"
                                                alt="{{ $attraction->title }}" class="card-img-top img-fluid object-fit-lg">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="{{ route('attractions.detail', $attraction->slug) }}"
                                                        class="text-dark">
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
                                                                <span class="text-muted">From</span> RM <span
                                                                    class="fs-3 fw-bold">
                                                                    {{ number_format($attraction->discount_price ?? $attraction->selling_price, 2) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto my-auto">
                                                        <a href="{{ route('attractions.detail', ['slug' => $attraction->slug]) }}"
                                                            class="btn btn-primary">Book Now</a>
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
            </section>


        </div>
    </main>
@endsection
@section('js')
    <script>

$(document).ready(function () {
    $(".btn-plus").click(function (e) {
        e.stopPropagation();

        var type = $(this).data("type");
        var id = $(this).data("id");
        var varictionid = $(this).data("varictionid");
        var inputField = $("#" + type + "-" + id + varictionid);

        var currentValue = parseInt(inputField.val()) || 0;
        inputField.val(currentValue + 1); // Increment by 1
    });

    $(".btn-minuss").click(function (e) {

        e.stopPropagation();

        var type = $(this).data("type");
        var id = $(this).data("id");
        var varictionid = $(this).data("varictionid");
        var inputField = $("#" + type + "-" + id + varictionid);

        var currentValue = parseInt(inputField.val()) || 0;
        if (currentValue > 0) {
            inputField.val(currentValue - 1); // Decrement by 1
        }
    });




    $(".dropdown-menu").click(function (e) {
        e.stopPropagation();
    });



});

            flatpickr("#flatpickr-1", {
                altInput: true,
                altFormat: "j M Y",
                dateFormat: "Y-m-d",
                defaultDate: "today",
                minDate: "today",
                disableMobile: "true"
            });


            $(document).ready(function () {
                $(".check-availability").on("click", function () {
                    let ticketCard = $(this).closest(".card");
                    let ticketId = $(this).data("ticket-id");


                    let closestDropdown = ticketCard.find(".dropdown-menu");


                    let adultInput = closestDropdown.find("input[name='no_of_adult']");
                    let childInput = closestDropdown.find("input[name='no_of_child']");


                    let adultQuantity = parseInt(adultInput.val()) || 0;
                    let childQuantity = parseInt(childInput.val()) || 0;


                    let selectedDate = ticketCard.find(".datapicker-" + ticketId).val();

                    $.ajax({
                        url: "/check-availability",
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: {
                            ticket_id: ticketId,
                            date: selectedDate,
                            adult_quantity: adultQuantity,
                            child_quantity: childQuantity,
                        },
                        success: function (response) {
                            $.toast({
                                heading: response.status === "success" ? 'Success' : 'Error',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: response.status === "success" ? 'success' : 'error',
                                hideAfter: 3500,
                                stack: 6
                            });
                            if(response.status === "success" ){
                                setTimeout(function () {
                                    window.location.href = response.redirect_url;
                                }, 1500);
                            }
                        },
                        error: function (xhr) {
                            $.toast({
                                heading: 'Error',
                                text: 'An unexpected error occurred. Please try again.',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'error',
                                hideAfter: 3500,
                                stack: 6
                            });
                        },
                    });
                });
            });


    </script>
@endsection
