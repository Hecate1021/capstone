@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')

    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="flex rounded h-12 dark:bg-gray-800">
                    <p class="text-2xl text-black dark:text-gray-500">Room Booking</p>
                </div>
                <div class="flex rounded h-12 dark:bg-gray-800 justify-end">
                    <div>
                        <a href="{{ route('addbooking') }}"
                            class="rounded bg-primary-600 p-2 mr-4 text-white bold hover:bg-primary-800">Add Booking</a>
                    </div>
                    <form id="status-filter-form" action="{{ route('resort.booking') }}" method="GET"
                        class="flex items-center">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status:</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="Accept" {{ request('status') == 'Accept' ? 'selected' : '' }}>Accept</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Cancel" {{ request('status') == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                <option value="Check Out" {{ request('status') == 'Check Out' ? 'selected' : '' }}>Check Out
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="items_per_page" class="block text-sm font-medium text-gray-700">Items per
                                page:</label>
                            <select name="items_per_page" id="items_per_page"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                onchange="this.form.submit()">
                                <option value="10" {{ $itemsPerPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $itemsPerPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="30" {{ $itemsPerPage == 30 ? 'selected' : '' }}>30</option>
                                <option value="40" {{ $itemsPerPage == 40 ? 'selected' : '' }}>40</option>
                                <option value="50" {{ $itemsPerPage == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex items-center justify-center mb-4 rounded bg-gray-50 dark:bg-gray-800 ">
                <div class="w-full ">
                    <!-- Booking Table -->
                    <table class="w-full table-auto" id="booking-table">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                <th class="w-1/12 py-2 px-2 text-left font-bold uppercase text-xs">Room Name</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Name</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Phone</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Payment</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Status</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Check In</th>
                                <th class="w-1/12 py-2 text-left font-bold uppercase text-xs">Check Out</th>
                                <th class="w-1/12 py-2 px-2 text-left font-bold uppercase text-xs"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach ($bookings as $booking)
                                <tr class="border-b border-gray-200 dark:border-gray-700"
                                    data-payment="{{ $booking->payment }}" data-room-price="{{ $booking->room->price }}">
                                    <td class="py-2 px-2 text-black dark:text-gray-300">{{ $booking->room->name }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">{{ $booking->name }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">{{ $booking->contact_no }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">{{ $booking->payment }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">
                                        <span
                                            class="{{ $booking->status == 'Accept' ? 'bg-green-500' : ($booking->status == 'Pending' ? 'bg-orange-500' : ($booking->status == 'Cancel' ? 'bg-red-500' : ($booking->status == 'Check Out' ? 'bg-yellow-500' : ''))) }} rounded-full p-1 text-sm text-white">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td class="py-2 text-black dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M-d-Y') }}</td>
                                    <td class="py-2 text-black dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M-d-Y') }}</td>
                                    <td class="py-2 text-black dark:text-gray-300 flex items-center space-x-4">

                                        <div class="flex space-x-4 text-center">
                                            <!-- Details Icon -->
                                            {{-- <div>
                                                    <a href="{{ route('bookings.show', $booking->id) }}" class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                                        <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                                        <p class="text-xs">Details</p>
                                                    </a>
                                                </div> --}}

                                            <!-- Accept Icon -->
                                            <div>
                                                @if ($booking->status == 'Accept')
                                                    <a href="{{ route('bookings.show', $booking->id) }}"
                                                        class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                                        <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                                        <p class="text-xs">Details</p>
                                                    </a>
                                                @else
                                                    <a href="{{ route('bookings.show', $booking->id) }}"
                                                        class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                                        <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                                        <p class="text-xs">Details</p>
                                                    </a>
                                                @endif
                                            </div>

                                            <!-- Check Out Icon -->
                                            <div>
                                                @if ($booking->status == 'Check Out')
                                                    <button disabled class="text-gray-400 cursor-not-allowed opacity-50">
                                                        <i class="fa fa-sign-out fa-lg"></i>
                                                        <p class="text-xs">Check Out</p>
                                                    </button>
                                                @else
                                                    <a href="{{ route('bookings.checkout', $booking->id) }}"
                                                        class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                                        <i class="fa fa-sign-out fa-lg"></i>
                                                        <p class="text-xs">Check Out</p>
                                                    </a>
                                                @endif
                                            </div>
                                            <!-- Cancel button -->
                                            @if ($booking->status == 'Cancel')
                                            <!-- Modal Trigger Button -->
                                            <button disabled
                                                class="text-gray-400 cursor-not-allowed opacity-50"
                                                onclick="openModal({{ $booking->id }})">
                                                <i class="fa fa-times-circle fa-lg"></i>
                                                <p class="text-xs">Cancel</p>
                                            </button>
                                            @else
                                            <button
                                            class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white"
                                            onclick="openModal({{ $booking->id }})">
                                            <i class="fa fa-times-circle fa-lg"></i>
                                            <p class="text-xs">Cancel</p>
                                             </button>
                                            @endif
                                            <!-- Modal background -->
                                            <div id="myModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                                                <div class="flex items-center justify-center min-h-screen">
                                                    <!-- Modal overlay -->
                                                    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 transition-opacity">
                                                    </div>

                                                    <!-- Modal content -->
                                                    <div
                                                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                                                        <div class="bg-gray-100 px-4 py-3 flex justify-between">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900">Cancel
                                                                Booking</h3>
                                                            <button class="text-gray-400 hover:text-gray-600"
                                                                onclick="closeModal()">×</button>
                                                        </div>
                                                        <form action="{{ route('cancelBooking', 'BOOKING_ID') }}"
                                                            method="POST" id="cancelForm">
                                                            @csrf
                                                            <div class="bg-white px-4 py-6">
                                                                <p class="text-sm text-gray-700 mb-4">Are you sure you want
                                                                    to cancel this booking?</p>

                                                                <!-- Hidden input for booking ID -->
                                                                <input type="hidden" name="booking_id" id="bookingId"
                                                                    value="">

                                                                <!-- Reason input -->
                                                                <label for="reason"
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Reason
                                                                    for Cancellation</label>
                                                                <textarea id="reason" name="reason" rows="3"
                                                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                                                    placeholder="Enter your reason..."></textarea>
                                                            </div>
                                                            <div class="bg-gray-100 px-4 py-3 sm:flex sm:flex-row-reverse">
                                                                <button type="submit"
                                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-2 sm:mb-0 sm:ml-2">Cancel
                                                                    Booking</button>
                                                                <button type="button"
                                                                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded"
                                                                    onclick="closeModal()">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>



                                            <script>
                                                function openModal(bookingId) {
                                                    // Set the booking ID in the hidden input field
                                                    document.getElementById("bookingId").value = bookingId;

                                                    // Update the form action to include the booking ID in the route
                                                    document.getElementById("cancelForm").action = `{{ route('cancelBooking', '') }}/${bookingId}`;

                                                    // Show the modal
                                                    document.getElementById("myModal").classList.remove("hidden");
                                                }

                                                function closeModal() {
                                                    // Hide the modal
                                                    document.getElementById("myModal").classList.add("hidden");
                                                }
                                            </script>




                                            <!-- Print Icon -->
                                            <div>
                                                <a href="{{ route('registration', $booking->id) }}"
                                                    class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                                    <i class="fa fa-print fa-lg"></i>
                                                    <p class="text-xs">Print</p>
                                                </a>
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div
                        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <span class="flex items-center col-span-3">
                            Showing {{ $bookings->firstItem() }}-{{ $bookings->lastItem() }} of {{ $bookings->total() }}
                        </span>
                        <span class="col-span-2"></span>
                        <!-- Pagination -->
                        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                            {{ $bookings->links('vendor.pagination.tailwind') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
