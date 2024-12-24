@extends('layouts.app')
@section('title', 'Own Website List ')


@section('content')

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Own Website List</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('admin.own.website.create') }}" type="button"
                                class="btn btn-primary btn-sm mb-3">Create Own Website</a>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div>
                {{-- <div class="card-header">
                    <h4 class="card-title">Website List</h4>

                </div><!--end card-header--> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Coin</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($websites as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->name ?? '' }}</td>
                                        <td>{{ Str::limit($data->url, 50) }}</td>

                                        <td>{{ $data->coin ?? 0 }}</td>
                                        <td>
                                            @if ($data->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.own.website.edit', $data->id) }}" type="button"
                                                class="btn btn-primary btn-sm ">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table><!--end /table-->

                    </div><!--end /tableresponsive-->
                    <div class="mt-2">
                        {{-- {{ $datas->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->


    </div> <!-- end row -->
@endsection
