@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            @include('frontend.layouts.message')
            <div class="heading_container heading_center">
                <h2>
                    Log <span>In</span>
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
                            Password successfully reset. <br>
                            Please login to your account.
                        </h3>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
