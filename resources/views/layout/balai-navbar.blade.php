<!--================Header Area =================-->
<header class="header_area navbar_fixed" style="position: fixed; width: 100%; z-index: 1000;">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="d-flex justify-content-between w-100">
                <!-- Logo aligned to the left -->
                <div class="navbar-brand logo_h">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/SebuSavvy.png') }}" style="width:50px; height:50px;" alt="Logo">
                    </a>
                </div>

                <!-- Right-side navigation items (Home, My Booking, User Icon) -->
                <div class="d-flex align-items-center">
                    <!-- Home link -->
                    <a href="{{ url('/') }}" class="nav-link font-semi-bold text-black">Home</a>

                    <!-- My Booking link (only for users with 'user' role) -->
                    @if (Auth::check() && Auth::user()->role === 'user')
                        <a href="{{ route('user.mybooking') }}" class="nav-link font-semi-bold text-black ms-3">My
                            Booking</a>
                    @endif

                    <!-- User Icon in the upper-right corner -->
                    <div class="nav-item submenu dropdown ms-3">
                        <a href="#" class="nav-link user-icon" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            @if (auth()->user() && auth()->user()->userInfo && auth()->user()->userInfo->profilePath)
                                <!-- Display the profile picture if it exists -->
                                <img src="{{ asset('storage/images/' . auth()->user()->userInfo->profilePath) }}"
                                    alt="Profile Picture" class="rounded-circle" width="40" height="40">
                            @else
                                <!-- Display the default user icon if no profile picture -->
                                <i class="fa fa-user"></i>
                            @endif
                        </a>

                        <ul class="dropdown-menu">
                            @if (Auth::check())
                                <li class="nav-item p-3" style="padding-left: 10%;">
                                    <strong style="font-weight: bold">{{ Auth::user()->name }}</strong><br>
                                    <span>{{ Auth::user()->email }}</span>
                                </li>

                                <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}"
                                        style="color: black;">Profile</a></li>
                                @if (Auth::check())
                                    @php
                                        $dashboardRoutes = [
                                            'resort' => 'resort.dashboard',
                                            'admin' => 'admin.dashboard',
                                        ];
                                    @endphp

                                    @if (array_key_exists(Auth::user()->role, $dashboardRoutes))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route($dashboardRoutes[Auth::user()->role]) }}"
                                                style="color: black;">
                                                Dashboard
                                            </a>
                                        </li>
                                    @endif
                                @endif


                                <li class="nav-item">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="nav-link" style="color: black;" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            @else
                                <li class="nav-item"><a class="nav-link" style="color: black;"
                                        href="{{ route('login') }}">Login</a></li>
                                <li class="nav-item"><a class="nav-link" style="color: black;"
                                        href="{{ route('user.register') }}">Register</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<style>
    /* Make the dropdown visible on hover */
    .nav-item.submenu:hover .dropdown-menu {
        display: block;
    }

    /* Ensure the dropdown is positioned correctly */
    .dropdown-menu {
        display: none;
        /* Hide by default */
        position: absolute;
        right: 0;
        /* Align with the right side */
        top: 100%;
        /* Ensure it shows below the icon */
        background-color: white;
        /* Background color for dropdown */
        min-width: 200px;
        /* Adjust as needed */
        z-index: 1000;
        /* Ensure dropdown appears on top */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        /* Optional shadow for visual appeal */
    }

    .nav-link.font-semi-bold.text-black {
        color: black;
        font-weight: 600;
        /* Semi-bold */
    }

    @media (max-width: 767px) {
        .header_area {
            display: none;
        }
    }
</style>







<!-- Mobile Navbar -->
<nav class="navbar fixed-bottom navbar-light bg-light d-block d-lg-none">
    <ul class="nav justify-content-around w-100">
        <li class="nav-item text-center">
            <a href="{{ url('/') }}" class="nav-link text-black">
                <i class="fa fa-home" style="color: black;"></i>
                <div style="font-size: 12px; color: black;">Home</div>
            </a>
        </li>

        <li class="nav-item text-center position-relative">
            <a href="{{ route('chatlist') }}" class="nav-link text-black">
                <i class="fa fa-envelope" style="color: black;"></i>
                <div style="font-size: 12px; color: black;">Message</div>
                @if ($unreadCount > 0)
                    <span class="badge bg-danger text-white rounded-circle"
                        style="
                            position: absolute;
                            top: 11px;
                            right: 30px;
                            font-size: 10px;
                            padding: 2px 5px;
                            transform: translate(50%, -50%);
                        ">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
        </li>


        <li class="nav-item text-center">
            <a href="{{ route('user.mybooking') }}" class="nav-link text-black">
                <i class="fa fa-calendar-check" style="color: black;"></i>
                <div style="font-size: 12px; color: black;">My Booking</div>
            </a>
        </li>

        <li class="nav-item text-center">
            <a href="{{ route('me.profile') }}" class="nav-link text-black">
                <i class="fa fa-user" style="color: black;"></i>
                <div style="font-size: 12px; color: black;">Me</div>
            </a>
        </li>
    </ul>
</nav>

<!--================Header Area =================-->
