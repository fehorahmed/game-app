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
        <div class="container  ">
            @include('frontend.layouts.message')
            <div class="heading_container heading_center">
                <h2>
                    Balance <span>Transfer History</span>
                </h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-dark">
                        <tr>
                            <th>SL</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Amount</th>

                        </tr>
                        @foreach ($transfers as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    Name : {{ $item->receivedUser->name }} <br>
                                    User ID : {{ $item->receivedUser->user_id }}
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ number_format($item->balance, 2) }} tk</td>


                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
