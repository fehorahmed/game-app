@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            @include('frontend.layouts.message')
            <div class="heading_container heading_center">
                <h2>
                    Forgot <span>Password</span>
                </h2>


            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="img-box">
                        @php
                            $login_image = \App\Helpers\Helper::get_config('login_image');
                        @endphp
                        @if ($login_image)
                            <img src="{{ asset($login_image) }}" alt="">
                        @else
                            <img src="{{ asset('frontend') }}/images/about-img.png" alt="">
                        @endif

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <h5>
                            Enter your email for sending your password reset link
                        </h5>
                        <form action="" method="POST">
                            @csrf
                            <label for="email" class="pt-3">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                            @error('email')
                                <div class="m-2 text-warning">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="d-flex justify-content-between">
                                <button role="submit" class="btn btn-primary mt-3">Send Password Reset Link</button>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
