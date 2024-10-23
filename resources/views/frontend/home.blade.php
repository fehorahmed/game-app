@extends('frontend.layouts.app')

@section('content')
    <section class="client_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center psudo_white_primary mb_45">
                <h2>
                    Our <span>Games</span>
                </h2>
            </div>
            <div class="carousel-wrap ">
                <div class="owl-carousel client_owl-carousel">
                    @foreach ($games as $game)
                        <div class="item">
                            <a href="{{ route('home.game.detail', $game->name) }}">
                                <div class="box">
                                    <div class="img-box">
                                        @if ($game->image)
                                        @else
                                            <img src="{{ asset('assets') }}/images/game_logo.png" alt=""
                                                class="box-img">
                                        @endif

                                    </div>
                                    <div class="detail-box">
                                        <div class="client_id">
                                            <div class="client_info">
                                                <h6>
                                                    {{ $game->name }}
                                                </h6>

                                            </div>
                                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                                        </div>
                                        <p>
                                            Click here for know about the game details.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- service section -->



    <!-- team section -->
    <section class="team_section layout_padding">
        <div class="container-fluid">
            <div class="heading_container heading_center">
                <h2 class="">
                    Our <span> Best Players</span>
                </h2>
            </div>

            <div class="team_container">
                <div class="row">
                    @foreach ($app_users as $app_user)
                        <div class="col-lg-3 col-sm-6">
                            <div class="box ">
                                <div class="img-box">
                                    @if ($app_user->photo)
                                        <img src="{{ asset('storage/' . $app_user->photo) }}" class="img1" alt="" width="200px" height="130px">
                                    @else
                                        <img src="{{ asset('frontend') }}/images/team-1.jpg" class="img1" alt="">
                                    @endif

                                </div>
                                <div class="detail-box">
                                    <h5>
                                        {{ $app_user->name }}
                                    </h5>
                                    <p>
                                        ID: {{ $app_user->user_id }}
                                    </p>
                                </div>
                                <div class="social_box">
                                    <a href="#">
                                        <i class="fa fa-star" aria-hidden="true"></i> : {{$app_user->balance->star ??0}}
                                    </a>

                                    <a href="#">
                                        <i class="fa fa-users" aria-hidden="true"></i> : {{$app_user->refferalUsers->count()}}
                                    </a>


                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </section>
    <!-- end team section -->



    <!-- why section -->

    <section class="why_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Why Choose <span>Us</span>
                </h2>
            </div>
            <div class="why_container">
                <div class="box">
                    <div class="img-box">
                        <img src="{{ asset('frontend') }}/images/w1.png" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Expert Management
                        </h5>
                        <p>
                            Incidunt odit rerum tenetur alias architecto asperiores omnis cumque doloribus aperiam
                            numquam! Eligendi corrupti, molestias laborum dolores quod nisi vitae voluptate ipsa? In
                            tempore voluptate ducimus officia id, aspernatur nihil.
                            Tempore laborum nesciunt ut veniam, nemo officia ullam repudiandae repellat veritatis unde
                            reiciendis possimus animi autem natus
                        </p>
                    </div>
                </div>
                <div class="box">
                    <div class="img-box">
                        <img src="{{ asset('frontend') }}/images/w2.png" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Secure Investment
                        </h5>
                        <p>
                            Incidunt odit rerum tenetur alias architecto asperiores omnis cumque doloribus aperiam
                            numquam! Eligendi corrupti, molestias laborum dolores quod nisi vitae voluptate ipsa? In
                            tempore voluptate ducimus officia id, aspernatur nihil.
                            Tempore laborum nesciunt ut veniam, nemo officia ullam repudiandae repellat veritatis unde
                            reiciendis possimus animi autem natus
                        </p>
                    </div>
                </div>
                <div class="box">
                    <div class="img-box">
                        <img src="{{ asset('frontend') }}/images/w3.png" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Instant Trading
                        </h5>
                        <p>
                            Incidunt odit rerum tenetur alias architecto asperiores omnis cumque doloribus aperiam
                            numquam! Eligendi corrupti, molestias laborum dolores quod nisi vitae voluptate ipsa? In
                            tempore voluptate ducimus officia id, aspernatur nihil.
                            Tempore laborum nesciunt ut veniam, nemo officia ullam repudiandae repellat veritatis unde
                            reiciendis possimus animi autem natus
                        </p>
                    </div>
                </div>
                <div class="box">
                    <div class="img-box">
                        <img src="{{ asset('frontend') }}/images/w4.png" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Happy Customers
                        </h5>
                        <p>
                            Incidunt odit rerum tenetur alias architecto asperiores omnis cumque doloribus aperiam
                            numquam! Eligendi corrupti, molestias laborum dolores quod nisi vitae voluptate ipsa? In
                            tempore voluptate ducimus officia id, aspernatur nihil.
                            Tempore laborum nesciunt ut veniam, nemo officia ullam repudiandae repellat veritatis unde
                            reiciendis possimus animi autem natus
                        </p>
                    </div>
                </div>
            </div>
            <div class="btn-box">
                <a href="">
                    Read More
                </a>
            </div>
        </div>
    </section>

    <!-- end why section -->


    <!-- end client section -->
@endsection
