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
    </style>
@endpush
@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            <div class="heading_container heading_center">
                <h2>
                    Dashboard <span>Page</span>
                </h2>

            </div>
            <div class="row">

                <div class="col-md-4 ">
                    <div class="box ">

                        <div class="detail-box ">
                            <h5 class="font-weight-bold">
                                Total Balance
                            </h5>
                            <p>
                                {{ auth()->user()->balance->balance ?? 0 }} tk
                            </p>
                            {{-- <a href="">
                                Read More
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="box">

                        <div class="detail-box">
                            <h5 class="font-weight-bold">
                                Total Coin
                            </h5>
                            <p>
                                {{ auth()->user()->coin->coin ?? 0 }}
                            </p>
                            {{-- <a href="">
                                Read More
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="box ">

                        <div class="detail-box">
                            <h5 class="font-weight-bold">
                                Total Diposit
                            </h5>
                            <p>
                                {{auth()->user()->deposit->sum('amount')}} tk
                            </p>
                            {{-- <a href="">
                                Read More
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="box ">

                        <div class="detail-box">
                            <h5 class="font-weight-bold">
                                Total Withdraw
                            </h5>
                            <p>
                                120 tk
                            </p>
                            {{-- <a href="">
                                Read More
                            </a> --}}
                        </div>
                    </div>
                </div>

            </div>
            <hr class="bg-light">
            <div class="row">
                <div class="col-md-4 ">
                    <a href="{{route('user.deposit')}}" >
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/add_money.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Add Money</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 ">
                    <a href="{{route('user.withdraw')}}">
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/withdraw.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Withdraw</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 ">
                    <a href="" target="_blank">
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/transfer.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Transfer</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 ">
                    <a href="" target="_blank">
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/income.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Income</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('user.member_list')}}" target="_blank">
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/member.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Members</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="" target="_blank">
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/game.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Games</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 ">
                    <a href="" target="_blank">
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/gold_coin.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Gold Coin</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 ">
                    <a href="{{route('user.website_list')}}" target="_blank">
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/google_ads.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Google Ads</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 ">
                    <a href="" target="_blank">
                        <div class="menu-box">
                            <div class="detail-box ">
                                <div>
                                    <img src="{{ asset('assets/images/menu_icon/support.png') }}" alt="">
                                </div>
                                <br>
                                <h5 class="font-weight-bold text-white">Support</h5>
                            </div>
                        </div>
                    </a>
                </div>



            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
