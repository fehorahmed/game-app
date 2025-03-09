@extends('layouts.app')
@section('title', 'Global Config ')


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">Global Config</h4>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
        <form action="{{ route('global.config-store') }}" method="POST" class="my-1 form" autocomplete="off"
            enctype="multipart/form-data">
            <div class="card-body">

                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Application Configuration</h4>
                                    </div>
                                    <div class="col-auto">
                                        <!-- <button wire:click="list" class="btn btn-primary">@lang('common.btn.list')</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @php
                                    $data = \App\Helpers\Helper::get_config('application_name') ?? '';
                                @endphp
                                <label for="application_name" class="mb-2">Application Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="application_name"
                                        class="form-control @error('application_name') is-invalid @enderror"
                                        name="application_name" value="{{ $data }}">
                                    @error('application_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_config('application_email') ?? '';
                                @endphp
                                <label for="application_email" class="mb-2">Application Email</label>
                                <div class="mb-3">
                                    <input type="email" id="application_email"
                                        class="form-control @error('application_email') is-invalid @enderror"
                                        name="application_email" value="{{ $data }}">
                                    @error('application_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_config('company_name') ?? '';
                                @endphp
                                <label for="company_name" class="mb-2"> Company Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="company_name"
                                        class="form-control @error('company_name') is-invalid @enderror" name="company_name"
                                        value="{{ $data }}">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_config('max_referral_user') ?? '';
                                @endphp
                                <label for="max_referral_user" class="mb-2"> Max Referral User</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="max_referral_user"
                                        class="form-control @error('max_referral_user') is-invalid @enderror"
                                        name="max_referral_user" value="{{ $data }}">
                                    @error('max_referral_user')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @php
                                    $data = \App\Helpers\Helper::get_config('company_address') ?? '';
                                @endphp
                                <label for="company_address" class="mb-2">Company Address</label>
                                <div class="input-group mb-3">
                                    <textarea class="form-control" id="company_address" class="form-control @error('company_address') is-invalid @enderror"
                                        name="company_address" rows="3">{{ $data }}</textarea>
                                    @error('company_address')
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
                                        <h4 class="card-title">Coin Configuration</h4>
                                    </div>
                                    <div class="col-auto">
                                        <!-- <button wire:click="list" class="btn btn-primary">@lang('common.btn.list')</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data = \App\Helpers\Helper::get_config('registration_bonus');
                                        @endphp
                                        <label for="registration_bonus" class="mb-2"> Registration Bonus</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="registration_bonus"
                                                class="form-control @error('registration_bonus') is-invalid @enderror"
                                                name="registration_bonus" value="{{ $data }}">
                                            @error('registration_bonus')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data = \App\Helpers\Helper::get_config('game_initialize_coin_amount');
                                        @endphp
                                        <label for="game_initialize_coin_amount" class="mb-2">Game Initialize Coin
                                            Amount</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="game_initialize_coin_amount"
                                                class="form-control @error('game_initialize_coin_amount') is-invalid @enderror"
                                                name="game_initialize_coin_amount" value="{{ $data }}">
                                            @error('game_initialize_coin_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data = \App\Helpers\Helper::get_config('game_win_coin_deduct_percentage');
                                        @endphp
                                        <label for="game_win_coin_deduct_percentage" class="mb-2">Game Win Coin Deduct
                                            Percentage (%)</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="game_win_coin_deduct_percentage"
                                                class="form-control @error('game_win_coin_deduct_percentage') is-invalid @enderror"
                                                name="game_win_coin_deduct_percentage" value="{{ $data }}">
                                            @error('game_win_coin_deduct_percentage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data = \App\Helpers\Helper::get_config('coin_convert_amount');
                                        @endphp
                                        <label for="coin_convert_amount" class="mb-2"> Coin Convert Amount (1 tk = this
                                            coin amount)</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="coin_convert_amount"
                                                class="form-control @error('coin_convert_amount') is-invalid @enderror"
                                                name="coin_convert_amount" value="{{ $data }}">
                                            @error('coin_convert_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data = \App\Helpers\Helper::get_config('minimum_convert_coin');
                                        @endphp
                                        <label for="minimum_convert_coin" class="mb-2"> Minimum Convert Coin to Taka
                                            Amount (Coin)</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="minimum_convert_coin"
                                                class="form-control @error('minimum_convert_coin') is-invalid @enderror"
                                                name="minimum_convert_coin" value="{{ $data }}">
                                            @error('minimum_convert_coin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data =
                                                \App\Helpers\Helper::get_config('minimum_convert_taka_to_coin') ?? 0;
                                        @endphp
                                        <label for="minimum_convert_taka_to_coin" class="mb-2"> Minimum Convert Taka to
                                            Coin Amount (TK)</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="minimum_convert_taka_to_coin"
                                                class="form-control @error('minimum_convert_taka_to_coin') is-invalid @enderror"
                                                name="minimum_convert_taka_to_coin" value="{{ $data }}">
                                            @error('minimum_convert_taka_to_coin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Application Configuration</h4>
                                    </div>
                                    <div class="col-auto">
                                        <!-- <button wire:click="list" class="btn btn-primary">@lang('common.btn.list')</button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $login_image = \App\Helpers\Helper::get_config('login_image');
                                        @endphp
                                        <label for="login_image" class="mb-2">Log In Page Image</label>
                                        <div class="input-group mb-3">
                                            <input type="file" name="login_image" id="login_image"
                                                class="form-control">

                                            @error('login_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        @if ($login_image)
                                            <img src="{{ asset($login_image) }}" class="mt-1 mb-1" alt=""
                                                width="140px" height="100px">
                                        @endif
                                    </div>
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $registration_image = \App\Helpers\Helper::get_config('registration_image');
                                        @endphp
                                        <label for="registration_image" class="mb-2">Registration Page Image</label>
                                        <div class="mb-3">
                                            <input type="file" name="registration_image" id="registration_image"
                                                class="form-control">

                                            @error('registration_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        @if ($registration_image)
                                            <img src="{{ asset($registration_image) }}" class="mt-2" alt=""
                                                width="140px" height="100px">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Support Configuration</h4>
                                    </div>
                                    <div class="col-auto">

                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data = \App\Helpers\Helper::get_config('telegram_support');
                                        @endphp
                                        <label for="telegram_support" class="mb-2"> Telegram Support</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="telegram_support"
                                                class="form-control @error('telegram_support') is-invalid @enderror"
                                                name="telegram_support" value="{{ $data }}">
                                            @error('telegram_support')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data = \App\Helpers\Helper::get_config('whatsapp_support');
                                        @endphp
                                        <label for="whatsapp_support" class="mb-2">Whatsapp Support</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="whatsapp_support"
                                                class="form-control @error('whatsapp_support') is-invalid @enderror"
                                                name="whatsapp_support" value="{{ $data }}">
                                            @error('whatsapp_support')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xs m-auto">
                                        @php
                                            $data = \App\Helpers\Helper::get_config('facebook_support');
                                        @endphp
                                        <label for="facebook_support" class="mb-2">Facebook Support</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="facebook_support"
                                                class="form-control @error('facebook_support') is-invalid @enderror"
                                                name="facebook_support" value="{{ $data }}">
                                            @error('facebook_support')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

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
