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
                                            <img src="assets/images/logo-sm.png" height="50" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Let's Get Started Metrica</h4>
                                        <p class="text-muted  mb-0">Sign up to continue to Metrica.</p>
                                    </div>
                                </div><!--end card-body-->
                                <div class="card-body pt-0">
                                    <form class="my-4" action="https://mannatthemes.com/metrica/default/index.html">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Enter username">
                                        </div><!--end form-group-->

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="useremail">Email</label>
                                            <input type="email" class="form-control" id="useremail" name="user email"
                                                placeholder="Enter email">
                                        </div><!--end form-group-->

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="userpassword">Password</label>
                                            <input type="password" class="form-control" name="password" id="userpassword"
                                                placeholder="Enter password">
                                        </div><!--end form-group-->

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="Confirmpassword">ConfirmPassword</label>
                                            <input type="password" class="form-control" name="password" id="Confirmpassword"
                                                placeholder="Enter Confirm password">
                                        </div><!--end form-group-->

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="mobileNo">Mobile Number</label>
                                            <input type="text" class="form-control" id="mobileNo" name="mobile number"
                                                placeholder="Enter Mobile Number">
                                        </div><!--end form-group-->

                                        <div class="form-group row mt-3">
                                            <div class="col-12">
                                                <div class="form-check form-switch form-switch-success">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="customSwitchSuccess">
                                                    <label class="form-check-label" for="customSwitchSuccess">By registering
                                                        you agree to the Metrica <a href="#"
                                                            class="text-primary">Terms of Use</a></label>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" type="button">Log In <i
                                                            class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div><!--end col-->
                                        </div> <!--end form-group-->
                                    </form><!--end form-->
                                    <div class="m-3 text-center text-muted">
                                        <p class="mb-0">Already have an account ? <a href="auth-login-alt.html"
                                                class="text-primary ms-2">Register</a></p>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                        <div class="col-md-7 col-xl-9 col-lg-8  p-0 vh-100 d-flex justify-content-center auth-bg">
                            <div class="accountbg d-flex align-items-center">
                                <div class="account-title text-center text-white">
                                    <img src="assets/images/logo-sm.png" alt="" class="thumb-sm">
                                    <h4 class="mt-3 text-white">Welcome To <span class="text-warning">Metrica</span> </h4>
                                    <h1 class="text-white">Let's Get Started</h1>
                                    <p class="font-18 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam
                                        laoreet tellus ut tincidunt euismod.</p>
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
