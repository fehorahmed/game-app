@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row justify-content-center">
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Today Member Joined</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ $today_member_joined }}</h3>

                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-users font-24 align-self-center text-muted"></i>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Today Add Money</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ number_format($today_add_money, 2) }} TK</h3>

                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-clock font-24 align-self-center text-muted"></i>
                                    </div>
                                </div> <!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Today Withdraw</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ number_format($today_withdraw, 2) }} TK</h3>

                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-activity font-24 align-self-center text-muted"></i>
                                    </div>
                                </div> <!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Monthly Member Joined</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ $monthly_member_joined }}</h3>

                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-users font-24 align-self-center text-muted"></i>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Monthly Add money</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ number_format($monthly_add_money, 2) }} TK</h3>

                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-confetti font-24 align-self-center text-muted"></i>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-9">
                                    <p class="text-dark mb-0 fw-semibold">Monthly withdraw</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ number_format($monthly_withdraw, 2) }} TK</h3>

                                </div><!--end col-->
                                <div class="col-3 align-self-center">
                                    <div
                                        class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                        <i class="ti ti-confetti font-24 align-self-center text-muted"></i>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            </div><!--end row-->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Audience Overview</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    This Year<i class="las la-angle-down ms-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Today</a>
                                    <a class="dropdown-item" href="#">Last Week</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">This Year</a>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="">
                        <div id="ana_dash_1" class="apex-charts"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

    </div><!--end row-->
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/analytics-index.init.js') }}"></script>
@endpush
