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
        <form action="{{ route('global.config-store') }}" method="POST" class="my-1 form" autocomplete="off">
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
