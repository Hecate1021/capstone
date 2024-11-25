@extends('design.header')

@section('content')
    @include('design.navbar')
    @include('design.sidebar')

    <div class="p-6 sm:ml-64 mt-10">
        <div class="bg-white p-8 rounded-lg shadow-lg dark:border-gray-700 dark:bg-gray-900">
            <div class="mb-8">
                <h2 class="text-3xl font-semibold text-gray-800 dark:text-white">Booking Details</h2>
            </div>
            <form action="{{ route('booking.accept', $booking->id) }}" method="POST" enctype="multipart/form-data"
                class="w-full max-w-2xl mx-auto space-y-6">
                @csrf
                @method('PATCH')

                <!-- Room Name -->
                <div>
                    <label for="room_name" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Room Name</label>
                    <input type="text" value="{{ $booking->room->name }}" name="room_name" id="room_name"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                        readonly>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" value="{{ $booking->name }}" name="name" id="name"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                        readonly>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" value="{{ $booking->email }}" name="email" id="email"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                        readonly>
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_no" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Contact Number</label>
                    <input type="text" value="{{ $booking->contact_no }}" name="contact_no" id="contact_no"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                        readonly>
                </div>
                <div>
                    <label for="number_of_visitors" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Number of Guest</label>
                    <input type="text" value="{{ $booking->number_of_visitors }}" name="number_of_visitors" id="number_of_visitors"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                        readonly>
                </div>
                <div>
                    <label for="request" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Special Request</label>
                    <input type="text" value="{{ $booking->request }}" name="request" id="request"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                        readonly>
                </div>

                <!-- Check-in and Check-out Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="check_in_date" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Check in Date</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M-d-Y') }}" name="check_in_date" id="check_in_date"
                            class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                            readonly>
                    </div>
                    <div>
                        <label for="check_out_date" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Check out Date</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M-d-Y') }}" name="check_out_date" id="check_out_date"
                            class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                            readonly>
                    </div>
                </div>

                <!-- Payment Amount -->
                <div>
                    <label for="payment-3" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Payment Amount</label>
                    <input type="number" value="{{ $booking->payment }}" name="payment-3" id="payment-3"
                        class="mt-2 block w-full rounded-md border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-4 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                        readonly>
                </div>

                <!-- Payment Picture -->
                <div class="mb-4">
                    <label for="payment_picture" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Payment Picture</label>
                    <button type="button" data-twe-toggle="modal" data-twe-target="#exampleModalCenter" class="mt-2">
                        <img src="{{ $booking->paymentRecord && $booking->paymentRecord->payment_path ? asset('storage/' . $booking->paymentRecord->payment_path) : asset('images/lake-sebu.jpg') }}"
                            alt="No Payment Screenshot"
                            class="w-40 h-40 rounded-lg shadow-md object-cover border border-gray-300 dark:border-gray-700">
                    </button>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="window.history.back()"
                        class="px-6 py-3 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Accept</button>
                </div>
            </form>
        </div>
    </div>

     <!-- Image Modal -->
     <div data-twe-modal-init
     class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
     id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
     <div data-twe-modal-dialog-ref
         class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
         <div
             class="pointer-events-auto m-5 relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
             <img src="{{ $booking->paymentRecord && $booking->paymentRecord->payment_path ? asset('storage/' . $booking->paymentRecord->payment_path) : asset('images/lake-sebu.jpg') }}"
                 alt="No Payment Screenshot"
                 class=" w-full h-[450px] sm:h-[400px] md:h-[500px] lg:h-[600px] xl:h-[700px] rounded-lg shadow-md object-cover border border-gray-200 dark:border-gray-700">
         </div>
     </div>
 </div>
@endsection
