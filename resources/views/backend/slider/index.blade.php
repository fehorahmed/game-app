@extends('layouts.app')
@section('title', 'Slider List')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Slider List </h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('config.home-slide.create') }}" type="button"
                                class="btn btn-primary btn-sm mb-3">Create Slider</a>
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
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$data->title}}</td>
                                    <td>
                                        @if ($data->image)
                                        <img src="{{ asset($data->image) }}" alt="" height="50">
                                    @endif
                                    </td>
                                    <td>
                                        @if ($data->status == 1)
                                                <p class="badge bg-success">Active</p>
                                            @elseif ($data->status == 0)
                                                <p class="badge bg-danger">Inactive</p>
                                            @else
                                                no status
                                            @endif
                                    </td>
                                    <td>
                                        <a href="{{route('config.home-slide.edit',$data->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $datas->links("pagination::bootstrap-4") }}
                        {{-- {{ $datas->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

