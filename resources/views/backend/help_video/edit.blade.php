@extends('layouts.app')
@section('title', 'Slider Create ')


@section('content')

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Slider Create</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('config.home-slide.index') }}" type="button"
                                class="btn btn-primary btn-sm mb-3"><i class="fas fa-list"></i> Slider List</a>
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
                                        <input class="form-control" type="text" value="{{ old('title', $data->title) }}"
                                            name="title" id="example-text-input">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 my-1 control-label text-end">Status</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1"
                                                {{ old('status', $data->status) == '1' ? 'checked' : '' }} value="1">
                                            <label class="form-check-label" for="inlineRadio1">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inlineRadio2"
                                                {{ old('status', $data->status) == '0' ? 'checked' : '' }} value="0">
                                            <label class="form-check-label" for="inlineRadio2">Inactive</label>
                                        </div>
                                        @error('status')
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
                                        @if ($data->image)
                                            <img src="{{ asset($data->image) }}" alt="" height="50" class="mt-2">
                                        @endif

                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <div class="mb-3 row">
                                    <label for="content" class="col-form-label">Content</label>
                                </div>

                                <textarea name="content" id="content" cols="30" rows="10">{{ old('content', $data->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-sm-12 text-end mt-2">
                                <button type="submit" class="btn btn-primary px-4">Store Slide</button>
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