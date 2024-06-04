@extends('layouts.app')
@section('title', 'App User List')

@push('styles')
    <!-- Include DataTables CSS -->
    @include('datatable.css.data_table_css')
@endpush
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">App User List </h4>
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
    {{-- {!! $dataTable->scripts() !!} --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
