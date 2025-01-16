@extends('layouts.app')
@section('title', 'Help Video List')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Help Video List </h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('config.help-video.create') }}" type="button"
                                class="btn btn-primary btn-sm mb-3">Create Help Video</a>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th>URL</th>
                                    <th>Serial</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->title }}</td>
                                        <td>{{ $data->url }}</td>
                                        <td>{{ $data->serial }}</td>

                                        <td>
                                            <button data-id="{{ $data->id }}"
                                                class="btn btn-danger btn-sm btn-delete">Delete</button>
                                            {{-- <a href="{{route('config.home-slide.edit',$data->id)}}" class="btn btn-primary btn-sm">Edit</a> --}}
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $datas->links('pagination::bootstrap-4') }}
                        {{-- {{ $datas->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@push('scripts')
    <script>
        $('.btn-delete').click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (id) {

                        $.ajax({
                            url: '{{ route('config.help-video.destroy') }}', // Your Laravel route
                            type: 'GET',
                            data: {
                                id: id,
                            },
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'The action was successful.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Reload the page after the SweetAlert confirmation
                                        location.reload(); // This will reload the page
                                    });
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
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong!",
                            icon: "error"
                        });
                    }



                }
            });
        })
    </script>
@endpush
