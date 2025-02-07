<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('admin/assets/images/favicon.png')}}">
    <title>{{$global_d['site_title']}}</title>

    <!-- ============================================================== -->
    <!-- Plugins -->
    <!-- ============================================================== -->
    <link href="{{asset('admin/assets/node_modules/morrisjs/morris.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/node_modules/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/node_modules/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <style>
        .menu-button:hover{
            color: #03a9f3;
        }
    </style>
    @yield('css')

</head>
<body class="skin-blue fixed-layout">

    <?php
    //   dd($global_d['site_title']);
    ?>

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">{{$global_d['site_title']}}</p>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">

                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{URL::to('/admin/dashboard')}}">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{asset('admin/assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->

                            <img src="{{asset('admin/assets/images/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="{{asset('admin/assets/images/logo-text.png')}}" alt="homepage" class="dark-logo" />
                         <!-- Light Logo text -->
                         <img src="{{asset('admin/assets/images/logo-light-text.png')}}" class="light-logo" alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->

                <div class="navbar-collapse">

                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav me-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item">
                            <form class="app-search d-none d-md-block d-lg-block">
                                <input type="text" class="form-control" placeholder="Search & enter">
                            </form>
                        </li>
                    </ul>

                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">








                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <img src="{{asset('admin/assets/images/users/1.jpg')}}" alt="user" class="">
                              <span class="hidden-md-down">Mark &nbsp;<i class="fa fa-angle-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end animated flipInY">
                                <a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                                <a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> Change Password</a>

                                <a href="javascript:void(0)" class="right-side-toggle dropdown-item"><i class="ti-settings"></i> Settings</a>

                                <a href="{{URL::to('/admin/logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->



        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">

                        <li><a class=" waves-effect waves-dark" href="{{URL::to('admin/dashboard')}}"
                            aria-expanded="false"><i class="icon-speedometer"></i>
                            <span class="hide-menu">Dashboard</span></a>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-user"></i>
                            <span class="hide-menu"> Users </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/users/create')}}">Add New User</a></li>
                                <li><a href="{{URL::to('admin/users/index')}}">All Users</a></li>
                            </ul>
                        </li>

                        {{-- <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-multiple-outline"></i>
                            <span class="hide-menu"> Roles </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/roles/create')}}">Add New Role</a></li>
                                <li><a href="{{URL::to('admin/roles/index')}}">All Roles</a></li>
                            </ul>
                        </li> --}}

                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-menu"></i>
                            <span class="hide-menu"> Menus </span></a>

                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/menus/create')}}">Add New Menus</a></li>
                                <li><a href="{{URL::to('admin/menus/index')}}">All Menus</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-google-pages"></i>
                            <span class="hide-menu"> Pages </span></a>

                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/page/create')}}">Add New pages</a></li>
                                <li><a href="{{URL::to('admin/page/index')}}">All pages</a></li>
                            </ul>
                        </li>

                        <li><a class="has-arrow waves-effect waves-dark"
                            href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-folder-multiple-image"></i>
                            <span class="hide-menu"> Slider </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/sliders/create')}}">Add New Slider</a></li>
                                <li><a href="{{URL::to('admin/sliders/index')}}">All Slider</a></li>
                            </ul>
                        </li>

                        {{-- <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-gallery"></i>
                            <span class="hide-menu"> Collections </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/collections/create')}}">Add New Collection</a></li>
                                <li><a href="{{URL::to('admin/collections/index')}}">All Collection</a></li>
                            </ul>
                        </li> --}}

                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-apps"></i>
                            <span class="hide-menu"> Category </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/categories/create')}}">Add New Category</a></li>
                                <li><a href="{{URL::to('admin/categories/index')}}">All Category</a></li>
                                <li><a href="{{URL::to('admin/categories/sort')}}">Sort Category</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-border-all"></i>
                            <span class="hide-menu"> Products </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/products/create')}}">Add New Product</a></li>
                                <li><a href="{{URL::to('admin/products/index')}}">All Products</a></li>
                            </ul>
                        </li>

                        <li><a class="waves-effect waves-dark"
                            href="{{URL::to('admin/orders/index')}}"
                            aria-expanded="false"><i class="ti-money"></i>
                            <span class="hide-menu"> Orders </span></a>
                        </li>
                        <li><a class="waves-effect waves-dark"
                            href="{{URL::to('admin/review/index')}}"
                            aria-expanded="false"><i class="ti-star"></i>
                            <span class="hide-menu"> Review </span></a>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-monitor"></i>
                            <span class="hide-menu"> Report </span></a>

                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/reports/clients/index')}}">Customer</a></li>
                                <li><a href="{{URL::to('admin/products/index')}}">Admin Report</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-folder-multiple-outline"></i>
                            <span class="hide-menu"> Filemanager </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{URL::to('admin/filemanager/create')}}">Add New File</a></li>
                                <li><a href="{{URL::to('admin/filemanager')}}">All Files</a></li>
                            </ul>
                        </li>

                        <li><a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i>
                            <span class="hide-menu">Settings</span></a>
                            <ul aria-expanded="false" class="collapse">
                               @foreach (explode(',',$global_d['grouping']) as $item)
                                <li><a href="{{URL::to('admin/settings/edit')}}?group={{$item}}">
                                  {{ ucwords(str_ireplace("_", " ",$item))}}</a></li>
                               @endforeach
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

              @yield('content')


                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Theme Settings <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme ">7</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>

                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->


            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            © 2024 {{$global_d['site_title']}} Developed by
            <a href="https://www.azamsolutions.com/">azamsolutions.com</a>
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->

    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->



    <!-- ============================================================== -->
    <!-- This Gloab JS -->
    <!-- ============================================================== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('admin/assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/assets/node_modules/raphael/raphael-min.js')}}"></script>
    <script src="{{asset('admin/assets/node_modules/morrisjs/morris.min.js')}}"></script>
    <script src="{{asset('admin/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('admin/assets/node_modules/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{asset('admin/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/waves.js')}}"></script>
    <script src="{{asset('admin/assets/js/custom.js')}}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>



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


    <!-- ============================================================== -->
    <!-- Pages JS -->
    <!-- ============================================================== -->
    @yield('js')

 </body>
</html>
