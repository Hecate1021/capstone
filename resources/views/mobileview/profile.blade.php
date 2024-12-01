@extends('layout.header')
@section('content')
    @include('layout.balai-navbar')

    <div class="container mt-3">
        <!-- Profile and Login/Sign Up or User Info -->
        <div class="profile-section d-flex align-items-center p-3">
            @if(auth()->check())
                @if(auth()->user()->userInfo && auth()->user()->userInfo->profilePath)
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
            @else
                <i class="fas fa-user-circle fa-3x"></i>
                <div class="user-info ml-3">
                    <h6 class="font-weight-bold" style="font-size: 1.25em;"></h6>
                    <p class="" style="font-size: 1.1em; color:#fff;"></p>
                </div>
            @endif
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

      <!-- Authentication Button -->
<div class="auth-section mt-auto">
    @if(auth()->check())
        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button class="btn btn-danger btn-block">Log Out</button>
        </form>
    @else
        <!-- Login Button -->
        <a href="{{ route('login') }}" class="btn btn-primary btn-block">Log In</a>
    @endif
</div>

<style>
    /* Profile Section */
    .profile-section {
        background-color: #b0b0b0;
        color: white;
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
    .auth-section {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #f8f9fa; /* Background for the bottom section */
        padding: 15px;
        margin-bottom: 64px;
    }

    .auth-section .btn-block {
        width: 100%; /* Full width button */
    }
</style>

@endsection
