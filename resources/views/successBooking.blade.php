
@extends('design.header')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <div class="flex justify-center mb-4">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-pink-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 0a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
            </svg>
        </div>
        <h2 class="text-center text-2xl font-semibold text-gray-800">Thank you</h2>
        <p class="text-center text-gray-600 mt-2">Your submission has been received.<br>We will be in touch and
            contact you soon!</p>
            <div class="mt-6 flex justify-center space-x-4">
                <!-- Home Button -->
                <a href="/" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Home
                </a>

                <!-- My Booking Button -->
                <a href="{{ route('user.mybooking') }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                    My Booking
                </a>
            </div>
    </div>
</div>

@endsection
