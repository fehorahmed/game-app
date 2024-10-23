@extends('layouts.app')
@section('title', 'Users Coin')

@push('styles')
    <!-- Include DataTables CSS -->
    @include('datatable.css.data_table_css')
@endpush
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Coin List </h4>
                </div><!--end card-header-->
                <div class="card-body">
                    {{ $dataTable->table() }}
                    {{-- <div class="table-responsive">
                    </div> --}}
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Coin Given Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="modal_user_coin_id" id="modal_user_coin_id">
                    <label for="name"> User Name </label>
                    <input type="text" name="name" id="modal_name" class="form-control" placeholder="" readonly>
                    <label for="coin" class="mt-2"> Enter Coin Amount </label>
                    <input type="number" name="coin" id="modal_coin" class="form-control" placeholder="Coin Amount">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Give Coin</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('datatable.js.data_table_js')
    {{-- {!! $dataTable->scripts() !!} --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}


    <script>
        $(function(){
            $('body').on('click','.user-coin-btn',function(){
                var data_user_coin_id = $(this).attr('data-user-coin-id')
                var data_user_name = $(this).attr('data-user-name')
               $('#modal_user_coin_id').val(data_user_coin_id)
               $('#modal_name').val(data_user_name)
            })
        })
    </script>
@endpush
