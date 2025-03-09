@extends('frontend.layouts.app')

@push('style')
    <style>
        .payment-box {
            background-color: #705b60;
        }
    </style>
@endpush
@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            @include('frontend.layouts.message')
            <div class="heading_container justify-content-between" style="flex-direction: row;">
                <h2>
                   Taka To Coin <span>Convert</span>
                </h2>
                <a href="{{route('user.taka_to_coin_convert.history')}}" class="btn btn-info">Taka to Coin Convert  History</a>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card payment-box">
                        <form action="{{ route('user.taka_to_coin_convert_store') }}" method="POST">
                            @csrf

                            <div class="card-body payment-body">
                                <h3 class="text-center">Your Current Balance : {{ auth()->user()->balance->balance ?? 0 }} TK</h3>

                                <h2 class="text-center"> Taka to Coin Convert Rate </h2>
                                <h4 class="text-center"><b> 1 tk = <span id="global_amount">{{\App\Helpers\Helper::get_config('coin_convert_amount')??0}}</span> coin  </b></h4>

                                <label for="amount" class="mt-3">Balance Amount <span class="text-danger">*</span></label>
                                <input type="number" name="amount" required min="{{\App\Helpers\Helper::get_config('minimum_convert_taka_to_coin')??0 }}" class="form-control" id="amount" value="{{old('amount')}}">
                                @error('amount')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror

                                <div class="text-center">
                                    You will get <span id="get_amount"></span> coin
                                </div>

                                <label for="password" class="">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="password">

                                @error('password')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror
                                <br>
                                <div style="display: grid;">
                                    <button class="btn btn-success ">Convert</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection

@push('script')
    <script>
        $(function() {

            $('#amount').keyup(function() {

                var amount = parseFloat($(this).val()); // Ensure the value is treated as a number
                var globalAmount = "{{\App\Helpers\Helper::get_config('coin_convert_amount')??0}}";
                var total = 0;
                if (amount > 0) {
                    total = amount *globalAmount;


                }
                $('#get_amount').html(total);

            })
            $('#amount').trigger('keyup')

        })
    </script>
@endpush
