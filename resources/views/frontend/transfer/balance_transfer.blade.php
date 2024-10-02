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
                    Balance <span>Transfer</span>
                </h2>
                <a href="{{route('user.balance_transfer.history')}}" class="btn btn-info">Balance Transfer History</a>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card payment-box">
                        <form action="{{ route('user.balance_transfer_store') }}" method="POST">
                            @csrf

                            <div class="card-body payment-body">
                                <h3 class="text-center">Current Balance : {{ auth()->user()->balance->balance ?? 0 }} tk</h3>

                                <label for="amount" class="mt-3">Amount <span class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control" id="amount" value="{{old('amount')}}">
                                @error('amount')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror

                                <label for="user_id" class="">User ID <span class="text-danger">*</span></label>
                                <input type="number" name="user_id" class="form-control" id="user_id" value="{{old('user_id')}}">

                                @error('user_id')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror

                                <label for="password" class="">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="password">

                                @error('password')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror
                                <br>
                                <div style="display: grid;">
                                    <button class="btn btn-success ">Submit Transfer</button>
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
            $('#method').change(function() {
                var method = $(this).val()
                var charge = $(this).find('option:selected').data('charge');
                var limit_start = parseFloat($(this).find('option:selected').data('limit-start'));
                var limit_end = parseFloat($(this).find('option:selected').data('limit-end'));
                $('#transaction_fee').val(charge)
                $('#limit-start').html(limit_start + ' BDT')
                $('#limit-end').html(limit_end  + ' BDT')

                $('#amount').attr('min',limit_start);
                $('#amount').attr('max',limit_end);

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

                 charge = (amount/1000*charge)

                $('#total-charge').html(charge.toFixed(2) + ' BDT')
                var payable= charge+amount;
                $('#total-payable').html(payable.toFixed(2) + ' BDT')

            })
            $('#amount').trigger('keyup')

        })
    </script>
@endpush
