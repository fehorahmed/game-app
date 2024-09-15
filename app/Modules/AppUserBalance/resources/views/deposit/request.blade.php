@extends('layouts.app')
@section('title', 'Deposit Request List')

@push('styles')
    <!-- Include DataTables CSS -->
    @include('datatable.css.data_table_css')
@endpush
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Deposit Request List </h4>
                </div><!--end card-header-->
                <div class="card-body">
                    {{ $dataTable->table() }}
                    {{-- <div class="table-responsive">
                    </div> --}}
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('scripts')
    @include('datatable.js.data_table_js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(function() {
            $(document).on('click', '.btn-accept', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '{{ route('app_user.update.deposit.status') }}', // Your Laravel route
                            type: 'GET',
                            data: {
                                id: id,
                                status: 'accept',
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'The action was successful.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Reload the page after the SweetAlert confirmation
                                        location.reload(); // This will reload the page
                                    });
                                }else{
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

                    }
                });
            });



            $(document).on('click', '.btn-cancel', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '{{ route('app_user.update.deposit.status') }}', // Your Laravel route
                            type: 'GET',
                            data: {
                                id: id,
                                status: 'cancel',
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'The action was successful.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Reload the page after the SweetAlert confirmation
                                        location.reload(); // This will reload the page
                                    });
                                }else{
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

                    }
                });
            });

        })
    </script>
@endpush
