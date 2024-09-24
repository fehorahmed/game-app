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
                            <a href="{{ route('admin.website.list') }}" type="button" class="btn btn-primary btn-sm mb-3"><i
                                    class="fas fa-list"></i> List</a>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div>

                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label text-end">Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" value="{{ old('name') }}"
                                            name="name" id="example-text-input">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="example-url-input" class="col-sm-3 col-form-label text-end">URL</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="url" value="{{ old('url') }}"
                                            name="url" id="example-url-input">
                                        @error('url')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="example-coin-input" class="col-sm-3 col-form-label text-end">Coin</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ old('coin') }}"
                                            name="coin" id="example-coin-input">
                                        @error('coin')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="mb-3 row">
                                    <label for="example-coin-input" class="col-sm-3 col-form-label text-end">Time (In
                                        Second)</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" value="{{ old('time') }}"
                                            name="time" id="example-coin-input">
                                        @error('time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                            </div> --}}

                            <div class="col-lg-6">

                                <div class="row mb-3">
                                    <label class="col-md-3 my-1 control-label text-end">Status</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1"
                                                {{ old('status') == '1' ? 'checked' : '' }} value="1">
                                            <label class="form-check-label" for="inlineRadio1">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inlineRadio2"
                                                {{ old('status') == '0' ? 'checked' : '' }} value="0">
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
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>url</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="website_name[]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="url[]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="time[]" class="form-control">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm">X</button>
                                        </td>
                                    </tr>
                                </table>
                                <div>
                                    <button class="btn btn-info">Add More</button>
                                </div>
                            </div>

                            <div class="col-sm-12 text-end">
                                <button type="submit" class="btn btn-primary px-4">Store Website</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!-- end col -->

    <template>
        <tr>
            <td>
                <input type="text" name="website_name[]" class="form-control">
            </td>
            <td>
                <input type="text" name="url[]" class="form-control">
            </td>
            <td>
                <input type="number" name="time[]" class="form-control">
            </td>
            <td>
                <button class="btn btn-danger btn-sm">X</button>
            </td>
        </tr>
    </template>
@endsection
