@extends('layouts.app')
@section('title','App User List')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Customers Details </h4>
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

{{ $dataTable->scripts() }}

@endpush
