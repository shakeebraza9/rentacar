<?php
use App\Models\Category;
use App\Helpers\MenuHelper;
$enabledCategories = Category::where('is_enable', 1)->get();
$companyMenuItems = MenuHelper::getMenuItems(1);
$legalMenuItems = MenuHelper::getMenuItems(2);
$attractions= MenuHelper::getsubAttractions(45);




?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Langkawi Car Rental at Airport & Jetty - MRR HOLIDAYS</title>
    <link rel="stylesheet" href="{{ asset('theme/asset/node_modules/mburger-css/dist/mburger.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/asset/node_modules/%40splidejs/splide/dist/css/splide.min.css') }}">
    <link href="{{ asset(getset('fav_icon')) }}" type="image/x-icon" rel="icon">
    <link rel="stylesheet" href="{{ asset('theme/asset/css/mmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/asset/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/asset/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/asset/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/asset/css/frontend.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">

    <script src="{{ asset('theme/asset/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('theme/asset/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/asset/js/rangePlugin.js') }}"></script>
    <script src="{{ asset('theme/asset/js/flatpickr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@yield('css')
</head>


<body>

    <nav class="navbar navbar-main navbar-expand-md navbar-light fixed-top">
        <div class="container-fluid d-flex justify-content-between px-0 px-md-2">
            <a href="{{ route('home') }}"><img src="{{ asset(getset('logo')) }}" class="logo" alt=""></a>
            <div class="ms-auto">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                    aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse col justify-content-end" id="navbarMain">
                <ul class="navbar-nav mb-2 mb-lg-0 pt-4 pt-md-0 align-items-center">
                    <li class="nav-item border-bottom pb-3 mb-2 d-md-none">
                        <h6 class="text-primary">CONTACT</h6>
                        <div>
                            <a href="tel:+60128084008">+60 12-8084008</a>
                        </div>
                        <div>
                            enquiry@MRR HOLIDAYS.my
                        </div>
                    </li>
                    @foreach($enabledCategories as $category)
                    <li class="nav-item text-nowrap">
                        <a href="{{ url($category->slug) }}" class="nav-link border-right px-md-4 py-md-0 my-md-2">
                            {{ $category->title }}
                        </a>
                    </li>
                @endforeach
                    {{-- <li class="nav-item text-nowrap">
                        <a href="index.html" class="nav-link border-right px-md-4 py-md-0 my-md-2">Car Rental</a>
                    </li>
                    <li class="nav-item">
                        <a href="attractions.html" class="nav-link border-right px-md-4 py-md-0 my-md-2">Attractions</a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{ route('blog.index') }}" class="nav-link border-right px-md-4 py-md-0 my-md-2">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://MRR HOLIDAYS.tawk.help/" target="_blank"
                            class="nav-link border-right px-md-4 py-md-0 my-md-2">Help</a>
                    </li>
                    <li class="nav-item dropdown mx-3">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false"><span class="flag-icon flag-icon-gb"></span></a>
                        <ul class="dropdown-menu dropdown-menu-end text-center text-md-left">
                            <li class="dropdown-header text-start">Select Language</li>
                            <li>
                                <a href="index.html" data-value="en"
                                    class="lang nav-link text-dark d-flex align-items-center">
                                    <span class="flag-icon flag-icon-gb" style="margin-right: 8px;"></span>
                                    <span class="small text-nowrap">English</span>
                                </a>
                            </li>

                            <li>
                                <a href="ms.html" data-value="ms"
                                    class="lang nav-link text-dark d-flex align-items-center">
                                    <span class="flag-icon flag-icon-my" style="margin-right: 8px;"></span>
                                    <span class="small text-nowrap">Bahasa Malaysia</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown d-none d-md-block">
                        <a href="../customer/user/carts.html" class="text-dark border-right px-md-4 py-md-0 my-md-2"><i
                                class="fas fa-shopping-cart fa-lg"></i></a> <span class="badge rounded-pill bg-danger"
                            style="position: absolute; top: -10px; right: 5px;">
                            0 </span>
                    </li>
                    @if(Auth::check())  <!-- Check if the user is authenticated -->
                    <li class="nav-item dropdown mx-3">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end text-center text-md-left">
                            <li><a href="{{ route('customer.profile') }}" class="dropdown-item">My Profile</a></li>
                            <li><a href="{{ route('customer.carts') }}" class="dropdown-item">My Cart</a></li>
                            <li><a href="{{ route('customer.history') }}" class="dropdown-item">Booking List</a></li>
                            <li><a href="{{ route('customer.referral') }}" class="dropdown-item">Refer & Earn</a></li>
                            <li><a href="{{ route('customer.cases') }}" class="dropdown-item">Cases</a></li>

                            <li><a href="{{ route('weblogout') }}" class="dropdown-item">Logout</a></li> <!-- Logout route -->
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('weblogin') }}" class="nav-link px-md-4 py-md-0 mt-3 my-md-2">Login</a>
                    </li>
                    <li class="nav-item" style="border:0">
                        <a href="{{ route('register') }}" class="btn btn-outline-white mt-3 mt-md-0 ms-md-2 bg-primary text-white">Create Account</a>
                    </li>
                @endif
                </ul>
            </div>
        </div>
    </nav>








   @yield('content')


<footer class="footer-main pt-5 mb-5 mb-md-0 text-center text-md-start">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-auto mt-md-0">
                    <h6 class="mb-3 text-uppercase">Company</h6>
                    <ul class="list-unstyled">
                        @foreach ($companyMenuItems as $item)

                        <li>
                            @if ($item->target == 1)

                                <a href="{{ route('pages.show', ['slug' => $item->link]) }}">{{ $item->title }}</a>
                            @elseif ($item->target == 2)

                                <a href="{{ route($item->link) }}">{{ $item->title }}</a>
                            @else

                                <a href="{{ $item->link }}">{{ $item->title }}</a>
                            @endif
                        </li>

                    @endforeach


                </ul>
            </div>
            <div class="col-md-auto mt-5 mt-md-0">
                <h6 class="mb-3 text-uppercase">Services</h6>
                <ul class="list-unstyled">
                    @foreach($enabledCategories as $category)
                    <li>
                        <a href="{{ url($category->slug) }}">
                            {{ $category->title }}
                        </a>
                    </li>
                @endforeach

                    </ul>
                    <h6 class="mb-3 text-uppercase mt-5">Legal</h6>
                    <ul class="list-unstyled">

                        @foreach ($legalMenuItems as $item)
                        <li>
                            {{--  <a href="{{ $item->link }}">{{ $item->title }}</a>  --}}
                            @if ($item->target == 1)

                                <a href="{{ route('pages.show', ['slug' => $item->link]) }}">{{ $item->title }}</a>
                            @elseif ($item->target == 2)

                                <a href="{{ route($item->link) }}">{{ $item->title }}</a>
                            @else

                                <a href="{{ $item->link }}">{{ $item->title }}</a>
                            @endif
                        </li>
                    @endforeach
                        {{--  <li><a href="https://MRR HOLIDAYS.tawk.help/" target="_blank">Help Center</a></li>  --}}
                    </ul>
                </div>
                <div class="col-md-auto mt-5 mt-md-0">
                    <h6 class="mb-3 text-uppercase">Top Attractions</h6>
                    <ul class="list-unstyled">
                        @foreach($attractions as $attraction)
                            <li>
                                <a href="{{ url('attractions/' . $attraction->slug . '.html') }}">
                                    {{ $attraction->title }}
                                    @if($attraction->created_at >= now()->subDays(10))
                                        <span class="fw-bold new-word" style="color: ">NEW</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-md-auto mt-5 mt-md-0">
                    <h6 class="text-uppercase mb-3">Address</h6>
                    <div>
                        {!! nl2br(getset('address')) !!}
                        LB Travel Tech Sdn Bhd<br>
                       123456789<br>
                    </div>
                </div>

            </div>
        </div>
        <div class="bg-white text-dark p-4 mt-5">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-12 ">
                        <div class="ft-cpt-img d-flex align-items-center justify-content-center">
                            <img src="{{ asset(getset('logo')) }}" class="img-fluid logo text-center" alt="">
                        </div>

                        <div class="mt-2 text-muted text-center">
                            &copy; Copyright 2025  MRR HOLIDAYS. All rights reserved. </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <!-- Modal -->
    <div class="modal fade modal-coming-soon" id="coming-soon" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close bg-white rounded-circle text-dark" data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="body text-center p-4 p-md-5 mx-md-8 mb-4 mb-md-5 rounded">
                    <p>WE’RE COMING SOON!</p>
                    <hr class="bg-white">
                    <div class="h5">
                        We’re coming soon! We’re working hard to give you the best experience.
                        <br>
                        For any enquiries, please contact us at +0133188088.
                    </div>
                </div>
                <img src="../img/logo-langkawibook.svg" class="logo" style="height: 50px" alt="">
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function () {
            var num_promo = '1';
            $(window).on('load', function () {
                if (num_promo > 0)
                    $('#PromoModal').modal('show');
            });

            $('.promo-toggle').on('change', function (e) {
                if (this.checked) {
                    console.log('ada check');
                    setCookie('show_promo', 'false', 7);
                }
            });

            // Set a Cookie
            function setCookie(cName, cValue, expDays) {
                let date = new Date();
                date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
                const expires = "expires=" + date.toUTCString();
                document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
            }
        });
    </script>

    @yield(section: 'js')

</body>


</html>
