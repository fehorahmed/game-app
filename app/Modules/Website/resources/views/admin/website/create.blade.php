@extends('layouts.app')
@section('title', 'Website Create ')


@section('content')

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Website Create</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{route('admin.website.create')}}" type="button" class="btn btn-primary btn-sm mb-3">Create Website</button>
                        </div><!--end col-->
                    </div>  <!--end row-->
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
