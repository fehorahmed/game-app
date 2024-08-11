@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            <div class="heading_container heading_center">
                <h2>
                    Profile <span>Page</span>
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
                            Profile Page
                        </h3>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
