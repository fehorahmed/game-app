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
                        Website <span>Visit</span>
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
                            <th>Title</th>
                            <th>Coin</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($websites as $item)
                        <tr>
                            <td>
                                {{$item->name}}
                            </td>
                            <td> {{$item->coin}} </td>
                            <td>
                                <a target="_blank" href="{{$item->url}}?other_user={{auth()->id()}}&other_visiting_id={{$item->id}}&other_url={{ url()->current() }}" class="btn btn-info btn-sm">Visit</a>

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
