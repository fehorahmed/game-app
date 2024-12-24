@extends('frontend.layouts.app')

@push('style')
    <style>
        .about_section .box {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            text-align: center;
            margin-top: 15px;
            background-color: #2a2a35;
            padding: 20px;
            /* color: black; */
            border-radius: 5px;
        }

        .menu-box {
            text-align: center;
            margin-top: 15px;
            background-color: #686881;
            padding: 20px;
            /* color: black; */
            border-radius: 5px;
        }

        .alert_border_class {}
    </style>
@endpush
@section('content')
    <!-- about section -->

    <section style="background: #00204a;color:#ffffff;" class="about_section layout_padding">
        <div class="container  ">
            @if (session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            @if (session('error'))
                <p class="alert alert-danger">{{ session('error') }}</p>
            @endif
            <div style="flex-direction: row; " class="row heading_container  d-flex justify-content-between">
                <h2>
                    Routing <span>Visit</span>
                </h2>
                {{-- <div>
                        <p>Your total referral : {{$total_ref}}</p>
                    </div> --}}

            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 ">
                    <div class="box ">
                        <div class="detail-box ">
                            <h5 class="font-weight-bold">
                                Web Routing
                            </h5>
                            <a href="{{ route('user.website_list') }}">
                                VIEW
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="box ">
                        <div class="detail-box ">
                            <h5 class="font-weight-bold">
                                Web Visiting
                            </h5>
                            <a href="{{ route('user.web_visiting_list') }}">
                                VIEW
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
