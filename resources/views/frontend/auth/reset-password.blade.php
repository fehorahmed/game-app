@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            @include('frontend.layouts.message')
            <div class="heading_container heading_center">
                <h2>
                    Reset <span>Password</span>
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
                        <h3>
                            Reset your account password
                        </h3>
                        <form action="{{ route('app_user.password-reset-store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <label for="email" class="pt-3">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $email) }}" placeholder="Enter email" readonly>
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
                            <label for="password_confirmation" class="pt-3">Confirm Password </label>
                            <input type="password" name="password_confirmation" required id="password_confirmation"
                                class="form-control">
                                <div class="d-flex justify-content-between">
                                    <button role="submit" class="btn btn-primary mt-3">Reset Password</button>

                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
