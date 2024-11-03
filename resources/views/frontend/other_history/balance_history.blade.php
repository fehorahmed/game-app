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
                    Balance <span> History</span>
                </h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-dark">
                        <tr>
                            <th>SL</th>
                            <th>Source</th>
                            <th>Balance Type</th>
                            <th>Balance</th>

                        </tr>
                        @foreach ($balance_details as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->source }}
                                </td>
                                <td>{{ $item->balance_type }}</td>
                                <td>{{ number_format($item->balance) }} </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
