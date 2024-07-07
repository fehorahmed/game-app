@extends('layouts.app')
@section('title', 'Payment Methods')
@push('styles')
    <!-- Include DataTables CSS -->
@endpush
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h4 class="card-title">Payment Methods </h4> --}}
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Payment Methods</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('config.payment-method.create') }}" type="button"
                                class="btn btn-primary btn-sm mb-3">Create Payment Method</a>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($methods as $method)
                                    <tr>
                                        <td>{{ $loop->iteration ?? '' }}</td>
                                        <td>
                                            @if ($method->logo)
                                                <img src="{{ asset($method->logo) }}" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $method->name ?? '' }}</td>
                                        <td>
                                            @if ($method->status == 1)
                                                <p class="badge bg-success">Active</p>
                                            @elseif ($method->status == 0)
                                                <p class="badge bg-danger">Inactive</p>
                                            @else
                                                no status
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('config.payment-method.edit', $method->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@push('scripts')
@endpush
