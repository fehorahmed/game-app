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
                    Balance <span>Transfer</span>
                </h2>
                <a href="{{ route('user.balance_transfer.history') }}" class="btn btn-info">Balance Transfer History</a>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card payment-box">
                        <form action="{{ route('user.balance_transfer_store') }}" method="POST">
                            @csrf

                            <div class="card-body payment-body">
                                <h3 class="text-center">Current Balance : {{ auth()->user()->balance->balance ?? 0 }} tk
                                </h3>

                                <label for="amount" class="mt-3">Amount <span class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control" id="amount"
                                    value="{{ old('amount') }}">
                                @error('amount')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror

                                <label for="user_id" class="mt-3">User ID <span class="text-danger">*</span></label>
                                <input type="number" name="user_id" class="form-control" id="user_id"
                                    value="{{ old('user_id') }}">
                                <p class="text-light" id="user_name"></p>
                                @error('user_id')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror

                                <label for="password" class="">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="password">

                                @error('password')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror
                                <br>
                                <div style="display: grid;">
                                    <button class="btn btn-success ">Submit Transfer</button>
                                </div>

                            </div>
                        </form>
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

            $('#user_id').keyup(function() {
                var user_input = $(this).val(); // Get the input value as a string

                if (user_input.length == 10 ) {


                    $.ajax({
                            url: '{{ route('user.get-user-by-user_id') }}', // Your Laravel route
                            type: 'GET',
                            data:{
                                'user_id' : user_input
                            },
                            success: function(response) {
                                if (response.status) {

                                    $('#user_name').html(response.data.name)
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message,
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                // Show error message if something goes wrong
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong.',
                                    icon: 'error',
                                });
                            }
                        });


                } else {
                    $('#user_name').html('')
                }

            })
            $('#user_id').trigger('keyup')

        })
    </script>
@endpush
