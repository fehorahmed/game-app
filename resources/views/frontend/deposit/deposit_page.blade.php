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
            <div class="heading_container heading_center">
                <h2>
                    Deposit <span>Page</span>
                </h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card payment-box">
                        <form action="{{route('user.deposit.method.submit')}}">

                        <div class="card-body payment-body">
                            <label for="" class="">Select Gateway <span class="text-danger">*</span></label>
                            <select name="method" class="form-control" id="method">
                                <option value="">Select One</option>
                                @foreach ($methods as $method)
                                    <option {{ old('method') == $method->id ? 'selected' : '' }} value="{{ $method->id }}">
                                        {{ $method->name }}</option>
                                @endforeach
                            </select>
                            @error('method')
                                <p class="text-warning">{{$message}}</p>
                            @enderror
                            <label for="" class="mt-3">Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control" id="amount">
                            @error('amount')
                                <p class="text-warning">{{$message}}</p>
                            @enderror
                            <br>
                            <p class="d-flex justify-content-between"><span>Limit</span> <span>350.00 BDT - 25000.00
                                    BDT</span></p>
                            <hr class="mt-0 mb-0">
                            <p class="d-flex justify-content-between"><span>Charge</span> <span>0.00 BDT</span></p>
                            <hr class="mt-0 mb-0">
                            <p class="d-flex justify-content-between"><span>Payable</span> <span>500.00 BDT</span></p>
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
