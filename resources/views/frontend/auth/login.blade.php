@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            <div class="heading_container heading_center">
                <h2>
                    Log <span>In</span>
                </h2>

            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="img-box">
                        <img src="{{ asset('frontend') }}/images/about-img.png" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <h3>
                            Login to your account
                        </h3>
                        <form action="" method="POST">
                            @csrf
                            <label for="email" class="pt-3">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            @error('email')
                                <div class="m-2 text-warning">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label for="password" class="pt-3">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                                <div class="m-2 text-warning">
                                    {{ $message }}
                                </div>
                            @enderror
                            <button role="submit" class="btn btn-primary mt-3">SIGN IN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
