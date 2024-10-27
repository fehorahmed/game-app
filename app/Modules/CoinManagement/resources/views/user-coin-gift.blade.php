@extends('layouts.app')
@section('title', 'Coin Gift')

@section('content')

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Coin Gift</h4>

                </div><!--end card-header-->
                <form action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="user_id" class="col-sm-2 col-form-label text-end">User ID</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="number" name="user_id" id="user_id">
                                        @error('user_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="user_name" class="col-sm-2 col-form-label text-end">User Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" readonly id="user_name" name="user_name">

                                        @error('user_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="mb-3 row">
                                <label for="amount" class="col-sm-2 col-form-label text-end">Telephone</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" id="amount">
                                </div>
                            </div> --}}

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label text-end">Select Coin Amount</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="coin" aria-label="Default select example">
                                            <option value="">Select Amount</option>
                                            <option value="10000">10k</option>
                                            <option value="100000">100k</option>
                                            <option value="500000">500k</option>
                                            <option value="1000000">1m</option>
                                            <option value="2000000">2m</option>
                                        </select>
                                        @error('amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-12 text-end">
                                        <button class="btn btn-primary" type="submit">Submit Gift</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div><!--end card-body-->
                </form>
            </div><!--end card-->
        </div> <!-- end col -->


    </div> <!-- end row -->
@endsection

@push('scripts')
    <script>
        $(function() {

            $('#user_id').keyup(function() {
                var user_input = $(this).val(); // Get the input value as a string

                if (user_input.length >= 10 ) {
                    $.ajax({
                            url: '{{ route('user.get-user-by-user_id') }}', // Your Laravel route
                            type: 'GET',
                            data:{
                                'user_id' : user_input
                            },
                            success: function(response) {
                                if (response.status) {

                                    $('#user_name').val(response.data.name)
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message,
                                        icon: 'error',
                                    });
                                    $('#user_name').val('')
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
