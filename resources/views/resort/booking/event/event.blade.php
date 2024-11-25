@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')

    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <!-- Add Booking Button -->
            <!-- Add Booking Button -->
            <!-- Add Booking Button -->
            <!-- Add Booking Button -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openEventBookingModal()">
                Add Booking
            </button>

            <!-- Full-Page Modal Structure -->
            <div id="bookingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden"
                onclick="closeEventBookingModal(event)">
                <div class="bg-white w-full max-w-md max-h-[90vh] overflow-hidden rounded-lg shadow-lg flex flex-col"
                    onclick="event.stopPropagation()">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b p-4">
                        <h2 class="text-xl font-semibold">Add Booking</h2>
                        <button class="text-gray-600 hover:text-gray-800" onclick="closeEventBookingModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body (Scrollable Content) -->
                    <div class="flex-1 p-4 overflow-y-auto">
                        <form method="POST" action="{{ route('eventBooking.store') }}" enctype="multipart/form-data"
                            class="space-y-4">
                            @csrf
                            <input type="hidden" name="resort_id" value="{{ Auth::user()->id }}">

                            <!-- Event Dropdown -->
                            <div class="mb-4">
                                <label for="event_id" class="block text-sm font-medium text-gray-700">Select Event</label>
                                <select name="event_id" id="event_id"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                    <option value="" data-price="">-- Select Event --</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}" data-price="{{ $event->price }}"
                                            {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                            {{ $event->event_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('event_id'))
                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('event_id') }}</p>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="event_price" class="block text-sm font-medium text-gray-700">Event Price</label>
                                <input type="text" name="event_price" id="event_price" value="{{ old('event_price') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required readonly>
                            </div>

                            <script>
                                document.getElementById('event_id').addEventListener('change', function() {
                                    // Get the selected option
                                    const selectedOption = this.options[this.selectedIndex];
                                    // Get the event price from the selected option's data-price attribute
                                    const eventPrice = selectedOption.getAttribute('data-price');
                                    // Set the value of the event price input
                                    document.getElementById('event_price').value = eventPrice ? eventPrice : '';
                                });
                            </script>

                            <!-- Name Input -->
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $errors->has('name') ? 'border-red-500' : '' }}"
                                    required>
                                @if ($errors->has('name'))
                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                                @endif
                            </div>

                            <!-- Email Input -->
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $errors->has('email') ? 'border-red-500' : '' }}"
                                    required>
                                @if ($errors->has('email'))
                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                                @endif
                            </div>

                            <!-- Contact Input -->
                            <div class="mb-4">
                                <label for="contact" class="block text-sm font-medium text-gray-700">Contact Number</label>
                                <input type="number" name="contact" id="contact" value="{{ old('contact') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $errors->has('contact') ? 'border-red-500' : '' }}"
                                    required>
                                @if ($errors->has('contact'))
                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('contact') }}</p>
                                @endif
                            </div>

                            <!-- Payment Input -->
                            <div class="mb-4">
                                <label for="payment" class="block text-sm font-medium text-gray-700">Payment</label>
                                <input type="number" name="payment" id="payment" value="{{ old('payment') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $errors->has('payment') ? 'border-red-500' : '' }}"
                                    required>
                                @if ($errors->has('payment'))
                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('payment') }}</p>
                                @endif
                            </div>

                            <!-- Image Input -->
                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image
                                    (Optional)</label>
                                <input type="file" class="filepond" name="image" multiple credits="false" />
                                @if ($errors->has('image'))
                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('image') }}</p>
                                @endif
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                    onclick="closeEventBookingModal()">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Save Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- JavaScript for Modal Functionality -->
            <script>
                function openEventBookingModal() {
                    document.getElementById('bookingModal').classList.remove('hidden');
                }

                function closeEventBookingModal(event) {
                    if (event) {
                        event.stopPropagation(); // Prevents closing if clicking inside modal
                    }
                    document.getElementById('bookingModal').classList.add('hidden');
                }

                // Reopen the modal if there are validation errors
                @if ($errors->any())
                    openEventBookingModal();
                @endif
            </script>


            <div class="overflow-x-auto mt-5">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Event Name</th>
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Contact Number</th>
                            <th class="py-3 px-6 text-left">Payment</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($bookings as $booking)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left ">{{ $booking->event->event_name }}</td>
                                <td class="py-3 px-6 text-left ">{{ $booking->name }}</td>
                                <td class="py-3 px-6 text-left">{{ $booking->email }}</td>
                                <td class="py-3 px-6 text-left">{{ $booking->contact }}</td>
                                <td class="py-3 px-6 text-left">{{ $booking->payment }}</td>
                                <td class="py-3 px-6 text-left"><span
                                        class="{{ $booking->status == 'Accept' ? 'bg-green-500' : ($booking->status == 'Pending' ? 'bg-orange-500' : ($booking->status == 'Cancel' ? 'bg-red-500' : ($booking->status == 'Check Out' ? 'bg-yellow-500' : ''))) }} rounded-full p-1 text-sm text-white">
                                        {{ $booking->status }}
                                    </span></td>
                                <td class="py-3 px-6 text-left">
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
                                                <a href="{{ route('eventBooking.show', $booking->id) }}"
                                                    class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                                    <p class="text-xs">Details</p>
                                                </a>
                                            @else
                                                <a href="{{ route('eventBooking.show', $booking->id) }}"
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
                                                <a href="{{ route('eventBooking.checkout', $booking->id) }}"
                                                    class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                                    <i class="fa fa-sign-out fa-lg"></i>
                                                    <p class="text-xs">Check Out</p>
                                                </a>
                                            @endif
                                        </div>
                                        <!-- Cancel button -->
                                        @if ($booking->status == 'Cancel')
                                            <!-- Modal Trigger Button -->
                                            <button disabled class="text-gray-400 cursor-not-allowed opacity-50"
                                                aria-label="Cancel">
                                                <i class="fa fa-times-circle fa-lg"></i>
                                                <p class="text-xs">Cancel</p>
                                            </button>
                                        @else
                                            <button data-modal-target="cancel-modal-{{ $booking->id }}"
                                                data-modal-toggle="cancel-modal-{{ $booking->id }}"
                                                class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white"
                                                aria-label="Cancel">
                                                <i class="fa fa-times-circle fa-lg"></i>
                                                <p class="text-xs">Cancel</p>
                                            </button>
                                        @endif










                                        <!-- Print Icon -->
                                        <div>
                                            <a href="{{ route('event.registration', $booking->id) }}"
                                                class="text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                                <i class="fa fa-print fa-lg"></i>
                                                <p class="text-xs">Print</p>
                                            </a>
                                        </div>
                                    </div>

                                </td>
                            </tr>

                            <!-- Cancel Booking Modal -->
                            <div id="cancel-modal-{{ $booking->id }}"
                                class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
                                <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
                                    <h2 class="text-lg font-semibold mb-4">Cancel Booking</h2>
                                    <p class="mb-2">Please provide a reason for cancellation:</p>
                                    <form action="{{ route('eventBooking.cancel', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH') <!-- This will convert the POST request to PATCH -->
                                        <textarea id="reason" name="reason" rows="4" class="w-full p-2 border rounded"
                                            placeholder="Enter your reason..." required></textarea>

                                        <div class="mt-4 flex justify-end">
                                            <button type="button"
                                                class="mr-2 px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700"
                                                data-modal-hide="cancel-modal-{{ $booking->id }}">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                                                Confirm
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
