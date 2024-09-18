@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section style="background: #00204a;color:#ffffff;" class=" layout_padding">
        <div class="container  ">
            @if (session('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif
            <div style="flex-direction: row; " class="row heading_container  d-flex justify-content-between">
                    <h2>
                        Profile <span>Page</span>
                    </h2>
                    <div>
                        <a href="{{route('user.change_password')}}" class="btn btn-primary">Change Password</a>
                        <a href="{{route('user.referral_request')}}" class="btn btn-warning">Referral Request</a>
                    </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" readonly value="{{$user->name}}" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" readonly value="{{$user->email}}" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="numeric" name="mobile" readonly value="{{$user->mobile}}" class="form-control" id="mobile">
                    </div>
                     <div class="form-group">
                        <label for="mobile">User ID</label>
                        <input type="numeric" name="user_id" readonly value="{{$user->user_id}}" class="form-control" id="user_id">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="photo">Profile Photo</label>
                        <input type="file" name="photo"  class="form-control" id="photo">
                        @if ($user->photo)
                            <img src="{{asset('storage/'.$user->photo)}}" alt="" class="mt-2" height="200px" width="200px">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
