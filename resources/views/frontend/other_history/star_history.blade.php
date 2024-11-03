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
                    Star <span> History</span>
                </h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-dark">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Star Amount</th>
                            <th>Price</th>
                        </tr>
                        @foreach ($balance_details as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->star_amount }}</td>
                                <td>{{ number_format($item->price) }} </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
