@extends('layouts.app')
@section('title', 'Game Edit ')


@section('content')

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Game Edit</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('admin.game.index') }}" type="button" class="btn btn-primary btn-sm mb-3"><i
                                    class="fas fa-list"></i> Game List</a>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div>

                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label text-end">Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ old('name', $game->name) }}" readonly
                                            name="name" id="example-text-input">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="youtube_url" class="col-sm-3 col-form-label text-end">Youtube Url</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ old('youtube_url', $game->youtube_url??'') }}"
                                            name="youtube_url" id="youtube_url">
                                        @error('youtube_url')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="google_drive_url" class="col-sm-3 col-form-label text-end">Google Drive Url</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ old('google_drive_url', $game->google_drive_url??'') }}"
                                            name="google_drive_url" id="google_drive_url">
                                        @error('google_drive_url')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="microsoft_drive_url" class="col-sm-3 col-form-label text-end">Microsoft Drive Url</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ old('microsoft_drive_url', $game->microsoft_drive_url??'') }}"
                                            name="microsoft_drive_url" id="microsoft_drive_url">
                                        @error('microsoft_drive_url')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="row mb-3">
                                    <label class="col-md-3 my-1 control-label text-end">Status</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1"
                                                {{ old('status', $game->status) == '1' ? 'checked' : '' }}
                                                value="1">
                                            <label class="form-check-label" for="inlineRadio1">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inlineRadio2"
                                                {{ old('status', $game->status) == '0' ? 'checked' : '' }}
                                                value="0">
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
                            <div class="col-lg-12">
                                <div class="mb-3 row">
                                    <label for="" class="col-form-label ">Description for home page</label>
                                    <div class="col-sm-12">
                                        <textarea name="text" id="text" class="form-control" cols="30" rows="10">{{old('text',$game->text)}}</textarea>

                                        @error('text')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                            </div>




                            <div class="col-sm-12 text-end">
                                <button type="submit" class="btn btn-primary px-4">Update Game</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!-- end col -->

@endsection
@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#text',

        });
    </script>
@endpush
