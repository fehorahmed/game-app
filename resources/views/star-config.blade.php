@extends('layouts.app')
@section('title', 'Star Config ')


@section('content')
    <div class="card">
        {{-- <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">Star Config</h4>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div> --}}
        <form action="{{ route('star.config-store') }}" method="POST" class="my-1 form" autocomplete="off"
            enctype="multipart/form-data">
            <div class="card-body">

                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Withdraw or Transfer Limit Configuration  (Taka)</h4>
                                    </div>
                                    <div class="col-auto">
                                        <!-- <button wire:click="list" class="btn btn-primary">@lang('common.btn.list')</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @php
                                    $data = \App\Helpers\Helper::get_star_config('zero_start_withdraw') ?? '';
                                @endphp
                                <label for="zero_start_withdraw" class="mb-2">Zero Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="zero_start_withdraw"
                                        class="form-control @error('zero_start_withdraw') is-invalid @enderror"
                                        name="zero_start_withdraw" value="{{ $data }}">
                                    @error('zero_start_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('one_star_withdraw') ?? '';
                                @endphp
                                <label for="one_star_withdraw" class="mb-2">One Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="one_star_withdraw"
                                        class="form-control @error('one_star_withdraw') is-invalid @enderror"
                                        name="one_star_withdraw" value="{{ $data }}">
                                    @error('one_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('two_star_withdraw') ?? '';
                                @endphp
                                <label for="two_star_withdraw" class="mb-2">Two Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="two_star_withdraw"
                                        class="form-control @error('two_star_withdraw') is-invalid @enderror"
                                        name="two_star_withdraw" value="{{ $data }}">
                                    @error('two_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('three_star_withdraw') ?? '';
                                @endphp
                                <label for="three_star_withdraw" class="mb-2">Three Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="three_star_withdraw"
                                        class="form-control @error('three_star_withdraw') is-invalid @enderror"
                                        name="three_star_withdraw" value="{{ $data }}">
                                    @error('three_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('four_star_withdraw') ?? '';
                                @endphp
                                <label for="four_star_withdraw" class="mb-2">Four Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="four_star_withdraw"
                                        class="form-control @error('four_star_withdraw') is-invalid @enderror"
                                        name="four_star_withdraw" value="{{ $data }}">
                                    @error('four_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('five_star_withdraw') ?? '';
                                @endphp
                                <label for="five_star_withdraw" class="mb-2">Five Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="five_star_withdraw"
                                        class="form-control @error('five_star_withdraw') is-invalid @enderror"
                                        name="five_star_withdraw" value="{{ $data }}">
                                    @error('five_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('six_star_withdraw') ?? '';
                                @endphp
                                <label for="six_star_withdraw" class="mb-2">Six Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="six_star_withdraw"
                                        class="form-control @error('six_star_withdraw') is-invalid @enderror"
                                        name="six_star_withdraw" value="{{ $data }}">
                                    @error('six_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('seven_star_withdraw') ?? '';
                                @endphp
                                <label for="seven_star_withdraw" class="mb-2">Seven Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="seven_star_withdraw"
                                        class="form-control @error('seven_star_withdraw') is-invalid @enderror"
                                        name="seven_star_withdraw" value="{{ $data }}">
                                    @error('seven_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('eight_star_withdraw') ?? '';
                                @endphp
                                <label for="eight_star_withdraw" class="mb-2">Eight Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="eight_star_withdraw"
                                        class="form-control @error('eight_star_withdraw') is-invalid @enderror"
                                        name="eight_star_withdraw" value="{{ $data }}">
                                    @error('eight_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('nine_star_withdraw') ?? '';
                                @endphp
                                <label for="nine_star_withdraw" class="mb-2">Nine Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="nine_star_withdraw"
                                        class="form-control @error('nine_star_withdraw') is-invalid @enderror"
                                        name="nine_star_withdraw" value="{{ $data }}">
                                    @error('nine_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('ten_star_withdraw') ?? '';
                                @endphp
                                <label for="ten_star_withdraw" class="mb-2">Ten Star Withdraw / Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="ten_star_withdraw"
                                        class="form-control @error('ten_star_withdraw') is-invalid @enderror"
                                        name="ten_star_withdraw" value="{{ $data }}">
                                    @error('ten_star_withdraw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Star Price (Taka)</h4>
                                    </div>
                                    <div class="col-auto">
                                        <!-- <button wire:click="list" class="btn btn-primary">@lang('common.btn.list')</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @php
                                    $data = \App\Helpers\Helper::get_star_config('zero_start_price') ?? '';
                                @endphp
                                <label for="zero_start_price" class="mb-2">Zero Star Withdraw</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="zero_start_price"
                                        class="form-control @error('zero_start_price') is-invalid @enderror"
                                        name="zero_start_price" value="{{ $data }}">
                                    @error('zero_start_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('one_star_price') ?? '';
                                @endphp
                                <label for="one_star_price" class="mb-2">One Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="one_star_price"
                                        class="form-control @error('one_star_price') is-invalid @enderror"
                                        name="one_star_price" value="{{ $data }}">
                                    @error('one_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('two_star_price') ?? '';
                                @endphp
                                <label for="two_star_price" class="mb-2">Two Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="two_star_price"
                                        class="form-control @error('two_star_price') is-invalid @enderror"
                                        name="two_star_price" value="{{ $data }}">
                                    @error('two_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('three_star_price') ?? '';
                                @endphp
                                <label for="three_star_price" class="mb-2">Three Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="three_star_price"
                                        class="form-control @error('three_star_price') is-invalid @enderror"
                                        name="three_star_price" value="{{ $data }}">
                                    @error('three_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('four_star_price') ?? '';
                                @endphp
                                <label for="four_star_price" class="mb-2">Four Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="four_star_price"
                                        class="form-control @error('four_star_price') is-invalid @enderror"
                                        name="four_star_price" value="{{ $data }}">
                                    @error('four_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('five_star_price') ?? '';
                                @endphp
                                <label for="five_star_price" class="mb-2">Five Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="five_star_price"
                                        class="form-control @error('five_star_price') is-invalid @enderror"
                                        name="five_star_price" value="{{ $data }}">
                                    @error('five_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('six_star_price') ?? '';
                                @endphp
                                <label for="six_star_price" class="mb-2">Six Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="six_star_price"
                                        class="form-control @error('six_star_price') is-invalid @enderror"
                                        name="six_star_price" value="{{ $data }}">
                                    @error('six_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('seven_star_price') ?? '';
                                @endphp
                                <label for="seven_star_price" class="mb-2">Seven Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="seven_star_price"
                                        class="form-control @error('seven_star_price') is-invalid @enderror"
                                        name="seven_star_price" value="{{ $data }}">
                                    @error('seven_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('eight_star_price') ?? '';
                                @endphp
                                <label for="eight_star_price" class="mb-2">Eight Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="eight_star_price"
                                        class="form-control @error('eight_star_price') is-invalid @enderror"
                                        name="eight_star_price" value="{{ $data }}">
                                    @error('eight_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('nine_star_price') ?? '';
                                @endphp
                                <label for="nine_star_price" class="mb-2">Nine Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="nine_star_price"
                                        class="form-control @error('nine_star_price') is-invalid @enderror"
                                        name="nine_star_price" value="{{ $data }}">
                                    @error('nine_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('ten_star_price') ?? '';
                                @endphp
                                <label for="ten_star_price" class="mb-2">Ten Star Price</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="ten_star_price"
                                        class="form-control @error('ten_star_price') is-invalid @enderror"
                                        name="ten_star_price" value="{{ $data }}">
                                    @error('ten_star_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Coin Transfer Limit Configuration </h4>
                                    </div>
                                    <div class="col-auto">
                                        <!-- <button wire:click="list" class="btn btn-primary">@lang('common.btn.list')</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @php
                                    $data = \App\Helpers\Helper::get_star_config('zero_start_coin_transfer') ?? '';
                                @endphp
                                <label for="zero_start_coin_transfer" class="mb-2">Zero Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="zero_start_coin_transfer"
                                        class="form-control @error('zero_start_coin_transfer') is-invalid @enderror"
                                        name="zero_start_coin_transfer" value="{{ $data }}">
                                    @error('zero_start_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('one_star_coin_transfer') ?? '';
                                @endphp
                                <label for="one_star_coin_transfer" class="mb-2">One Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="one_star_coin_transfer"
                                        class="form-control @error('one_star_coin_transfer') is-invalid @enderror"
                                        name="one_star_coin_transfer" value="{{ $data }}">
                                    @error('one_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('two_star_coin_transfer') ?? '';
                                @endphp
                                <label for="two_star_coin_transfer" class="mb-2">Two Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="two_star_coin_transfer"
                                        class="form-control @error('two_star_coin_transfer') is-invalid @enderror"
                                        name="two_star_coin_transfer" value="{{ $data }}">
                                    @error('two_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('three_star_coin_transfer') ?? '';
                                @endphp
                                <label for="three_star_coin_transfer" class="mb-2">Three Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="three_star_coin_transfer"
                                        class="form-control @error('three_star_coin_transfer') is-invalid @enderror"
                                        name="three_star_coin_transfer" value="{{ $data }}">
                                    @error('three_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('four_star_coin_transfer') ?? '';
                                @endphp
                                <label for="four_star_coin_transfer" class="mb-2">Four Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="four_star_coin_transfer"
                                        class="form-control @error('four_star_coin_transfer') is-invalid @enderror"
                                        name="four_star_coin_transfer" value="{{ $data }}">
                                    @error('four_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('five_star_coin_transfer') ?? '';
                                @endphp
                                <label for="five_star_coin_transfer" class="mb-2">Five Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="five_star_coin_transfer"
                                        class="form-control @error('five_star_coin_transfer') is-invalid @enderror"
                                        name="five_star_coin_transfer" value="{{ $data }}">
                                    @error('five_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('six_star_coin_transfer') ?? '';
                                @endphp
                                <label for="six_star_coin_transfer" class="mb-2">Six Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="six_star_coin_transfer"
                                        class="form-control @error('six_star_coin_transfer') is-invalid @enderror"
                                        name="six_star_coin_transfer" value="{{ $data }}">
                                    @error('six_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('seven_star_coin_transfer') ?? '';
                                @endphp
                                <label for="seven_star_coin_transfer" class="mb-2">Seven Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="seven_star_coin_transfer"
                                        class="form-control @error('seven_star_coin_transfer') is-invalid @enderror"
                                        name="seven_star_coin_transfer" value="{{ $data }}">
                                    @error('seven_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('eight_star_coin_transfer') ?? '';
                                @endphp
                                <label for="eight_star_coin_transfer" class="mb-2">Eight Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="eight_star_coin_transfer"
                                        class="form-control @error('eight_star_coin_transfer') is-invalid @enderror"
                                        name="eight_star_coin_transfer" value="{{ $data }}">
                                    @error('eight_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('nine_star_coin_transfer') ?? '';
                                @endphp
                                <label for="nine_star_coin_transfer" class="mb-2">Nine Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="nine_star_coin_transfer"
                                        class="form-control @error('nine_star_coin_transfer') is-invalid @enderror"
                                        name="nine_star_coin_transfer" value="{{ $data }}">
                                    @error('nine_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('ten_star_coin_transfer') ?? '';
                                @endphp
                                <label for="ten_star_coin_transfer" class="mb-2">Ten Star Coin Transfer</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="ten_star_coin_transfer"
                                        class="form-control @error('ten_star_coin_transfer') is-invalid @enderror"
                                        name="ten_star_coin_transfer" value="{{ $data }}">
                                    @error('ten_star_coin_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Level Income Percentage </h4>
                                    </div>
                                    <div class="col-auto">
                                        <!-- <button wire:click="list" class="btn btn-primary">@lang('common.btn.list')</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @php
                                    $data = \App\Helpers\Helper::get_star_config('zero_level_percent') ?? '';
                                @endphp
                                <label for="zero_level_percent" class="mb-2">Zero Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="zero_level_percent"
                                        class="form-control @error('zero_level_percent') is-invalid @enderror"
                                        name="zero_level_percent" value="{{ $data }}">
                                    @error('zero_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('one_level_percent') ?? '';
                                @endphp
                                <label for="one_level_percent" class="mb-2">One Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="one_level_percent"
                                        class="form-control @error('one_level_percent') is-invalid @enderror"
                                        name="one_level_percent" value="{{ $data }}">
                                    @error('one_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('two_level_percent') ?? '';
                                @endphp
                                <label for="two_level_percent" class="mb-2">Two Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="two_level_percent"
                                        class="form-control @error('two_level_percent') is-invalid @enderror"
                                        name="two_level_percent" value="{{ $data }}">
                                    @error('two_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('three_level_percent') ?? '';
                                @endphp
                                <label for="three_level_percent" class="mb-2">Three Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="three_level_percent"
                                        class="form-control @error('three_level_percent') is-invalid @enderror"
                                        name="three_level_percent" value="{{ $data }}">
                                    @error('three_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('four_level_percent') ?? '';
                                @endphp
                                <label for="four_level_percent" class="mb-2">Four Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="four_level_percent"
                                        class="form-control @error('four_level_percent') is-invalid @enderror"
                                        name="four_level_percent" value="{{ $data }}">
                                    @error('four_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('five_level_percent') ?? '';
                                @endphp
                                <label for="five_level_percent" class="mb-2">Five Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="five_level_percent"
                                        class="form-control @error('five_level_percent') is-invalid @enderror"
                                        name="five_level_percent" value="{{ $data }}">
                                    @error('five_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('six_level_percent') ?? '';
                                @endphp
                                <label for="six_level_percent" class="mb-2">Six Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="six_level_percent"
                                        class="form-control @error('six_level_percent') is-invalid @enderror"
                                        name="six_level_percent" value="{{ $data }}">
                                    @error('six_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('seven_level_percent') ?? '';
                                @endphp
                                <label for="seven_level_percent" class="mb-2">Seven Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="seven_level_percent"
                                        class="form-control @error('seven_level_percent') is-invalid @enderror"
                                        name="seven_level_percent" value="{{ $data }}">
                                    @error('seven_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('eight_level_percent') ?? '';
                                @endphp
                                <label for="eight_level_percent" class="mb-2">Eight Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="eight_level_percent"
                                        class="form-control @error('eight_level_percent') is-invalid @enderror"
                                        name="eight_level_percent" value="{{ $data }}">
                                    @error('eight_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('nine_level_percent') ?? '';
                                @endphp
                                <label for="nine_level_percent" class="mb-2">Nine Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="nine_level_percent"
                                        class="form-control @error('nine_level_percent') is-invalid @enderror"
                                        name="nine_level_percent" value="{{ $data }}">
                                    @error('nine_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_star_config('ten_level_percent') ?? '';
                                @endphp
                                <label for="ten_level_percent" class="mb-2">Ten Level Percent</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="ten_level_percent"
                                        class="form-control @error('ten_level_percent') is-invalid @enderror"
                                        name="ten_level_percent" value="{{ $data }}">
                                    @error('ten_level_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row mt-2 mb-2 align-items-center">
                    <div class="col"></div>
                    <div class="col col-sm col-xs m-auto text-end">
                        {{-- @if (auth()->user()->hasPermission('sys-conf-edit-schedule-backup')) --}}
                        <button type="submit" class="btn btn-primary ">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
