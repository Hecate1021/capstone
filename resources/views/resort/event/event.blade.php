@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')
    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <!-- Add Event Button -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openModal()">
                Add Event
            </button>

            <!-- Full-Page Modal Structure -->
            <div id="eventModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white w-full max-w-md max-h-[90vh] overflow-hidden rounded-lg shadow-lg flex flex-col">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b p-4">
                        <h2 class="text-xl font-semibold">Add Event</h2>
                        <button class="text-gray-600 hover:text-gray-800" onclick="closeModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body (Scrollable Content) -->
                    <div class="flex-1 p-4 overflow-y-auto">
                        <form method="POST" action="{{ route('events.store') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="resort_id" value="{{ Auth::user()->id }}">

                            <div class="mb-4">
                                <label for="eventName" class="block text-sm font-medium text-gray-700">Event Name</label>
                                <input type="text" name="event_name" id="eventName"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="eventDescription"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="eventDescription"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="eventStart" class="block text-sm font-medium text-gray-700">Event Start</label>
                                <input type="datetime-local" name="event_start" id="eventStart"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="eventEnd" class="block text-sm font-medium text-gray-700">Event End</label>
                                <input type="datetime-local" name="event_end" id="eventEnd"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" name="price" id="price"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="discount" class="block text-sm font-medium text-gray-700">Discount
                                    (optional)</label>
                                <input type="number" name="discount" id="discount"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" class="filepond" name="image" multiple credits="false" />
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                    onclick="closeModal()">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Save Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- JavaScript for Modal Functionality -->
            <script>
                function openModal() {
                    document.getElementById('eventModal').classList.remove('hidden');
                }

                function closeModal() {
                    document.getElementById('eventModal').classList.add('hidden');
                }
            </script>


            <!--Table event-->
            <div class="overflow-x-auto mt-5">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Event Image</th>
                            <th class="py-3 px-6 text-left">Event Name</th>
                            <th class="py-3 px-6 text-left">Description</th>
                            <th class="py-3 px-6 text-left">Event Start</th>
                            <th class="py-3 px-6 text-left">Event End</th>
                            <th class="py-3 px-6 text-left">Price</th>
                            <th class="py-3 px-6 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($events as $event)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">
                                    <div class="w-24 h-24"> <!-- Update the width and height here -->
                                        <div id="carousel-{{ $event->id }}"
                                            class="relative overflow-hidden w-full h-full rounded">
                                            @foreach ($event->eventImages as $image)
                                                <div
                                                    class="carousel-item absolute w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                                                    <img class="object-cover w-full h-full rounded"
                                                        src="{{ asset('storage/images/' . $image->path) }}" alt="event"
                                                        loading="lazy">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>


                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $event->event_name }}</td>
                                <td class="py-3 px-6 text-left">{{ $event->description }}</td>
                                <td class="py-3 px-6 text-left">{{ $event->event_start }}</td>
                                <td class="py-3 px-6 text-left">{{ $event->event_end }}</td>
                                <td class="py-3 px-6 text-left">{{ $event->price }}</td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center text-sm">
                                        <!-- Edit button -->
                                        <button data-modal-target="edit-modal-{{ $event->id }}"
                                            data-modal-toggle="edit-modal-{{ $event->id }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Delete button -->
                                        <button data-modal-target="popup-modal-{{ $event->id }}"
                                            data-modal-toggle="popup-modal-{{ $event->id }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Delete">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div id="edit-modal-{{ $event->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Close Button -->
                                        <button type="button"
                                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="edit-modal-{{ $event->id }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <!-- Modal Content -->
                                        <div class="p-4 md:p-5">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">
                                                Edit event</h3>

                                            <!-- event Image Display -->
                                            @foreach ($event->images as $image)
                                                <div
                                                    class="relative w-full h-32 bg-gray-200 flex items-center justify-center mb-4">
                                                    <img src="{{ asset('storage/images/' . $image->path) }}"
                                                        alt="{{ $image->name }}"
                                                        class="object-cover h-full w-full rounded-md">
                                                    <form id="delete-form-event{{ $image->id }}"
                                                        action="{{ route('image-event.destroy', $image->id) }}"
                                                        method="POST" class="absolute top-0 right-0 mt-1 mr-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="deleteImage({{ $image->id }})"
                                                            class="text-white bg-gray-200 hover:bg-red-600 rounded-full p-1 focus:outline-none">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" class="h-4 w-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach

                                            <!-- Edit Form -->
                                            <form action="{{ route('events.update', $event->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-4">
                                                    <label for="name-{{ $event->id }}"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-400">event
                                                        Name</label>
                                                    <input type="text" name="name" id="name-{{ $event->id }}"
                                                        value="{{ $event->event_name }}"
                                                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                </div>
                                                <div class="mb-4">
                                                    <label for="description-{{ $event->id }}"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-400">Description</label>
                                                    <textarea name="description" id="description-{{ $event->id }}"
                                                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">{{ $event->description }}</textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="price-{{ $event->id }}"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-400">Price
                                                        per Night</label>
                                                    <input type="number" name="price" id="price-{{ $event->id }}"
                                                        value="{{ $event->price }}"
                                                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                </div>
                                                <div>
                                                    <label for="image"
                                                        class="block text-sm font-medium text-gray-700">Upload New
                                                        Images</label>
                                                    <input type="file" class="filepond" name="image" multiple />
                                                </div>
                                                <button type="submit"
                                                    class="w-full text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center justify-center px-5 py-2.5 text-center">
                                                    Save Changes
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete Structure -->
                            <div id="popup-modal-{{ $event->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button"
                                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="popup-modal-{{ $event->id }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                Are you sure you want
                                                to delete this item?</h3>
                                            <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button data-modal-hide="popup-modal-{{ $event->id }}" type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Yes, I'm sure
                                                </button>
                                            </form>
                                            <button data-modal-hide="popup-modal-{{ $event->id }}" type="button"
                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                No, cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Listen for the modal to be opened
                        document.querySelectorAll('[data-modal-show]').forEach(button => {
                            button.addEventListener('click', (e) => {
                                const modalId = e.currentTarget.getAttribute('data-modal-show');
                                const modal = document.getElementById(modalId);

                                // Initialize FilePond inside the modal
                                const fileInputs = modal.querySelectorAll('input[type="file"]');
                                fileInputs.forEach(input => {
                                    FilePond.create(input);
                                });
                            });
                        });

                        // Initialize FilePond globally if needed
                        FilePond.parse(document.body);
                    });

                    function deleteImage(imageId) {
                        const form = document.getElementById(`delete-form-event${imageId}`);
                        const url = form.action;
                        const formData = new FormData(form);

                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': formData.get('_token'),
                                },
                                body: formData,
                            })
                            .then(response => {
                                if (response.ok) {
                                    // Remove the image element from the DOM
                                    form.closest('.relative').remove();
                                    toastr.success('Image deleted successfully.');
                                } else {
                                    toastr.error('Failed to delete image.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                toastr.error('An error occurred while deleting the image.');
                            });
                    }

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
                        @foreach ($events as $event)
                            initCarousel('carousel-{{ $event->id }}');
                        @endforeach
                    });
                </script>
            @endsection
