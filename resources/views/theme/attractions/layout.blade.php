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
        @yield('metatags')
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>



    <script type="text/javascript">
        function changeLanguage(lang) {
          const selectField = document.querySelector('.goog-te-combo');
          selectField.value = lang;
          selectField.dispatchEvent(new Event('change'));
        }

        function googleTranslateElementInit() {
          new google.translate.TranslateElement({
            pageLanguage: 'en',
            autoDisplay: false,
            includedLanguages: 'en,ms' // Add more as needed
          }, 'google_translate_element');
        }
      </script>
      <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

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
                            <a href="tel:+60128084008">{!! nl2br(getset('phone_number')) !!}/a>
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
                        <a href="{{ route('help.index') }}" target="_blank"
                            class="nav-link border-right px-md-4 py-md-0 my-md-2">Help</a>
                    </li>
                    <li class="nav-item dropdown mx-3">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <span class="flag-icon flag-icon-gb"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">Select Language</li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#" onclick="changeLanguage('en');">
                                    <span class="flag-icon flag-icon-gb me-2"></span> English
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#" onclick="changeLanguage('ms');">
                                    <span class="flag-icon flag-icon-my me-2"></span> Bahasa Malaysia
                                </a>
                            </li>
                        </ul>
                        <div id="google_translate_element" style="display:none;"></div>
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
                            {{--  <li><a href="{{ route('customer.carts') }}" class="dropdown-item">My Cart</a></li>  --}}
                            <li><a href="{{ route('customer.history') }}" class="dropdown-item">Booking List</a></li>
                            {{--  <li><a href="{{ route('customer.referral') }}" class="dropdown-item">Refer & Earn</a></li>  --}}
                            {{--  <li><a href="{{ route('customer.cases') }}" class="dropdown-item">Cases</a></li>  --}}

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
                    @php
                    $attractionsByFunction=getLatestAttractions();
                    @endphp
                    @foreach($attractionsByFunction as $attraction)
                        <li>
                            <a href="{{ url('attractions/detail/' . $attraction->slug ) }}">
                                {{ $attraction->title }}
                                @if($attraction->created_at >= now()->subDays(20))
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
                    {!! nl2br(addBrEveryThreeWords(getset('address'))) !!}
                    {!! nl2br(addBrEveryThreeWords(getset('address2'))) !!}

                 <br>
                    {!! nl2br(getset('email_address')) !!}<br>

                </div>
            </div>

            <div class="col-md-auto mt-5 mt-md-0">
                <h6 class="mb-3 text-uppercase">Social Media</h6>
                <ul class="list-footer-socmed">
                    <li>
                        <a href="{!! nl2br(getset('facebook_link')) !!}" target="_blank"><i class="fab fa-facebook"></i></a>                    </li>

                    <li>
                        <a href="{!! nl2br(getset('instagram_link')) !!}" target="_blank"><i class="fab fa-instagram"></i></a>                    </li>
                    <li>
                        <a href="{!! nl2br(getset('whatsaap_link')) !!}" target="_blank"><i class="fab fa-whatsapp"></i></a>                    </li>
                </ul>
                <h6 class="mt-5 text-uppercase">Hotline</h6>
                <span><i class="fa fa-phone"></i><a href="tel:{!! nl2br(getset('phone_number')) !!}"> {!! nl2br(getset('phone_number')) !!}</a></span>
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
                        {!! nl2br(getset('footer_credits')) !!}<br> </div>
                </div>

            </div>
        </div>
    </div>


</footer>


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

    </script>
    @if(Session::get('success'))
    <script>
    $.toast({
            heading: "{{Session::get('success')}}",
            // text: "{{Session::get('success')}}",
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'info',
            hideAfter: 3500,
            stack: 6,
        });
    </script>
    @endif

    @if(Session::get('error'))
    <script>
      $.toast({
            heading: "{{Session::get('error')}}",
            // text: "{{Session::get('success')}}",
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3500,
            stack: 6,
        });
    </script>
    @endif

    @if(Session::get('warning'))
    <script>
      $.toast({
            heading: "{{Session::get('warning')}}",
            // text: "{{Session::get('success')}}",
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'warning',
            hideAfter: 3500,
            stack: 6,
        });
    </script>
    @endif
    @yield(section: 'js')

</body>


</html>
