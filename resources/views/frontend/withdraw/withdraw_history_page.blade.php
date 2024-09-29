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
            <div class="heading_container heading_center">
                <h2>
                    Withdraw <span>Page</span>
                </h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-dark">
                        <tr>
                            <th>SL</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                        @foreach ($withdraws as $deposit)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$deposit->method->name??''}}</td>
                                <td>{{$deposit->withdraw_date}}</td>
                                <td>{{$deposit->amount}}</td>
                                <td>
                                    @if ($deposit->status == 1)
                                        <button class="btn btn-info btn-sm">Pending</button>
                                    @endif
                                    @if ($deposit->status == 2)
                                        <button class="btn btn-success btn-sm">Approved</button>
                                    @endif
                                    @if ($deposit->status == 0)
                                        <button class="btn btn-danger btn-sm">Cancel</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
