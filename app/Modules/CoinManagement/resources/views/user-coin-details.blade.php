@extends('layouts.app')
@section('title', 'User Coin ')


@section('content')

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Coin Details</h4>

                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>App User Name</th>
                                    <th>Source</th>
                                    <th>Coin</th>
                                    <th class="text-end">Date Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->usercoin->appuser->name ?? '' }}</td>
                                        <td>{{ $data->source ?? '' }}</td>
                                        <td>{{ $data->coin ?? 0 }}</td>
                                        <td class="text-end">{{ $data->created_at->format('Y-m-d h:m') }}</td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table><!--end /table-->

                    </div><!--end /tableresponsive-->
                    <div class="mt-2">
                        {{ $datas->links('pagination::bootstrap-5') }}
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->


    </div> <!-- end row -->
@endsection
