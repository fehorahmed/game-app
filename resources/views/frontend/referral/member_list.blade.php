@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section style="background: #00204a;color:#ffffff;" class="team_section layout_padding">
        <div class="container  ">
            @if (session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            @if (session('error'))
                <p class="alert alert-danger">{{ session('error') }}</p>
            @endif
            <div style="flex-direction: row; " class="row heading_container  d-flex justify-content-between">
                <h2>
                    Member <span>List</span>
                </h2>
                @if (!auth()->user()->referral_id)
                <p>You are not under any user. you can add yourself   <br> <a href="{{route('user.add_yourself')}}" class="btn btn-primary">Add Yourself</a></p>
                @endif

            </div>
            <hr>

            <div class="team_container">
                <div class="row">
                    @foreach ($users as $app_user)
                        <div class="col-lg-3 col-sm-6">
                            <a href="{{route('user.referral_member_detail',$app_user->id)}}">
                                <div class="box">
                                    <div class="img-box">
                                        @if ($app_user->photo)
                                            <img src="{{ asset('storage/' . $app_user->photo) }}" class="img1"
                                                alt="" width="200px" height="130px">
                                        @else
                                            <img src="{{ asset('frontend') }}/images/team-1.jpg" class="img1"
                                                alt="">
                                        @endif

                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            {{ $app_user->name }}
                                        </h5>
                                        <p class="text-light">
                                            ID: {{ $app_user->user_id }} <br>
                                            @if ($app_user->phone)
                                            Phone: {{ $app_user->phone }}
                                            @endif
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
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    <!-- end about section -->
@endsection
