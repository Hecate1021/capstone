@extends('design.header')

@section('content')
    @include('design.navbar')
    @include('design.sidebar')

    <div class="p-4 sm:ml-64 mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg dark:border-gray-700 dark:bg-gray-900">
            <div class="mb-4">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Booking Details</h2>
            </div>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg dark:bg-red-900 dark:text-red-400 dark:border-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="bookingForm" action="{{ route('addbooking.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-lg mx-auto">
                @csrf
                @method('POST')
                <div class="space-y-4">
                    <!-- Room Name -->
                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room Name</label>
                        <select name="room_id" id="room_id"
                            class="mt-1 border block w-full rounded-md border-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                            required>
                            <option value="" disabled selected>Select a room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" value="{{ old('name') }}" name="name" id="name"
                            class="mt-1 block w-full rounded-md border-gray-400 border shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                            required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" value="{{ old('email') }}" name="email" id="email"
                            class="mt-1 block w-full rounded-md border-gray-400 border shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                            required>
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="contact_no" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Number</label>
                        <input type="text" value="{{ old('contact_no') }}" name="contact_no" id="contact_no"
                            class="mt-1 block w-full rounded-md border-gray-400 border shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                            required>
                    </div>

                    <!-- Number of Visitors -->
                    <div>
                        <label for="number_of_visitors" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Visitors</label>
                        <input type="text" value="{{ old('number_of_visitors') }}" name="number_of_visitors" id="number_of_visitors"
                            class="mt-1 block w-full rounded-md border-gray-400 border shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                            required>
                    </div>

                    <!-- Dates -->
                    <div id="date-range-picker"
                            class="flex flex-col sm:flex-row items-center mt-4 space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="relative w-full sm:w-auto flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 mt-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <label for="datepicker-range-start" class="block text-gray-700 dark:text-gray-400">Check-In Date</label>
                            <input id="datepicker-range-start" name="check_in_date" type="text"
                                value="{{ old('check_in_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select Check-In date">
                        </div>
                        <div class="relative w-full sm:w-auto flex-1 mt-2 sm:mt-0">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 mt-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <label for="datepicker-range-end" class="block text-gray-700 dark:text-gray-400">Check-Out Date</label>
                            <input id="datepicker-range-end" name="check_out_date" type="text"
                                value="{{ old('check_out_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select Check-Out date">
                        </div>
                    </div>

                    <!-- Payment Amount -->
                    <div>
                        <label for="payment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Amount</label>
                        <input type="number" value="{{ old('payment') }}" name="payment" id="payment"
                            class="mt-1 block w-full rounded-md border-gray-400 border shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                            required>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" onclick="window.location.href='{{ route('resort.booking') }}'"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-sm">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
