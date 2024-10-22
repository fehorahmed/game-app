@extends('layouts.guest')
@section('content')
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12">
                <div class="card-body p-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-5 col-xl-3 col-lg-4">
                            <div class="card mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="text-center p-3">
                                        <a href="index.html" class="logo logo-admin">
                                            <img src="{{ asset('assets/images/logo-sm.png') }}" height="50"
                                                alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold font-18">Let's Get Started {{ env('APP_NAME') }}
                                        </h4>
                                        <p class="text-muted  mb-0">Password reset successful.
                                        </p>
                                    </div>
                                </div><!--end card-body-->

                            </div><!--end card-->
                        </div><!--end col-->
                        <div class="col-md-7 col-xl-9 col-lg-8  p-0 vh-100 d-flex justify-content-center auth-bg">
                            <div class="accountbg d-flex align-items-center">
                                <div class="account-title text-center text-white">
                                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" class="thumb-sm">
                                    <h4 class="mt-3 text-white">Welcome To <span class="text-warning">Metrica</span>
                                    </h4>
                                    <h1 class="text-white">{{ $status }}</h1>
                                    <p class="font-18 mt-3">Now you can login with your new password. Thank you.</p>
                                    <div class="border w-25 mx-auto border-warning"></div>
                                </div>
                            </div><!--end /div-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
@endsection
