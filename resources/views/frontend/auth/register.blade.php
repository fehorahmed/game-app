@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            <div class="heading_container heading_center">
                <h2>
                    Registration <span>Page</span>
                </h2>

            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="img-box">
                        @php
                            $registration_image = \App\Helpers\Helper::get_config('registration_image');
                        @endphp
                        @if ($registration_image)
                            <img src="{{ asset($registration_image) }}" alt="">
                        @else
                            <img src="{{ asset('frontend') }}/images/about-img.png" alt="">
                        @endif


                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <h3>
                            Login to your account
                        </h3>
                        <form action="" method="POST">
                            @csrf
                            <label for="name" class="pt-3">Name</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                class="form-control">
                            @error('name')
                                <div class="m-2 text-warning">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label for="email" class="pt-3">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="form-control">
                            @error('email')
                                <div class="m-2 text-warning">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label for="user_id" class="pt-3">User ID</label>
                            <input type="number" name="user_id" id="user_id" required value="{{ old('user_id') }}"
                                class="form-control">
                            @error('user_id')
                                <div class="m-2 text-warning">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label for="password" class="pt-3">Password</label>
                            <input type="password" name="password" id="password" required class="form-control">
                            @error('password')
                                <div class="m-2 text-warning">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label for="password_confirmation" class="pt-3">Confirm Password </label>
                            <input type="password" name="password_confirmation" required id="password_confirmation"
                                class="form-control">

                            <label for="referral_id" class="pt-3">Referral ID </label>
                            <input type="number" name="referral_id" id="referral_id" value="{{ old('referral_id') }}"
                                class="form-control">
                            @error('referral_id')
                                <div class="m-2 text-warning">
                                    {{ $message }}
                                </div>
                            @enderror

                            <button role="submit" class="btn btn-primary mt-3">SIGN UP</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
