@extends('layout.header')
@section('content')
    @include('layout.balai-navbar')

    <div class="container mt-3">
        <!-- Profile and Login/Sign Up or User Info -->
        <div class="profile-section d-flex align-items-center p-3">
            @if(auth()->check() && auth()->user()->userInfo && auth()->user()->userInfo->profilePath)
                <!-- Display the profile picture if it exists -->
                <img src="{{ asset('storage/images/' . auth()->user()->userInfo->profilePath) }}" alt="Profile Picture" class="profile-picture" style="width: 100px; height: 100px; border-radius: 50%;">
            @else
                <!-- Default profile icon if no profile picture -->
                <i class="fas fa-user-circle fa-3x"></i>
            @endif
            <div class="user-info ml-3">
                <h6 class="font-weight-bold" style="font-size: 1.25em;">{{ auth()->user()->name }}</h6>
                <p class="" style="font-size: 1.1em; color:#fff;">{{ auth()->user()->email }}</p>
            </div>
        </div>


       <!-- Main Menu -->
<div class="menu-section">
    <a href="{{route('profile.edit')}}" class="menu-item">
        <i class="fas fa-user"></i>
        <span>My Profile</span>
    </a>
    <a href="{{ route('user.mybooking') }}" class="menu-item">
        <i class="fas fa-calendar-check"></i>
        <span>My Booking</span>
    </a>
</div>

        <!-- Logout Button -->
        <div class="logout-section">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-block">Log Out</button>
            </form>
        </div>
    </div>

    <style>
        /* Profile Section */
        .profile-section {
            background-color: #b0b0b0;
            color: white;
        }
        .profile-icon {
            font-size: 2.5em;
        }

        /* User Info Styling */
        .user-info .user-name {
            font-size: 1.3em; /* Larger font size for name */
            font-weight: bold; /* Bold font for name */
        }
        .user-info .user-email {
            font-size: 1em;
            color: #f0f0f0; /* Lighter color for email */
        }

        /* Custom styles for Log In and Sign Up buttons */
        .custom-login-btn {
            border: 1px solid white; /* White border */
            color: white; /* White font color */
        }

        .custom-login-btn:hover {
            background-color: white;
            color: #ff5722; /* Match background color */
            border: 1px solid #ff5722;
        }

        .custom-signup-btn {
            background-color: #fff;
            color: #b0b0b0; /* Gray font color */
            border: none;
        }

        .custom-signup-btn:hover {
            background-color: white;
            color: #ff5722; /* Match background color */
            border: 1px solid #ff5722;
        }

        /* Menu Section */
        .menu-section {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #ddd;
        }
        .menu-item i {
            font-size: 1.5em;
            margin-right: 15px;
        }
        .menu-item span {
            font-size: 1.1em;
        }

        /* Logout Section */
        .logout-section {
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }
        .logout-section .btn-block {
            width: 100%; /* Full width */
        }
    </style>

@endsection
