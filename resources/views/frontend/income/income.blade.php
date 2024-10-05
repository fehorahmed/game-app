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
                                @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td>Level {{ $i }}</td>
                                        <td>{{ number_format(\App\Helpers\Helper::get_level_gain($i),2) }}</td>
                                    </tr>
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
                                @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td>Level {{ $i }}</td>
                                        <td>{{ number_format(\App\Helpers\Helper::get_level_loss($i),2) }}</td>
                                    </tr>
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
            $('#method').change(function() {
                var method = $(this).val()
                var charge = $(this).find('option:selected').data('charge');
                var limit_start = parseFloat($(this).find('option:selected').data('limit-start'));
                var limit_end = parseFloat($(this).find('option:selected').data('limit-end'));
                $('#transaction_fee').val(charge)
                $('#limit-start').html(limit_start + ' BDT')
                $('#limit-end').html(limit_end + ' BDT')

                $('#amount').attr('min', limit_start);
                $('#amount').attr('max', limit_end);

                $('#amount').trigger('keyup')
            })
            $('#amount').keyup(function() {
                var amount = parseFloat($(this).val()); // Ensure the value is treated as a number
                if (amount > 0) {
                    $('#details-area').show();
                } else {
                    $('#details-area').hide();
                }
                var charge = parseFloat($('#transaction_fee').val());

                charge = (amount / 1000 * charge)

                $('#total-charge').html(charge.toFixed(2) + ' BDT')
                var payable = charge + amount;
                $('#total-payable').html(payable.toFixed(2) + ' BDT')

            })
            $('#amount').trigger('keyup')

        })
    </script>
@endpush
