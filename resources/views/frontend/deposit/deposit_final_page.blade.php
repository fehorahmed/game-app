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
            <div class="heading_container heading_center">
                <h2>
                    Deposit <span>Page</span>
                </h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card payment-box">
                        <form action="{{ route('user.deposit.method.final_submit') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="card-body payment-body">

                                <div id="details-area">
                                    {!! $method->manual_text !!}
                                </div>
                                <hr>
                                <h4 class="text-center">Account No: {{$method->account_no}}</h4>
                                <h5 class="text-center">Total Amount : {{ $amount + $transaction_fee }} BDT</h5>
                                <input type="hidden" name="transaction_fee" id="transaction_fee"
                                    value="{{ $transaction_fee }}">
                                <input type="hidden" name="amount" id="amount" value="{{ $amount }}">
                                <input type="hidden" name="method" id="method" value="{{ $method->id }}">
                                <label for="transaction_id" class="mt-2">Transaction ID <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="transaction_id" class="form-control" id="transaction_id">
                                @error('transaction_id')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror
                                <label for="password" class="mt-2">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="password">
                                @error('password')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror
                                <br>

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
@endpush
