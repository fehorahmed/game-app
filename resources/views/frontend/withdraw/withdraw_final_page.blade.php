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
            <div class="heading_container heading_center">
                <h2>
                    Deposit <span>Page</span>
                </h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card payment-box">
                        <form action="{{ route('user.withdraw.method.final_submit') }}" method="POST">
                            @csrf
                            <div class="card-body payment-body">

                                {{-- <div id="details-area">
                                    {!! $method->manual_text !!}
                                </div> --}}
                                <hr>
                                <h5 class="text-center">Total Amount : {{$amount + $transaction_fee}} BDT</h5>
                                <input type="hidden" name="transaction_fee" id="transaction_fee" value="{{$transaction_fee}}">
                                <input type="hidden" name="amount" id="amount" value="{{$amount}}">
                                <input type="hidden" name="method" id="method" value="{{$method->id}}">
                                <label for="" class="mt-2">{{$method->name}} Number <span class="text-danger">*</span></label>
                                <input type="number" name="account_no" class="form-control" id="account_no">
                                @error('account_no')
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
