@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')
    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <div class="mt-5 md:mb-5 ">
                <div class="mb-5 mt-5">
                    <a href="{{ route('room.create') }}" class="px-2 py-2 rounded-md   text-gray-100 bg-blue-600">
                        Add Room</a>
                    <!-- Button to open the modal -->
                    <a class="px-2 py-2 rounded-md   text-gray-100 bg-blue-600"
                        onclick="toggleModal('roomOnlineModal')">
                        Room Online
                    </a>

                    <!-- Modal -->
                    <div id="roomOnlineModal"
                        class="fixed inset-0 flex items-center justify-center z-50 hidden bg-gray-800 bg-opacity-50 backdrop-blur-sm"
                        onclick="handleOutsideClick(event, 'roomOnlineModal')">
                        <!-- Modal Background -->
                        <div class="bg-white rounded-lg shadow-lg w-1/3 p-6" onclick="event.stopPropagation();">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                <h3 class="text-xl font-semibold">Room Online</h3>
                                <button class="text-gray-500 hover:text-gray-700" onclick="toggleModal('roomOnlineModal')">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="mt-4">
                                <form id="roomForm">
                                    <!-- Loop through rooms and display checkboxes -->
                                    @foreach ($rooms as $room)
                                        <div class="mb-2">
                                            <input type="checkbox" id="room{{ $room->id }}" name="rooms"
                                                value="{{ $room->id }}" class="mr-2">
                                            <label for="room{{ $room->id }}">{{ $room->name }}</label>
                                        </div>
                                    @endforeach
                                </form>
                            </div>

                            <!-- Modal Footer -->
                            <div class="mt-6 flex justify-end space-x-2">
                                <button class="bg-green-500 text-white py-2 px-4 rounded"
                                    onclick="updateRoomStatus('online')">
                                    Set Online
                                </button>
                                <button class="bg-red-500 text-white py-2 px-4 rounded"
                                    onclick="updateRoomStatus('offline')">
                                    Set Offline
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- JavaScript to handle modal and status updates -->
                    <script>
                        function toggleModal(modalID) {
                            const modal = document.getElementById(modalID);
                            modal.classList.toggle('hidden');

                            // Apply blur effect to the body when the modal is open
                            if (!modal.classList.contains('hidden')) {
                                document.body.classList.add('overflow-hidden'); // Prevent background scroll
                            } else {
                                document.body.classList.remove('overflow-hidden');
                            }
                        }

                        function handleOutsideClick(event, modalID) {
                            const modal = document.getElementById(modalID);
                            if (event.target === modal) {
                                toggleModal(modalID);
                            }
                        }

                        function updateRoomStatus(status) {
                            const checkedRooms = document.querySelectorAll('input[name="rooms"]:checked');
                            const roomIds = Array.from(checkedRooms).map(checkbox => checkbox.value);

                            if (roomIds.length === 0) {
                                toastr.warning('Please select at least one room.');
                                return;
                            }

                            // Make an AJAX request to update the room status
                            fetch('/update-room-status', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        room_ids: roomIds,
                                        status: status
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        toastr.success('Room status updated successfully!');

                                        // Refresh the page after 2 seconds
                                        setTimeout(() => {
                                            location.reload();
                                        }, 1500);
                                    } else {
                                        toastr.error('Failed to update room status.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    toastr.error('An error occurred while updating room status.');
                                });
                        }
                    </script>


                </div>
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Room Image</th>
                                    <th class="px-4 py-3">Room Name</th>
                                    <th class="px-4 py-3">Description</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($rooms as $room)
                                    <tr class="text-gray-700 dark:text-gray-400">

                                        <td class="px-4 py-3">
                                            <div class="relative w-32 h-32">
                                                <div id="carousel-{{ $room->id }}"
                                                    class="carousel relative overflow-hidden w-full h-full rounded">
                                                    @foreach ($room->images as $image)
                                                        <div
                                                            class="carousel-item absolute w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                                                            <img class="object-cover w-full h-full rounded"
                                                                src="{{ asset('storage/images/' . $image->path) }}"
                                                                alt="Room" loading="lazy">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="absolute inset-0 rounded shadow-inner" aria-hidden="true"></div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-md">{{ $room->name }}</td>
                                        <td class="px-4 py-3 text-md">{{ $room->description }}</td>
                                        <td class="px-4 py-3 text-md">{{ $room->price }}/night</td>
                                        <td class="px-4 py-3 text-md">{{ $room->status }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center space-x-4 text-sm">
                                                <button data-modal-target="edit-modal-{{ $room->id }}"
                                                    data-modal-toggle="edit-modal-{{ $room->id }}"
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                    aria-label="Edit">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                {{-- delete button --}}
                                                <button data-modal-target="popup-modal-{{ $room->id }}"
                                                    data-modal-toggle="popup-modal-{{ $room->id }}"
                                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
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
                                    <div id="edit-modal-{{ $room->id }}" tabindex="-1"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Close Button -->
                                                <button type="button"
                                                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="edit-modal-{{ $room->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <!-- Modal Content -->
                                                <div class="p-4 md:p-5">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">
                                                        Edit Room</h3>

                                                    <!-- Room Image Display -->
                                                    @foreach ($room->images as $image)
                                                        <div
                                                            class="relative w-full h-32 bg-gray-200 flex items-center justify-center mb-4">
                                                            <img src="{{ asset('storage/images/' . $image->path) }}"
                                                                alt="{{ $image->name }}"
                                                                class="object-cover h-full w-full rounded-md">
                                                            <form id="delete-form-{{ $image->id }}"
                                                                action="{{ route('image.destroy', $image->id) }}"
                                                                method="POST" class="absolute top-0 right-0 mt-1 mr-1">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    onclick="deleteImage({{ $image->id }})"
                                                                    class="text-white bg-gray-200 hover:bg-red-600 rounded-full p-1 focus:outline-none">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="2"
                                                                        stroke="currentColor" class="h-4 w-4">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endforeach

                                                    <!-- Edit Form -->
                                                    <form action="{{ route('room.update', $room->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-4">
                                                            <label for="name-{{ $room->id }}"
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-400">Room
                                                                Name</label>
                                                            <input type="text" name="name"
                                                                id="name-{{ $room->id }}"
                                                                value="{{ $room->name }}"
                                                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="description-{{ $room->id }}"
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-400">Description</label>
                                                            <textarea name="description" id="description-{{ $room->id }}"
                                                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">{{ $room->description }}</textarea>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="price-{{ $room->id }}"
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-400">Price
                                                                per Night</label>
                                                            <input type="number" name="price"
                                                                id="price-{{ $room->id }}"
                                                                value="{{ $room->price }}"
                                                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                        </div>
                                                        <div>
                                                            <label for="image"
                                                                class="block text-sm font-medium text-gray-700">Upload New
                                                                Images</label>
                                                            <input type="file" class="filepond" name="image"
                                                                multiple />
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
                                    <div id="popup-modal-{{ $room->id }}" tabindex="-1"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button type="button"
                                                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="popup-modal-{{ $room->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                        Are you sure you want
                                                        to delete this item?</h3>
                                                    <form action="{{ route('room.destroy', $room->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button data-modal-hide="popup-modal-{{ $room->id }}"
                                                            type="submit"
                                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            Yes, I'm sure
                                                        </button>
                                                    </form>
                                                    <button data-modal-hide="popup-modal-{{ $room->id }}"
                                                        type="button"
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

                    <div
                        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        <span class="flex items-center col-span-3">
                            Showing 21-30 of 100
                        </span>
                        <span class="col-span-2"></span>
                        <!-- Pagination -->
                        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                            <nav aria-label="Table navigation">
                                <ul class="inline-flex items-center">
                                    <li>
                                        <button
                                            class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                            aria-label="Previous">
                                            <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                                <path
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                            1
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                            2
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                                            3
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                            4
                                        </button>
                                    </li>
                                    <li>
                                        <span class="px-3 py-1">...</span>
                                    </li>
                                    <li>
                                        <button
                                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                            8
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                            9
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                            aria-label="Next">
                                            <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                                <path
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </span>
                    </div>
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
                const form = document.getElementById(`delete-form-${imageId}`);
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
                @foreach ($rooms as $room)
                    initCarousel('carousel-{{ $room->id }}');
                @endforeach
            });
        </script>
    @endsection
