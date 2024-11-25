@extends('design.header')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div
            class="flex flex-col lg:flex-row gap-6 bg-white dark:bg-gray-800 shadow-lg border border-gray-300 rounded-lg p-6 sm:p-8 w-full max-w-5xl">
            <!-- Room Details and Picture -->
            <div class="w-full lg:w-1/2">
                <h3 class="mb-4 text-lg font-medium leading-none text-gray-900 dark:text-white">Room Details</h3>
                <div class="mb-4">
                    @if ($event->images->isNotEmpty())
                        <img src="{{ asset('storage/images/' . $event->images->first()->path) }}" alt="Event Image"
                            class="w-full rounded-lg">
                    @else
                        <p>No image available for this event.</p>
                    @endif
                </div>
                <div>
                    <p class="text-gray-900 dark:text-white mb-2">Event Name: {{ $event->event_name }}</p>
                    <p class="text-gray-900 dark:text-white mb-2">Description: {{ $event->description }}</p>
                    <p class="text-gray-900 dark:text-white mb-2">Event Price: ₱{{ $event->price }}</p>

                </div>
            </div>
            <!-- Form and Stepper -->
            <div class="w-full lg:w-1/2">
                <!-- Stepper -->
                <div
                    class="p-4 bg-gray-50 justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <form id="first-step-form" action="{{ route('registerEvent.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="mt-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @error('name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="text" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @error('email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="contact" class="block text-gray-700">Contact Number</label>
                            <input type="text" id="contact" name="contact"
                                value="{{ old('contactNo', auth()->user()->userInfo->contactNo ?? '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @error('contact')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Payment Amount</label>
                            <input type="number" name="payment" id="payment"
                                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-md p-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                required>
                            @error('payment')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Proof of Payment</label>
                            <input type="file" class="filepond" name="image" multiple credits="false" />
                            @error('image')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-center items-center space-x-5">
                            <button type="submit"
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                Submit
                            </button>
                            <a href="{{ url()->previous() }}" type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-white text-gray-700 hover:bg-red-700 hover:text-white disabled:opacity-50 disabled:pointer-events-none">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
