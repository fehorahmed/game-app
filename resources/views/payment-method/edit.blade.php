@extends('layouts.app')
@section('title', 'Payment Method Create ')


@section('content')

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Payment Method Create</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('config.payment-method.index') }}" type="button"
                                class="btn btn-primary btn-sm mb-3"><i class="fas fa-list"></i> List</a>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div>

                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label text-end">Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text"
                                            value="{{ old('name', $paymentMethod->name) }}" name="name"
                                            id="example-text-input">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="account_no" class="col-sm-3 col-form-label text-end">Account No</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text"
                                            value="{{ old('account_no', $paymentMethod->account_no) }}" name="account_no"
                                            id="account_no">
                                        @error('account_no')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="account_type" class="col-sm-3 col-form-label text-end">Account Type</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text"
                                            value="{{ old('account_type', $paymentMethod->account_type) }}"
                                            name="account_type" id="account_type">
                                        @error('account_type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="transaction_fee" class="col-sm-3 col-form-label text-end">Transaction
                                        Fee</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number"
                                            value="{{ old('transaction_fee', $paymentMethod->transaction_fee) }}"
                                            name="transaction_fee" id="transaction_fee">
                                        @error('transaction_fee')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">

                                <div class="row mb-3">
                                    <label class="col-md-3 my-1 control-label text-end">Status</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1"
                                                {{ old('status', $paymentMethod->status) == '1' ? 'checked' : '' }}
                                                value="1">
                                            <label class="form-check-label" for="inlineRadio1">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inlineRadio2"
                                                {{ old('status', $paymentMethod->status) == '0' ? 'checked' : '' }}
                                                value="0">
                                            <label class="form-check-label" for="inlineRadio2">Inactive</label>
                                        </div>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="logo" class="col-sm-3 col-form-label text-end">Logo</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" name="logo" id="logo">
                                        @error('logo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if ($paymentMethod->logo)
                                            <div class="mt-1">
                                                <img src="{{ asset($paymentMethod->logo) }}" alt="">
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-end">
                                <button type="submit" class="btn btn-primary px-4">Update Method</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!-- end col -->


    </div> <!-- end row -->
@endsection
