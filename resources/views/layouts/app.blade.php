<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- Mirrored from mannatthemes.com/metrica/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 11 Feb 2023 15:08:28 GMT -->

<head>


    <meta charset="utf-8" />
    <title>Metrica - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">



    <!-- App css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    {{-- DataTable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />

</head>

<body id="body">
    <!-- leftbar-tab-menu -->
    <div class="leftbar-tab-menu">
        @include('layouts.left-menu')
    </div>
    <!-- end leftbar-tab-menu-->
    <!-- Top Bar Start -->
    <div class="topbar">
        <!-- Navbar -->
        @include('layouts.top-bar')
        <!-- end navbar-->
    </div>
    <!-- Top Bar End -->

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content-tab">

            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Metrica</a>
                                    </li><!--end nav-item-->
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                                    </li><!--end nav-item-->
                                    <li class="breadcrumb-item active">Analytics</li>
                                </ol>
                            </div>
                            <h4 class="page-title">@yield('title')</h4>
                        </div><!--end page-title-box-->
                    </div><!--end col-->
                </div>
                <!-- end page title end breadcrumb -->
                <!-- end page title end breadcrumb -->
                @yield('content')

            </div><!-- container -->

            <!--Start Rightbar-->
            <!--Start Rightbar/offcanvas-->
            @include('layouts.right-bar')
            <!--end Rightbar/offcanvas-->
            <!--end Rightbar-->

            <!--Start Footer-->
            <!-- Footer Start -->
            @include('layouts.footer')
            <!-- end Footer -->
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- Javascript  -->
    <!-- vendor js -->

    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>

    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/analytics-index.init.js')}}"></script>
    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>
    {{-- DataTable --}}
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    @stack('scripts')

</body>
<!--end body-->

<!-- Mirrored from mannatthemes.com/metrica/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 11 Feb 2023 15:09:08 GMT -->

</html>
