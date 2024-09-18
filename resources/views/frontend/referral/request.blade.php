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
                        Referral <span>Request</span>
                    </h2>
                    <div>
                        <p>Your total referral : {{$total_ref}}</p>
                    </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 ">
                    <table class="table table-dark">
                        <tr>
                            <th>User Info</th>
                            <th>User ID</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($r_requests as $item)
                        <tr>
                            <td>
                                Name : {{$item->appUser->name}} <br>
                                Email : {{$item->appUser->email}}
                            </td>
                            <td> {{$item->appUser->user_id}} </td>
                            <td>
                                <a href="" class="btn btn-info btn-sm">Accept</a>
                                <a href="" class="btn btn-danger btn-sm">Cancel</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>

            </div>
        </div>
    </section>

    <!-- end about section -->
@endsection
