@extends('layouts.app')
@section('title', 'App User View')

@push('styles')
    <!-- Include DataTables CSS -->
@endpush
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="met-profile">
                        <div class="row">
                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                <div class="met-profile-main">
                                    <div class="met-profile-main-pic">
                                        @if ($appUser->photo)
                                            <img src="{{ asset('storage/' . $appUser->photo) }}" alt=""
                                                height="110" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('assets/images/users/user-4.jpg') }}" alt=""
                                                height="110" class="rounded-circle">
                                        @endif


                                        <span class="met-profile_main-pic-change">
                                            <i class="fas fa-camera"></i>
                                        </span>
                                    </div>
                                    <div class="met-profile_user-detail">
                                        <h5 class="met-user-name">{{ $appUser->name }}</h5>
                                        {{-- <p class="mb-0 met-user-name-post">UI/UX Designer, India</p> --}}
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-4 ms-auto align-self-center">
                                <ul class="list-unstyled personal-detail mb-0">
                                    <li class=""><i class="las la-phone mr-2 text-secondary font-22 align-middle"></i>
                                        <b> phone </b> : {{ $appUser->mobile ?? '' }}
                                    </li>
                                    <li class="mt-2"><i
                                            class="las la-envelope text-secondary font-22 align-middle mr-2"></i> <b> Email
                                        </b> : {{ $appUser->email ?? '' }}</li>
                                    <li class="mt-2"><i class="las la-globe text-secondary font-22 align-middle mr-2"></i>
                                        <b> User ID </b> : {{ $appUser->user_id ?? '' }}
                                    </li>
                                </ul>

                            </div><!--end col-->
                            <div class="col-lg-4 align-self-center">
                                <div class="row">
                                    <div class="col-auto text-end border-end">

                                        <p class="mb-0 fw-semibold">Balance (TK)</p>
                                        <h4 class="m-0 fw-bold">{{ $appUser->balance->balance ?? '' }} </h4>
                                        <hr>
                                        <p class="mb-0 fw-semibold">Balance (Coin)</p>
                                        <h4 class="m-0 fw-bold">{{ $appUser->coin->coin ?? '' }} </h4>
                                    </div><!--end col-->
                                    <div class="col-auto">

                                        <p class="mb-0 fw-semibold">Status</p>
                                        <h4 class="m-0 fw-bold">{{ $appUser->status == 1 ? 'Active' : 'Inactive' }}</h4>
                                        <hr>
                                        <p class="mb-0 fw-semibold">Balance (STAR)</p>
                                        <h4 class="m-0 fw-bold">{{ $appUser->balance->star ?? '' }} </h4>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end f_profile-->
                </div><!--end card-body-->
                <div class="card-body p-0">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#Post" role="tab"
                                aria-selected="true">DEPOSIT HISTORY</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Gallery" role="tab"
                                aria-selected="false">WITHDRAW HISTORY</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Settings" role="tab"
                                aria-selected="false">GOLD COIN HISTORY</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane p-3 active" id="Post" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Method</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                                @foreach ($deposites as $deposit)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $deposit->method->name ?? '' }}</td>
                                                        <td>{{ $deposit->deposit_date }}</td>
                                                        <td>{{ $deposit->amount }}</td>
                                                        <td>
                                                            @if ($deposit->status == 1)
                                                                <button class="btn btn-info btn-sm">Pending</button>
                                                            @endif
                                                            @if ($deposit->status == 2)
                                                                <button class="btn btn-success btn-sm">Approved</button>
                                                            @endif
                                                            @if ($deposit->status == 0)
                                                                <button class="btn btn-danger btn-sm">Cancel</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            {{-- <div class="pagination">
                                                {{ $deposites->links('pagination::bootstrap-4') }}
                                            </div> --}}
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>
                        <div class="tab-pane p-3" id="Gallery" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Method</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                                @foreach ($withdraws as $deposit)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $deposit->method->name ?? '' }}</td>
                                                        <td>{{ $deposit->withdraw_date }}</td>
                                                        <td>{{ $deposit->amount }}</td>
                                                        <td>
                                                            @if ($deposit->status == 1)
                                                                <button class="btn btn-info btn-sm">Pending</button>
                                                            @endif
                                                            @if ($deposit->status == 2)
                                                                <button class="btn btn-success btn-sm">Approved</button>
                                                            @endif
                                                            @if ($deposit->status == 0)
                                                                <button class="btn btn-danger btn-sm">Cancel</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            {{-- <div class="pagination">
                                                {{ $deposites->links('pagination::bootstrap-4') }}
                                            </div> --}}
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>
                        <div class="tab-pane p-3" id="Settings" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Source</th>
                                                    <th>Coin Type</th>
                                                    <th>Coin</th>

                                                </tr>
                                                @foreach ($user_coin_details as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->source ?? '' }}</td>
                                                        <td>{{ $data->coin_type ?? '' }}</td>
                                                        <td>{{ $data->coin }}</td>

                                                    </tr>
                                                @endforeach
                                            </table>
                                            {{-- <div class="pagination">
                                                {{ $deposites->links('pagination::bootstrap-4') }}
                                            </div> --}}
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>
                    </div>
                </div> <!--end card-body-->

            </div><!--end card-->
        </div><!--end col-->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Member List</h4>

                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Balance</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_members as $user)
                                    <tr>
                                        <td>
                                            @if ($user->photo)
                                                <img src="{{ asset('storage/' . $user->photo) }}" alt=""
                                                    class="rounded-circle thumb-xs me-1">
                                            @endif
                                            {{ $user->name }}
                                        </td>
                                        <td>{{ $user->user_id }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>

                                            Taka : {{ $user->balance->balance ?? 0 }} TK <br>
                                            Star : {{ $user->balance->star ?? 0 }} <br>
                                            Coin : {{ number_format($user->coin->coin ?? 0) }} <br>

                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('app_user.view', $user->id) }}"
                                                class="btn btn-secondary btn-sm">View</a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table><!--end /table-->
                    </div><!--end /tableresponsive-->
                </div><!--end card-body-->
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection

@push('scripts')
@endpush
