@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.admin-sidebar')
    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <!-- Add Event Button -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openModal()">
                Add Tourist Spot
            </button>

            <!-- Full-Page Modal Structure -->
            <div id="touristSpotModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white w-full max-w-md max-h-[90vh] overflow-hidden rounded-lg shadow-lg flex flex-col">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b p-4">
                        <h2 class="text-xl font-semibold">Add Tourist Spot</h2>
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
                        <form method="POST" action="{{ route('touristSpots.store') }}" enctype="multipart/form-data"
                            class="space-y-4">
                            @csrf
                            <!-- Spot Name -->
                            <div class="mb-4">
                                <label for="spotName" class="block text-sm font-medium text-gray-700">Spot Name</label>
                                <input type="text" name="name" id="spotName"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="spotDescription"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="spotDescription"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required></textarea>
                            </div>

                            <!-- Location Field -->
                            <div class="mb-4">
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" id="location"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" name="image" id="image" class="mt-1 block w-full" required>
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                    onclick="closeModal()">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Save Spot
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- JavaScript for Modal Functionality -->
            <script>
                function openModal() {
                    document.getElementById('touristSpotModal').classList.remove('hidden');
                }

                function closeModal() {
                    document.getElementById('touristSpotModal').classList.add('hidden');
                }
            </script>


            <!--Table event-->
            <div class="overflow-x-auto mt-5">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Image</th>
                            <th class="py-3 px-6 text-left">Tourist Spot Name</th>
                            <th class="py-3 px-6 text-left">Location</th>
                            <th class="py-3 px-6 text-left">Description</th>
                            <th class="py-3 px-6 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($touristSpots as $touristSpot)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <!-- Image Column -->
                                <td class="py-3 px-6 text-left">
                                    @foreach ($touristSpot->images as $image)
                                        <img src="{{ asset('storage/images/' . $image->path) }}" alt="Tourist Image"
                                            class="w-16 h-16 object-cover rounded-lg">
                                    @endforeach
                                </td>

                                <!-- Name Column -->
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $touristSpot->name }}</td>

                                <!-- Location Column -->
                                <td class="py-3 px-6 text-left">{{ $touristSpot->location }}</td>

                                <!-- Description Column -->
                                <td class="py-3 px-6 text-left">{{ $touristSpot->description }}</td>

                                <!-- Action Buttons -->
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center text-sm">
                                        <!-- Edit button -->
                                        <button data-modal-target="edit-modal-{{ $touristSpot->id }}"
                                            data-modal-toggle="edit-modal-{{ $touristSpot->id }}"
                                            class="px-2 py-2 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Delete button -->
                                        <button data-modal-target="popup-modal-{{ $touristSpot->id }}"
                                            data-modal-toggle="popup-modal-{{ $touristSpot->id }}"
                                            class="px-2 py-2 text-gray-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Delete">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div id="edit-modal-{{ $touristSpot->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Close Button -->
                                        <button type="button"
                                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="edit-modal-{{ $touristSpot->id }}">
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
                                                Edit Tourist Spot</h3>

                                            <!-- Tourist Spot Image Display -->
                                            @foreach ($touristSpot->images as $image)
                                                <div
                                                    class="relative w-full h-32 bg-gray-200 flex items-center justify-center mb-4">
                                                    <img src="{{ asset('storage/images/' . $image->path) }}"
                                                        alt="Tourist Spot Image"
                                                        class="object-cover h-full w-full rounded-md">
                                                    <form id="delete-form-tourist{{ $image->id }}"
                                                        action="{{ route('image-tourist.destroy', $image->id) }}"
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
                                            <form action="{{ route('touristSpots.update', $touristSpot->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-4">
                                                    <label for="name-{{ $touristSpot->id }}"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                        Tourist Spot Name</label>
                                                    <input type="text" name="name"
                                                        id="name-{{ $touristSpot->id }}"
                                                        value="{{ $touristSpot->name }}"
                                                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                </div>

                                                <div class="mb-4">
                                                    <label for="description-{{ $touristSpot->id }}"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                        Description</label>
                                                    <textarea name="description" id="description-{{ $touristSpot->id }}"
                                                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">{{ $touristSpot->description }}</textarea>
                                                </div>

                                                <div class="mb-4">
                                                    <label for="location-{{ $touristSpot->id }}"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                                        Location</label>
                                                    <input type="text" name="location"
                                                        id="location-{{ $touristSpot->id }}"
                                                        value="{{ $touristSpot->location }}"
                                                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                </div>

                                                <div>
                                                    <label for="image" class="block text-sm font-medium text-gray-700">
                                                        Upload New Images</label>
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

                            <div id="popup-modal-{{ $touristSpot->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button"
                                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="popup-modal-{{ $touristSpot->id }}">
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
                                                Are you sure you want to delete this tourist spot?
                                            </h3>
                                            <form action="{{ route('tourist-spots.destroy', $touristSpot->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button data-modal-hide="popup-modal-{{ $touristSpot->id }}"
                                                    type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Yes, I'm sure
                                                </button>
                                            </form>
                                            <button data-modal-hide="popup-modal-{{ $touristSpot->id }}" type="button"
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


            </div>

        </div>
    </div>
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
            const form = document.getElementById(`delete-form-tourist${imageId}`);
            const url = form.action;

            fetch(url, {
                    method: 'DELETE', // Ensure the method matches Laravel's expectations
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _token: document.querySelector('meta[name="csrf-token"]').content
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // Remove the image element from the DOM
                        form.closest('.relative').remove();
                        toastr.success('Tourist image deleted successfully.');
                    } else {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Failed to delete image.');
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while deleting the image.');
                });
        }
    </script>
@endsection
