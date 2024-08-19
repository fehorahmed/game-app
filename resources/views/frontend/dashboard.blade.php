@extends('frontend.layouts.app')

@push('style')

<style>
    .about_section .box {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    text-align: center;
    margin-top: 15px;
    background-color: #2a2a35;
    padding: 20px;
    /* color: black; */
    border-radius: 5px;
}
</style>

@endpush
@section('content')
    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            <div class="heading_container heading_center">
                <h2>
                    Dashboard <span>Page</span>
                </h2>

            </div>
            <div class="row">

                <div class="col-md-4 ">
                    <div class="box ">

                        <div class="detail-box ">
                            <h5 class="font-weight-bold">
                                Total Balance
                            </h5>
                            <p>
                                {{auth()->user()->balance->balance ?? 0}} tk
                            </p>
                             {{-- <a href="">
                                Read More
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="box">

                        <div class="detail-box">
                            <h5 class="font-weight-bold">
                                Total Coin
                            </h5>
                            <p>
                                {{auth()->user()->coin->coin ?? 0}}
                            </p>
                             {{-- <a href="">
                                Read More
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="box ">

                        <div class="detail-box">
                            <h5 class="font-weight-bold">
                                Total Diposit
                            </h5>
                            <p>
                                120 tk
                            </p>
                            {{-- <a href="">
                                Read More
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="box ">

                        <div class="detail-box">
                            <h5 class="font-weight-bold">
                                Total Withdraw
                            </h5>
                            <p>
                                120 tk
                            </p>
                            {{-- <a href="">
                                Read More
                            </a> --}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
