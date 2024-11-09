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

    <section class="about_section layout_padding">
        <div class="container  ">
            <div class="heading_container justify-content-between" style="flex-direction: row;">
                <h2>
                    Support <span>Page</span>
                </h2>


            </div>
            <div class="row">
                @php
                    $facebook = \App\Helpers\Helper::get_config('facebook_support');
                @endphp
                @if ($facebook)
                    <div class="col-md-4 ">
                        <div class="box ">
                            <div class="detail-box ">
                                <h5 class="font-weight-bold">
                                    FACEBOOK
                                </h5>
                                <a href="{{ $facebook }}" target="_blank">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                @endif
                @php
                    $whatsapp = \App\Helpers\Helper::get_config('whatsapp_support');
                @endphp
                @if ($whatsapp)
                    <div class="col-md-4 ">
                        <div class="box">

                            <div class="detail-box">
                                <h5 class="font-weight-bold">
                                    WHATSAPP
                                </h5>

                                <a href="{{ $whatsapp }}" target="_blank">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                @php
                    $telegram = \App\Helpers\Helper::get_config('telegram_support');
                @endphp
                @if ($telegram)
                    <div class="col-md-4 ">
                        <div class="box">

                            <div class="detail-box">
                                <h5 class="font-weight-bold">
                                    TELEGRAM
                                </h5>

                                <a href="{{ $telegram }}" target="_blank">
                                    <i class="fa fa-telegram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <hr class="bg-light">

        </div>
    </section>

    <!-- end about section -->
@endsection

@push('script')
    <script></script>
@endpush
