@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section style="background: #00204a;color:#ffffff;" class=" layout_padding">
        <div class="container  ">
            @include('frontend.layouts.message')
            <div style="flex-direction: row; " class="row heading_container  d-flex justify-content-between">
                <h2>
                    Change <span>Password</span>
                </h2>

            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 ">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="present_password">Enter Present Password</label>
                            <input type="password" name="present_password" class="form-control" id="present_password">
                            @error('present_password')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Enter New Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                            @error('password')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                            @error('password_confirmation')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <button role="submit" class="btn btn-primary">Change Password</button>
                        </div>

                    </form>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
