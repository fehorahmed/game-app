@extends('layouts.app')
@section('title', 'App Banner Create ')


@section('content')

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">App Banner Create</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('config.app-banner.index') }}" type="button"
                                class="btn btn-primary btn-sm mb-3"><i class="fas fa-list"></i> List</a>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div>

                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="title" class="col-sm-3 col-form-label text-end">Title</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ old('title') }}"
                                            name="title" id="example-text-input">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="image" class="col-sm-3 col-form-label text-end">image</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="image" id="image">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12 text-end mt-2">
                                <button type="submit" class="btn btn-primary px-4">Store Banner</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!-- end col -->


    </div> <!-- end row -->
@endsection

@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#content',

        });
    </script>
@endpush
