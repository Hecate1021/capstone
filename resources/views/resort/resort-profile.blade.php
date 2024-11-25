@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.profile-header')


    <!-- Main Content -->
    <div class="mt-8 flex flex-col space-y-4  md:flex-row md:space-x-4 md:space-y-0">
        <!-- Info Sidebar -->
        <div class="w-full space-y-4 md:w-1/3">
            <div class="rounded-md bg-white border border-gray-300 shadow-3 p-4">
                <div class="flex justify-between items-center">
                    <p class="text-lg">Details</p>
                    <div class="relative inline-block text-left" x-data="{ open: false }">
                        @if ($isOwner)
                            <button @click="open = !open" class="rounded px-2 py-2 text-black">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        @endif
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    <p><i class="fas fa-envelope mr-2"></i>Email: {{ $user->email }}</p>
                    <p><i class="fas fa-phone mr-2"></i>Contact No: {{ $userInfo->contactNo ?? 'N/A' }}</p>
                    <p><i class="fas fa-map-marker-alt mr-2"></i>Address: {{ $userInfo->address ?? 'N/A' }}</p>
                    <p><i class="fas fa-info-circle mr-2"></i>Description: {{ $userInfo->description ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Photo Sidebar -->
            <div class="rounded-md p-4  bg-white border border-x-gray-400 shadow-md">
                <p class="text-lg">Photo</p>

                <div class="mt-4 space-y-2">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <img class="h-auto max-w-full rounded-lg transition duration-300 ease-in-out hover:scale-110"
                                src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- Main Post Content -->
        <div class="w-full space-y-4 md:flex-1">
            <!-- Post Event Text Box -->
            <div class="flex items-center rounded-md bg-white border border-gray-300 shadow-md p-4">
                <img class="h-12 w-12 rounded-full bg-gray-400"
                    src="{{ $user->userinfo && $user->userinfo->profilePath ? asset('storage/images/' . $user->userinfo->profilePath) : asset('images/default-avatar.png') }}"
                    alt="">
                <button class="ml-4 w-full flex text-gray-500 cursor-text rounded-full border p-2" data-twe-toggle="modal"
                    data-twe-target="#staticBackdroPostPhoto" data-twe-ripple-init data-twe-ripple-color="light">
                    Post your idea
                </button>

            </div>
            @if($posts->isNotEmpty())
            @foreach ($posts as $post)
                <!-- Post Card -->
                <div class="rounded-md bg-gray-300">
                    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-300 ">
                        <!-- User Info with Three-Dot Menu -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('images/lake-sebu.jpg') }}" alt="User Avatar"
                                    class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="text-gray-800 font-semibold">John Doe</p>
                                    <p class="text-gray-500 text-sm">Posted 2 hours ago</p>
                                </div>
                            </div>
                            <div class="text-gray-500 cursor-pointer relative" x-data="{ open: false }">
                                <!-- Three-dot menu icon -->
                                @if ($isOwner)
                                    <button @click="open = !open" class="hover:bg-gray-50 rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="7" r="1" />
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="12" cy="17" r="1" />
                                        </svg>
                                    </button>
                                @endif
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
                                    <div class="bg-white rounded-lg p-4 sm:p-6 md:p-8 w-11/12 sm:w-3/4 md:w-1/3 lg:w-1/4">
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

                            </div>
                        </div>
                        <!-- Message -->



                        <div class="mb-4">
                            <p class="text-gray-800">{{ $post->content }}


                            </p>
                        </div>
                        <!-- Image -->
                        <a href=""  class="container mx-auto">
                            @if ($post->files->count() == 1)
                                <!-- Display one large image or video -->
                                @foreach ($post->files as $file)
                                    @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image" class="w-full h-96 object-cover rounded-md mb-2">
                                    @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                        <video controls class="w-full h-96 object-cover rounded-md mb-2">
                                            <source src="{{ asset('storage/images/' . $file->file_path) }}" type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                @endforeach
                            @elseif ($post->files->count() == 2)
                                <!-- Display two media files side by side -->
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($post->files as $file)
                                        @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image" class="w-full h-96 object-cover rounded-md mb-2">
                                        @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                            <video controls class="w-full h-96 object-cover rounded-md mb-2">
                                                <source src="{{ asset('storage/images/' . $file->file_path) }}" type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif ($post->files->count() == 3)
                                <!-- Display one large media file on top and two smaller ones below -->
                                <div class="grid grid-cols-1 gap-4">
                                    @php $file = $post->files->first(); @endphp
                                    @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image" class="w-full h-96 object-cover rounded-md mb-2">
                                    @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                        <video controls class="w-full h-96 object-cover rounded-md mb-2">
                                            <source src="{{ asset('storage/images/' . $file->file_path) }}" type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($post->files->slice(1) as $file)
                                        @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image" class="w-full h-48 object-cover rounded-md mb-2">
                                        @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                            <video controls class="w-full h-48 object-cover rounded-md mb-2">
                                                <source src="{{ asset('storage/images/' . $file->file_path) }}" type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endforeach
                                </div>
                                @elseif ($post->files->count() >= 4)
                                <!-- Display one large media file on top and three smaller ones below -->
                                <div class="grid grid-cols-1 gap-4">
                                    @php $file = $post->files->first(); @endphp
                                    @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image" class="w-full h-96 object-cover rounded-md mb-2">
                                    @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                        <video controls class="w-full h-96 object-cover rounded-md mb-2">
                                            <source src="{{ asset('storage/images/' . $file->file_path) }}" type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                                <div class="grid grid-cols-3 gap-4 mt-4">
                                    @foreach ($post->files->slice(1, 3) as $file)
                                        @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Thumbnail Image" class="w-full h-24 object-cover rounded-md">
                                        @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                            <video controls class="w-full h-24 object-cover rounded-md">
                                                <source src="{{ asset('storage/images/' . $file->file_path) }}" type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endforeach
                                    @if ($post->files->count() > 4)
                                        @php $remainingCount = $post->files->count() - 4; @endphp
                                        <div class="relative w-full h-24 object-cover rounded-md bg-gray-200 flex items-center justify-center text-gray-600">
                                            <span class="absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 rounded-md text-white text-2xl font-bold">
                                                +{{ $remainingCount }}
                                            </span>
                                            @php $file = $post->files->get(4); @endphp
                                            @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image" class="w-full h-full object-cover rounded-md opacity-50">
                                            @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                <video controls class="w-full h-full object-cover rounded-md opacity-50">
                                                    <source src="{{ asset('storage/images/' . $file->file_path) }}" type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </a>




                        <!-- Like and Comment Section -->
                        <div class="flex items-center justify-between text-gray-500">
                            <div class="flex items-center space-x-2">
                                <button
                                    class="flex justify-center items-center gap-2 px-2 hover:bg-gray-50 rounded-full p-1">
                                    <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 21.35l-1.45-1.32C6.11 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-4.11 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                    <span>42 Likes</span>
                                </button>
                            </div>
                            <button class="flex justify-center items-center gap-2 px-2 hover:bg-gray-50 rounded-full p-1">
                                <svg width="22px" height="22px" viewBox="0 0 24 24" class="w-5 h-5 fill-current"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22ZM8 13.25C7.58579 13.25 7.25 13.5858 7.25 14C7.25 14.4142 7.58579 14.75 8 14.75H13.5C13.9142 14.75 14.25 14.4142 14.25 14C14.25 13.5858 13.9142 13.25 13.5 13.25H8ZM7.25 10.5C7.25 10.0858 7.58579 9.75 8 9.75H16C16.4142 9.75 16.75 10.0858 16.75 10.5C16.75 10.9142 16.4142 11.25 16 11.25H8C7.58579 11.25 7.25 10.9142 7.25 10.5Z">
                                        </path>
                                    </g>
                                </svg>
                                <span>3 Comment</span>
                            </button>
                        </div>
                        <hr class="mt-2 mb-2">
                        <p class="text-gray-800 font-semibold">Comment</p>
                        <hr class="mt-2 mb-2">
                        <div class="mt-4">
                            <!-- Comment 1 -->
                            <div class="flex items-center space-x-2">
                                <img src="https://placekitten.com/32/32" alt="User Avatar" class="w-6 h-6 rounded-full">
                                <div>
                                    <p class="text-gray-800 font-semibold">Jane Smith</p>
                                    <p class="text-gray-500 text-sm">Lovely shot! 📸</p>
                                </div>
                            </div>
                            <!-- Comment 2 -->
                            <div class="flex items-center space-x-2 mt-2">
                                <img src="https://placekitten.com/32/32" alt="User Avatar" class="w-6 h-6 rounded-full">
                                <div>
                                    <p class="text-gray-800 font-semibold">Bob Johnson</p>
                                    <p class="text-gray-500 text-sm">I can't handle the cuteness! Where can I get one?</p>
                                </div>
                            </div>
                            <!-- Reply from John Doe with indentation -->
                            <div class="flex items-center space-x-2 mt-2 ml-6">
                                <img src="https://placekitten.com/40/40" alt="User Avatar" class="w-6 h-6 rounded-full">
                                <div>
                                    <p class="text-gray-800 font-semibold">John Doe</p>
                                    <p class="text-gray-500 text-sm">That little furball is from a local shelter. You
                                        should
                                        check it out! 🏠😺</p>
                                </div>
                            </div>
                            <!-- Add more comments and replies as needed -->
                        </div>

                    </div>
                </div>
            @endforeach
            @else
    <p>No posts available.</p>
@endif
            <div class="p-10">
                {{-- loding --}}
            </div>
        </div>


    </div>

    <!-- Post Modal -->
    <div data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="staticBackdroPostPhoto" data-twe-backdrop="static" data-twe-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div data-twe-modal-dialog-ref
            class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
                <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                    <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLabel">
                        Change Profile Photo
                    </h5>
                    <button type="button"
                        class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                        data-twe-modal-dismiss aria-label="Close">
                        <span class="[&>svg]:h-6 [&>svg]:w-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </button>
                </div>
                <form action="{{ route('resort.post') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="relative flex flex-col p-4">
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="https://via.placeholder.com/40" alt="Profile Picture"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-medium">{{ $user->name }}</p>

                            </div>

                        </div>
                        <textarea name="content" id="content" rows="3" class="w-full border border-gray-300 rounded-md focus:ring-0"
                            placeholder="What's on your mind?"></textarea>

                        <div class="mt-4" data-twe-modal-body-ref>
                            <input type="file" class="filepond" id="postInput" name="image" multiple
                                credits="false" />
                        </div>

                        <div
                            class="flex space-x-2 flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4 dark:border-white/10">

                            <button type="button"
                                class="ms-1 inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-200 focus:bg-primary-accent-200 focus:outline-none focus:ring-0 active:bg-primary-accent-200 dark:bg-primary-300 dark:hover:bg-primary-400 dark:focus:bg-primary-400 dark:active:bg-primary-400"
                                data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="light">
                                Close
                            </button>
                            <button type="submit"
                                class="inline-block rounded bg-primary px-6 mr-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                                data-twe-ripple-init data-twe-ripple-color="light">
                                Post
                            </button>
                </form>

            </div>
        </div>
    </div>






    </div>


@endsection
@push('scripts')
<script>
    let deleteId = null;

    function openDeleteModal(id) {
        deleteId = id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }

    document.getElementById('confirm-delete').addEventListener('click', function() {
        if (deleteId) {
            // Send delete request to the server
            fetch(`/posts/${deleteId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
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
</script>
@endpush
