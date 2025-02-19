@extends('design.header')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div
            class="flex flex-col lg:flex-row gap-6 mt-10 bg-white dark:bg-gray-800 shadow-lg border border-gray-300 rounded-lg p-6 sm:p-8 w-full max-w-5xl">
            <!-- Room Details and Picture -->
            <div class="w-full lg:w-1/2">
                <h3 class="mb-4 text-xl font-bold leading-none text-gray-900 dark:text-white">Room Details</h3>
                <div class="mb-4">
                    <div id="carousel-{{ $room->id }}" class="carousel relative overflow-hidden rounded"
                        style="width:98%; height: 30rem;">
                        @foreach ($room->images as $index => $image)
                            <div
                                class="carousel-item absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out {{ $index == 0 ? 'opacity-100' : 'opacity-0' }}">
                                <img class="object-cover w-full h-full rounded"
                                    src="{{ asset('storage/images/' . $image->path) }}" alt="Room" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Room Name: {{ $room->name }}</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description:
                        {{ $room->description }}</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Room Price: ₱{{ $room->price }}</p>
                </div>


                <!-- Open Calendar Modal Button -->
                <button class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600" onclick="openCalendarModal()">
                    View Booking Calendar
                </button>

                <!-- Modal -->
                <div id="calendarModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg
               w-[95%] max-w-[1300px] h-[90vh] flex flex-col">

                        <!-- Modal Header -->
                        <div class="flex justify-between items-center border-b pb-3">
                            <h2 class="text-2xl font-bold">Room Booking Availability</h2>
                            <button class="text-gray-600 hover:text-gray-800" onclick="closeCalendarModal()">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Calendar and Event List Container -->
                        <div class="flex gap-4 flex-1 overflow-hidden mt-4">
                            <!-- Calendar -->
                            <div class="w-[60%] h-full">
                                <div id="bookingCalendar"></div>
                            </div>

                            <!-- Scrollable Event List with Dynamic Filtering -->
                            <div class="w-[55%] bg-gray-50 rounded-lg p-5 shadow-md">
                                <h3 class="text-lg font-bold mb-3 sticky top-0 bg-gray-50 py-2 border-b">Room Bookings List
                                </h3>
                                <div id="eventList" class="space-y-4 h-[600px] overflow-y-auto pr-3"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- FullCalendar CSS -->
                <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

                <style>
                    #calendarModal.hidden {
                        display: none;
                    }

                    #calendarModal:not(.hidden) {
                        display: block;
                    }

                    #bookingCalendar {
                        height: 100% !important;
                    }

                    .fc {
                        height: 100% !important;
                    }

                    .fc-event {
                        border-radius: 8px !important;
                        padding: 6px;
                        font-size: 0.9em;
                        color: white !important;
                        border: none !important;
                    }

                    /* Scrollable List Styling */
                    #eventList {
                        max-height: 600px;
                        overflow-y: auto;
                        scrollbar-width: thin;
                        scrollbar-color: #666 #f1f1f1;
                    }

                    #eventList::-webkit-scrollbar {
                        width: 8px;
                    }

                    #eventList::-webkit-scrollbar-track {
                        background: #f1f1f1;
                        border-radius: 10px;
                    }

                    #eventList::-webkit-scrollbar-thumb {
                        background: #666;
                        border-radius: 10px;
                    }
                </style>

                <!-- FullCalendar JS -->
                <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

                <script>
                    let bookings = @json($formattedBookings);
                    let calendar;

                    function openCalendarModal() {
                        document.getElementById('calendarModal').classList.remove('hidden');
                        renderCalendar();
                    }

                    function closeCalendarModal() {
                        document.getElementById('calendarModal').classList.add('hidden');
                    }

                    function renderCalendar() {
                        let calendarEl = document.getElementById('bookingCalendar');
                        if (!calendarEl.dataset.initialized) {
                            calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'dayGridMonth',
                                events: bookings.map(booking => ({
                                    title: booking.room_name,
                                    start: booking.check_in_date,
                                    end: booking.check_out_date,
                                    allDay: true,
                                    color: booking.color,
                                    className: "fc-event",
                                })),
                                headerToolbar: {
                                    left: 'prev',
                                    center: 'title',
                                    right: 'next'
                                },
                                height: '100%',
                                contentHeight: 'auto',
                                aspectRatio: 1.35,
                                datesSet: function(info) {
                                    updateBookingList(info.start, info.end);
                                }
                            });

                            calendar.render();
                            calendarEl.dataset.initialized = "true";
                        } else {
                            updateBookingList(calendar.view.currentStart, calendar.view.currentEnd);
                        }
                    }

                    function updateBookingList(startDate, endDate) {
                        let eventListContainer = document.getElementById('eventList');
                        eventListContainer.innerHTML = ""; // Clear previous bookings

                        let filteredBookings = bookings.filter(booking => {
                            let checkIn = new Date(booking.check_in_date);
                            return checkIn >= startDate && checkIn < endDate;
                        });

                        if (filteredBookings.length === 0) {
                            eventListContainer.innerHTML = "<p class='text-gray-500 text-center'>No bookings for this month.</p>";
                            return;
                        }

                        filteredBookings.forEach(booking => {
                            let bookingElement = document.createElement("div");
                            bookingElement.classList.add("p-4", "rounded-lg", "text-white", "shadow-md", "hover:shadow-lg",
                                "transition-shadow", "cursor-pointer");
                            bookingElement.style.backgroundColor = booking.color;

                            bookingElement.innerHTML = `
                <p class="text-lg font-semibold">${booking.room_name}</p>
                <p class="text-sm opacity-80">
                    ${formatDate(booking.check_in_date)} - ${formatDate(booking.check_out_date)}
                </p>
            `;

                            eventListContainer.appendChild(bookingElement);
                        });
                    }

                    function formatDate(dateString) {
                        let date = new Date(dateString);
                        return date.toLocaleDateString('en-US', {
                            weekday: 'long',
                            day: 'numeric',
                            month: 'long'
                        });
                    }
                </script>











            </div>

            <!-- Form and Stepper -->
            <div class="w-full lg:w-1/2">
                <!-- Stepper -->
                <div
                    class="p-4 bg-gray-50 justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <form id="first-step-form" action="{{ route('booking.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <!-- Display top-level error if the room is already booked -->
                        @if ($errors->has('check_in_date'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <p>{{ $errors->first('check_in_date') }}</p>
                            </div>
                        @endif

                        <div class="mt-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="text" id="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="contact_no" class="block text-gray-700">Contact Number</label>
                            <input type="number" id="contact_no" name="contact_no"
                                value="{{ old('contact_no', auth()->user()->userInfo->contactNo ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('contact_no')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="visitor" class="block text-gray-700">Number of Guests</label>
                            <input type="text" id="number_of_visitors" name="number_of_visitors"
                                value="{{ old('number_of_visitors') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('number_of_visitors')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="special_request" class="block text-gray-700">Special Request</label>
                            <h6 class="text-sm">Please specify any special requests or accommodations needed (e.g., dietary
                                restrictions, room location):</h6>
                            <input type="text" id="special_request" name="special_request"
                                value="{{ old('special_request') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('special_request')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="date-range-picker"
                            class="flex flex-col sm:flex-row items-center mt-4 space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="relative w-full sm:w-auto flex-1">
                                <label for="datepicker-range-start" class="block text-gray-700">Check-In Date</label>
                                <input id="datepicker-range-start" name="check_in_date" type="text"
                                    value="{{ old('check_in_date') }}" class="bg-gray-50 border rounded-lg pl-10 p-2.5"
                                    placeholder="Select Check-In date">
                                @error('check_in_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative w-full sm:w-auto flex-1 mt-2 sm:mt-0">
                                <label for="datepicker-range-end" class="block text-gray-700">Check-Out Date</label>
                                <input id="datepicker-range-end" name="check_out_date" type="text"
                                    value="{{ old('check_out_date') }}" class="bg-gray-50 border rounded-lg pl-10 p-2.5"
                                    placeholder="Select Check-Out date">
                                @error('check_out_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="payment"
                                class="block text-lg font-medium text-gray-700 dark:text-gray-300">Payment
                                Amount</label>
                            <input type="number" name="payment" id="payment"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                required>
                            @error('payment')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Proof
                                of Payment</label>
                            <input type="file" class="filepond" name="image" multiple credits="false" required />
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-center items-center space-x-5">
                            <button type="submit"
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                Submit
                            </button>
                            <a href="{{ url('/') }}" type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-white text-gray-700 hover:bg-red-700 hover:text-white disabled:opacity-50 disabled:pointer-events-none">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <script>
        function initCarousel(carouselId) {
            const items = document.querySelectorAll(`#${carouselId} .carousel-item`);
            const totalItems = items.length;

            if (totalItems === 0) return; // Guard clause to exit if no items are found

            let currentIndex = 0;

            function showNextImage() {
                items[currentIndex].classList.remove('opacity-100');
                items[currentIndex].classList.add('opacity-0');

                currentIndex = (currentIndex + 1) % totalItems;

                items[currentIndex].classList.remove('opacity-0');
                items[currentIndex].classList.add('opacity-100');
            }

            items[currentIndex].classList.add('opacity-100'); // Show the first image

            setInterval(showNextImage, 3000); // Change image every 3 seconds
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize each room carousel
            const carousels = @json($room->pluck('id')); // Use Laravel's pluck to get room IDs

            carousels.forEach(roomId => {
                initCarousel(`carousel-${roomId}`);
            });
        });
    </script>
@endsection
