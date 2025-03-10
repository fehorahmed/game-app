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
            <div class="heading_container justify-content-between" style="flex-direction: row;">
                <h2>
                    Transfer <span>Type</span>
                </h2>


            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <a href="{{ route('user.balance_transfer') }}">
                        <div class="box ">
                            <div class="detail-box" style="color: white;">
                                <h5 class="font-weight-bold">
                                    Balance Transfer
                                </h5>
                                <p>

                                </p>
                            </div>
                            <div class="container">
                                <div class="d-flex justify-content-between text-light">

                                    <span>Your Limit : {{ \App\Helpers\Helper::get_star_withdraw_limit(auth()->user()->balance->star ?? 0) }}</span>
                                    <span>Used : {{auth()->user()->withdraw->sum('amount') + auth()->user()->balanceTransferGiven->sum('balance')}}</span>
                                    <span>Remain : {{ \App\Helpers\Helper::get_star_withdraw_limit(auth()->user()->balance->star ?? 0) -(auth()->user()->withdraw->sum('amount') + auth()->user()->balanceTransferGiven->sum('balance')) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('user.coin_transfer') }}">
                        <div class="box">
                            <div class="detail-box" style="color: white;">
                                <h5 class="font-weight-bold">
                                    Coin Transfer
                                </h5>
                                <p>

                                </p>
                            </div>
                            <div class="container">
                                <div class="d-flex justify-content-between text-light">
                                    <span>Your Limit : {{ \App\Helpers\Helper::get_star_coin_transfer_limit(auth()->user()->balance->star ?? 0) }}
                                        </span>
                                    <span>Used : {{ auth()->user()->coinTransferGiven->sum('coin')}}</span>
                                    <span>Remain : {{ \App\Helpers\Helper::get_star_coin_transfer_limit(auth()->user()->balance->star ?? 0) - auth()->user()->coinTransferGiven->sum('coin') }} </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('user.coin_convert') }}">
                        <div class="box">
                            <div class="detail-box" style="color: white;">
                                <h5 class="font-weight-bold">
                                    Coin to Balance Convert
                                </h5>
                                <p>
                                    You can convert your coin to your blance
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('user.taka_to_coin_convert') }}">
                        <div class="box">
                            <div class="detail-box" style="color: white;">
                                <h5 class="font-weight-bold">
                                    Balance to Coin Convert
                                </h5>
                                <p>
                                    You can convert your balance to coin
                                </p>
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
            $('#method').change(function() {
                var method = $(this).val()
                var charge = $(this).find('option:selected').data('charge');
                var limit_start = parseFloat($(this).find('option:selected').data('limit-start'));
                var limit_end = parseFloat($(this).find('option:selected').data('limit-end'));
                $('#transaction_fee').val(charge)
                $('#limit-start').html(limit_start + ' BDT')
                $('#limit-end').html(limit_end + ' BDT')

                $('#amount').attr('min', limit_start);
                $('#amount').attr('max', limit_end);

                $('#amount').trigger('keyup')
            })
            $('#amount').keyup(function() {
                var amount = parseFloat($(this).val()); // Ensure the value is treated as a number
                if (amount > 0) {
                    $('#details-area').show();
                } else {
                    $('#details-area').hide();
                }
                var charge = parseFloat($('#transaction_fee').val());

                charge = (amount / 1000 * charge)

                $('#total-charge').html(charge.toFixed(2) + ' BDT')
                var payable = charge + amount;
                $('#total-payable').html(payable.toFixed(2) + ' BDT')

            })
            $('#amount').trigger('keyup')

        })
    </script>
@endpush
