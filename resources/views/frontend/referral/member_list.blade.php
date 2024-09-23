@extends('frontend.layouts.app')

@section('content')
    <!-- about section -->

    <section style="background: #00204a;color:#ffffff;" class=" layout_padding">
        <div class="container  ">
            @if (session('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif
            @if (session('error'))
                <p class="alert alert-danger">{{session('error')}}</p>
            @endif
            <div style="flex-direction: row; " class="row heading_container  d-flex justify-content-between">
                    <h2>
                        Member <span>List</span>
                    </h2>
                    {{-- <div>
                        <p>Your total referral : {{$total_ref}}</p>
                    </div> --}}

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
                        @foreach ($users as $item)
                        <tr>
                            <td>
                                Name : {{$item->name}} <br>
                                Email : {{$item->email}}
                            </td>
                            <td> {{$item->user_id}} </td>
                            <td>
                                <a href="{{route('user.referral_member_detail',$item->id)}}" class="btn btn-info btn-sm">Details</a>

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
