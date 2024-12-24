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
                    Dashboard <span>Page</span>
                </h2>
                <button class="btn btn-info" id="buy_star"
                    data-star="{{ \App\Helpers\Helper::get_star_price((auth()->user()->balance->star ?? 0) + 1) }}">Buy
                    Star</button>

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
                            <a href="{{ route('user.balance.history') }}">
                                HISTORY
                            </a>
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
                            <a href="{{ route('user.coin.history') }}">
                                HISTORY
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="box">

                        <div class="detail-box">
                            <h5 class="font-weight-bold">
                                Total Star
                            </h5>
                            <p>
                                {{ auth()->user()->balance->star ?? 0 }}
                            </p>
                            <a href="{{ route('user.star.history') }}">
                                HISTORY
                            </a>
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
                                {{ auth()->user()->deposit->sum('amount') }} tk
                            </p>
                            <a href="{{ route('user.deposit.history') }}">
                                HISTORY
                            </a>
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
                                {{ auth()->user()->withdraw->sum('amount') }} tk
                            </p>
                            <a href="{{ route('user.withdraw.history') }}">
                                HISTORY
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <hr class="bg-light">
            <div class="row">
                <div class="col-md-4 ">
                    <a href="{{ route('user.deposit') }}">
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
                    <a href="{{ route('user.withdraw') }}">
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
                    <a href="{{ route('user.transfer_type') }}">
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
                    <a href="{{ route('user.income') }}">
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
                    <a href="{{ route('user.member_list') }}">
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
                    <a href="">
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
                    <a href="">
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
                    <a href="{{ route('user.routing_list') }}">
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
                    <a href="{{route('user.support')}}">
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

@push('script')
    <script>
        $(function() {

            $(document).on('click', '#buy_star', function() {
                var id = $(this).data('id');
                var star = $(this).data('star');
                var total_star = '{{ auth()->user()->balance->star ?? 0 }}';
                var next_star = '{{ (auth()->user()->balance->star ?? 0) + 1 }}';
                var balance = '{{ auth()->user()->balance->balance ?? 0 }}';
                Swal.fire({
                    title: 'Star Update',
                    // text: "",
                    html: `<p class="d-flex justify-content-between"><span class="alert_border_class">Present Star</span> <span class="">` +
                        total_star +
                        ` <i class="fa fa-star" aria-hidden="true"></i></span></p><p class="d-flex justify-content-between"><span class="alert_border_class">Next Star</span><span class=""> ` +
                        next_star +
                        ` <i class="fa fa-star" aria-hidden="true"></i></span></p><p class="d-flex justify-content-between"> <span class="alert_border_class">Balance</span><span class=""> ` +
                        balance + ` </span></p><p>It will cost  ` + star + ` taka.  </p>`,
                    // text: "It will cost "+star+" taka. You won't be able to revert this!",
                    // icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('user.star.buy') }}', // Your Laravel route
                            type: 'GET',
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Reload the page after the SweetAlert confirmation
                                        location
                                            .reload(); // This will reload the page
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message,
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                // Show error message if something goes wrong
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong.',
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            });
        })
    </script>
@endpush
