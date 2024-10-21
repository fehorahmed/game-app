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
        <div class="container">
            @include('frontend.layouts.message')
            <div class="heading_container justify-content-between" style="flex-direction: row;">
                <h2>
                    Withdraw <span>Page</span>
                </h2>
                <a href="{{route('user.withdraw.history')}}" class="btn btn-info">Withdraw History</a>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card payment-box">
                        <form action="{{ route('user.withdraw.method.submit') }}">

                            <div class="card-body payment-body">
                                <h5 class="text-center">Current Balance : {{auth()->user()->balance->balance??0}} BDT</h5>
                                <label for="" class="">Select Gateway <span class="text-danger">*</span></label>
                                <select name="method" class="form-control" id="method">
                                    <option value="">Select One</option>
                                    @foreach ($methods as $method)
                                        <option {{ old('method') == $method->id ? 'selected' : '' }}
                                            value="{{ $method->id }}" data-charge="{{ 0 }}" data-limit-start="{{ $method->withdraw_limit_start ?? 0 }}" data-limit-end="{{ $method->withdraw_limit_end ?? 0 }}">
                                            {{ $method->name }} {{ $method->account_type}}</option>
                                    @endforeach
                                </select>
                                @error('method')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror

                                <input type="hidden" name="transaction_fee" id="transaction_fee">
                                <label for="" class="mt-3">Amount <span class="text-danger">*</span></label>
                                <input type="number" name="amount" value="{{old('amount')}}" class="form-control" id="amount">
                                @error('amount')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror
                                <br>
                                <div id="details-area" class="hidden">
                                    <p class="d-flex justify-content-between"><span>Limit</span> <span> <span id="limit-start">0.00 BDT</span> - <span id="limit-end">0.00 BDT</span></span></p>
                                    {{-- <hr class="mt-0 mb-0">
                                    <p class="d-flex justify-content-between"><span>Charge</span> <span id="total-charge">0.00 BDT</span></p> --}}
                                    <hr class="mt-0 mb-0">
                                    <p class="d-flex justify-content-between"><span>Payable</span> <span id="total-payable">0.00 BDT</span>
                                    </p>
                                </div>
                                <div style="display: grid;">
                                    <button class="btn btn-success ">Submit</button>
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
            $('#method').trigger('change')
        })
    </script>
@endpush
