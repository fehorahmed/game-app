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
            <div class="heading_container justify-content-between" style="flex-direction: row;">
                <h2>
                    Your <span>Income</span>
                </h2>
                <p>Total Gain : <span id="gain"></span> &emsp; Total Loss : <span id="loss"></span></p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-dark">
                        <div class="card-header">Your Gain</div>
                        <div class="card-body">
                            <table class="table text-light table-borderless">
                                <tr>
                                    <th>Level</th>
                                    <th>Taka</th>
                                </tr>
                                @php
                                    $gain = 0;
                                @endphp
                                @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td>Level {{ $i }}</td>
                                        <td>{{ number_format(\App\Helpers\Helper::get_level_gain($i), 2) }}</td>
                                    </tr>
                                    @php
                                        $gain += \App\Helpers\Helper::get_level_gain($i);
                                    @endphp
                                @endfor

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-dark">
                        <div class="card-header">Your Loss</div>
                        <div class="card-body">
                            <table class="table text-light table-borderless">
                                <tr>
                                    <th>Level</th>
                                    <th>Taka</th>
                                </tr>
                                @php
                                    $loss = 0;
                                @endphp
                                @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td>Level {{ $i }}</td>
                                        <td>{{ number_format(\App\Helpers\Helper::get_level_loss($i), 2) }}</td>
                                    </tr>
                                    @php
                                        $loss += \App\Helpers\Helper::get_level_loss($i);
                                    @endphp
                                @endfor
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection

@push('script')
    <script>
        $(function() {

            var gain = '{{ $gain }}'
            var loss = '{{ $loss }}'
            $('#gain').html(gain + ' TK')
            $('#loss').html(loss + ' TK')
        })
    </script>
@endpush
