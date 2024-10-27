@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section style="background: #00204a;color:#ffffff;" class=" layout_padding">
        <div class="container  ">
            @if (session('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif
            @if (session('error'))
                <p class="alert alert-danger">{{session('error')}}</p>
            @endif
            <div style="flex-direction: row; " class="row heading_container  d-flex justify-content-between">
                    <h2>
                        Add <span>Yourself</span>
                    </h2>


            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-secondary">
                        <form action="" method="POST">
                            @csrf

                            <div class="card-body payment-body">

                                <label for="user_id" class="mt-3">Enter User ID <span class="text-danger">*</span></label>
                                <input type="number" name="user_id" class="form-control" id="user_id"
                                    value="{{ old('user_id') }}">
                                <p class="text-light" id="user_name"></p>
                                @error('user_id')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror

                                {{-- <label for="password" class="">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="password">

                                @error('password')
                                    <p class="text-warning">{{ $message }}</p>
                                @enderror --}}
                                <br>
                                <div style="display: grid;">
                                    <button class="btn btn-success ">Submit Request</button>
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
                            url: '{{ route('user.get-user-by-user_id-for-add-yourself') }}', // Your Laravel route
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
