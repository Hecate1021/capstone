@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')
    <div class="p-4 sm:ml-64 mt-12">
        <div class="rounded-lg dark:border-gray-700">
            <!-- Add Post Button -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openPostModal()">
                Add Post
            </button>

            <!-- Add Post Modal -->
            <div id="postModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white w-full max-w-md max-h-[90vh] overflow-hidden rounded-lg shadow-lg flex flex-col">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b p-4">
                        <h2 class="text-xl font-semibold">Add Post</h2>
                        <button class="text-gray-600 hover:text-gray-800" onclick="closePostModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="flex-1 p-4 overflow-y-auto">
                        <form method="POST" action="{{ route('posts.store') }}" class="space-y-4"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Post Title -->
                            {{-- <div class="mb-4">
                                <label for="postTitle" class="block text-sm font-medium text-gray-700">Post Title</label>
                                <input type="text" name="title" id="postTitle"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                            </div> --}}

                            <!-- Post Content -->
                            <div class="mb-4">
                                <label for="postContent" class="block text-sm font-medium text-gray-700">Content</label>
                                <textarea name="content" id="postContent"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    rows="5" required></textarea>
                            </div>

                            <!-- Post Image -->
                            <div class="mb-4">
                                <label for="postImage" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" class="filepond" name="image" multiple credits="false" />
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex justify-end space-x-2 mt-4">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                    onclick="closePostModal()">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                    Save Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                // Functions to open and close the modal
                function openPostModal() {
                    document.getElementById('postModal').classList.remove('hidden');
                }

                function closePostModal() {
                    document.getElementById('postModal').classList.add('hidden');
                }
            </script>
            <!-- Main Post Content -->
            <div class="w-full space-y-4 md:flex-1">
                @if ($posts->isNotEmpty())
                    @foreach ($posts as $post)
                        <!-- Post Card -->
                        <div class="rounded-md bg-gray-300 mx-[15%]">
                            <div class="bg-white p-8 rounded-lg shadow-md border border-gray-300">
                                <!-- User Info with Three-Dot Menu -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-2">
                                        <img src="{{ asset('images/lake-sebu.jpg') }}" alt="User Avatar"
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <p class="text-gray-800 font-semibold">{{ $user->name }}</p>
                                            <p class="text-gray-500 text-sm flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg>
                                                Posted {{ $post->created_at->diffForHumans() }}
                                            </p>


                                        </div>
                                    </div>
                                    <div class="text-gray-500 cursor-pointer relative" x-data="{ open: false }">
                                        <!-- Three-dot menu icon -->

                                        <button @click="open = !open" class="hover:bg-gray-50 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="7" r="1" />
                                                <circle cx="12" cy="12" r="1" />
                                                <circle cx="12" cy="17" r="1" />
                                            </svg>
                                        </button>

                                        <div x-show="open" @click.away="open = false"
                                            class="absolute right-0 mt-2 w-48 sm:w-56 md:w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95">
                                            <div class="py-1">
                                                <a href="#"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                                <!-- Delete Link -->
                                                <a href="#" onclick="openDeleteModal({{ $post->id }})"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Delete</a>
                                            </div>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div id="delete-modal"
                                            class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50 z-50">
                                            <div
                                                class="bg-white rounded-lg p-4 sm:p-6 md:p-8 w-11/12 sm:w-3/4 md:w-1/3 lg:w-1/4">
                                                <h3 class="text-lg sm:text-xl font-semibold">Are you sure?</h3>
                                                <p class="mt-2 text-sm sm:text-base">This action cannot be undone.</p>
                                                <div class="mt-4 flex justify-end">
                                                    <button onclick="closeDeleteModal()"
                                                        class="px-4 py-2 mr-2 text-white bg-gray-500 rounded hover:bg-gray-600">Cancel</button>
                                                    <button id="confirm-delete"
                                                        class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Menu and Modals -->
                                    </div>
                                </div>
                                <a href="{{ route('post.view', $post->id) }}">
                                    <!-- Message -->
                                    <div class="mb-4">
                                        <p class="text-gray-800">{{ $post->content }}</p>
                                    </div>
                                    <div class="container mx-auto">
                                        @if ($post->files->count() == 1)
                                            <!-- Single Media -->
                                            <div class="flex justify-center">
                                                <div class="grid grid-cols-1">
                                                    @foreach ($post->files as $file)
                                                        @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <!-- Single Image -->
                                                            <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image"
                                                                class="w-11/12 h-[500px] object-cover rounded-md mb-4">
                                                        @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                            <!-- Single Video -->
                                                            <video controls class="w-11/12 h-[500px] object-cover rounded-md mb-4">
                                                                <source src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                        type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif ($post->files->count() == 2)
                                            <!-- Two Media Items -->
                                            <div class="grid grid-cols-2 gap-4">
                                                @foreach ($post->files as $file)
                                                    @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image"
                                                            class="w-full h-64 object-cover rounded-md">
                                                    @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                        <video controls class="w-full h-64 object-cover rounded-md">
                                                            <source src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                    type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @elseif ($post->files->count() == 3)
                                            <!-- Three Media Items -->
                                            <div class="grid grid-cols-3 gap-4">
                                                @php $file = $post->files->first(); @endphp
                                                @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image"
                                                        class="col-span-2 w-full h-96 object-cover rounded-md">
                                                @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                    <video controls class="col-span-2 w-full h-96 object-cover rounded-md">
                                                        <source src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                                <div class="grid grid-rows-2 gap-4">
                                                    @foreach ($post->files->slice(1) as $file)
                                                        @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image"
                                                                class="w-full h-48 object-cover rounded-md">
                                                        @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                            <video controls class="w-full h-48 object-cover rounded-md">
                                                                <source src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                        type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif ($post->files->count() > 3)
                                            <!-- More Than Three Media Items -->
                                            <div class="grid grid-cols-1 gap-4">
                                                <!-- First Large Media Item -->
                                                @php $file = $post->files->first(); @endphp
                                                @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image"
                                                        class="w-full h-96 object-cover rounded-md">
                                                @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                    <video controls class="w-full h-96 object-cover rounded-md">
                                                        <source src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif

                                                <!-- Bottom Row -->
                                                <div class="grid grid-cols-3 gap-4">
                                                    @foreach ($post->files->slice(1, 3) as $file)
                                                        @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image"
                                                                class="w-full h-48 object-cover rounded-md">
                                                        @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                            <video controls class="w-full h-48 object-cover rounded-md">
                                                                <source src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                        type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>


                                </a>

                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No posts available.</p>
                @endif
            </div>



        </div>
    </div>

    <script>
        let deleteId = null;

        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Function to open the delete modal
            function openDeleteModal(id) {
                deleteId = id;
                document.getElementById('delete-modal').classList.remove('hidden');
            }

            // Function to close the delete modal
            function closeDeleteModal() {
                document.getElementById('delete-modal').classList.add('hidden');
            }

            // Add event listener to the confirm delete button
            const confirmDeleteButton = document.getElementById('confirm-delete');
            if (confirmDeleteButton) {
                confirmDeleteButton.addEventListener('click', function() {
                    if (deleteId) {
                        // Send delete request to the server
                        fetch(`/posts/${deleteId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute(
                                            'content')
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    toastr.success(data.success);
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000); // Delay for toastr to be visible
                                } else if (data.error) {
                                    toastr.error(data.error);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                toastr.error('An error occurred while deleting the post.');
                            });
                    }
                });
            }
        });
    </script>

@endsection
