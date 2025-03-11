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
        <div class="container ">
            @include('frontend.layouts.message')
            <div class="heading_container heading_center">
                <h2>
                    Taka to Coin <span>Convert History</span>
                </h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-dark">
                        <tr>
                            <th>SL</th>
                            <th>Coin Amount</th>
                            <th>Coin Rate</th>
                            <th>Balance</th>
                            <th>Date</th>


                        </tr>
                        @foreach ($datas as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $item->coin }} </td>
                                <td> {{ $item->coin_rate }} </td>
                                <td> {{ $item->balance }} </td>
                                <td>{{ $item->created_at }}</td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
