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
                                        <input class="form-control" type="text" value="{{ old('name') }}"
                                            name="name" id="example-text-input">
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
                                        <input class="form-control" type="text" value="{{ old('account_no') }}"
                                            name="account_no" id="account_no">
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
                                        <input class="form-control" type="text" value="{{ old('account_type') }}"
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
                                        <input class="form-control" type="number" value="{{ old('transaction_fee') }}"
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
                                <div class="mb-3 row">
                                    <label for="limit_start" class="col-sm-3 col-form-label text-end">Deposit Limit Start</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ old('limit_start') }}"
                                            name="limit_start" id="limit_start">
                                        @error('limit_start')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="limit_end" class="col-sm-3 col-form-label text-end">Deposit Limit End</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ old('limit_end') }}"
                                            name="limit_end" id="limit_end">
                                        @error('limit_end')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="withdraw_limit_start" class="col-sm-3 col-form-label text-end">Withdraw Limit Start</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ old('withdraw_limit_start') }}"
                                            name="withdraw_limit_start" id="withdraw_limit_start">
                                        @error('withdraw_limit_start')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="withdraw_limit_end" class="col-sm-3 col-form-label text-end">Withdraw Limit End</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ old('withdraw_limit_end') }}"
                                            name="withdraw_limit_end" id="withdraw_limit_end">
                                        @error('withdraw_limit_end')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="manual_text" class="col-sm-3 col-form-label text-end">Deposit Manual Text</label>
                                    <div class="col-sm-9">
                                        <textarea name="manual_text" id="manual_text" class="form-control" cols="30" rows="10"></textarea>
                                        @error('manual_text')
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
                                            <input class="form-check-input" type="radio" name="status"
                                                id="inlineRadio1" {{ old('status') == '1' ? 'checked' : '' }}
                                                value="1">
                                            <label class="form-check-label" for="inlineRadio1">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="inlineRadio2" {{ old('status') == '0' ? 'checked' : '' }}
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
                                <div class="mb-3 row">
                                    <label for="logo" class="col-sm-3 col-form-label text-end">Logo</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" name="logo" id="logo">
                                        @error('logo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-end">
                                <button type="submit" class="btn btn-primary px-4">Store Method</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!-- end col -->

@endsection
@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#manual_text',

        });
    </script>
@endpush
