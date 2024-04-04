@extends('layouts.app')
@section('title','Admin List')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin Details </h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@push('scripts')

{{ $dataTable->scripts() }}

@endpush
