<header class="header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span>
                    {{ env('APP_NAME') }}
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  ">


                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                    </li>

                    @auth('appuser')
                        <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard
                                {{-- <span class="sr-only">(current)</span> --}}
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('user.deposit') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.deposit') }}">Deposit</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('user.withdraw') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.withdraw') }}">Withdraw</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.profile') }}">Profile</a>
                        </li>
                        <li class="nav-item">

                            <form action="{{ route('appuser.logout') }}" method="POST">
                                @csrf
                                <input type="submit" value="LOG OUT">
                            </form>
                        </li>
                    @else

                        <li class="nav-item">
                            <a class="nav-link" href="about.html"> About</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('user.login') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.login') }}"> <i class="fa fa-user"
                                    aria-hidden="true"></i>
                                Sing In</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('user.register') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.register') }}"> <i class="fa fa-user"
                                    aria-hidden="true"></i>
                                Sing Up</a>
                        </li>
                    @endauth

                    {{-- <form class="form-inline">
                        <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </form> --}}
                </ul>
            </div>
        </nav>
    </div>
</header>
