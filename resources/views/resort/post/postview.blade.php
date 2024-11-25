@extends('design.header')


@section('content')
    @include('design.navbar')

    <!-- Back Button -->
    <div class="container mx-auto p-6" style="margin-top: 52px">
        <a href="{{ url()->previous() }}" class="inline-block text-blue-600 hover:underline font-semibold text-lg mb-4">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        <div class="bg-white rounded-lg shadow-md p-6" style="margin-left: 20%; margin-right:20%;">

            <!-- Post Information -->
            <div class="flex items-center space-x-4 mb-4">
                <!-- User Avatar -->
                <img src="{{ asset('images/lake-sebu.jpg') }}" alt="User Avatar" class="w-12 h-12 rounded-full">
                <div>
                    <h2 class="text-lg font-semibold">{{ $post->user->name }}</h2>
                    <p class="text-gray-500 text-sm">Posted {{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Post Content -->
            <div class="mb-4">
                <p class="text-gray-800">{{ $post->content }}</p>
            </div>

            @if ($post->files->count() > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach ($post->files as $index => $file)
                    @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']))
                        <!-- Display Image -->
                        <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image"
                             class="w-full h-72 object-cover rounded-md cursor-pointer"
                             onclick="openModal({{ $index }})">
                    @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                        <!-- Display Video -->
                        <video class="post-video w-full h-72 object-cover rounded-md"
                               data-src="{{ asset('storage/images/' . $file->file_path) }}"
                               controls muted>
                            <source src="{{ asset('storage/images/' . $file->file_path) }}" type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                @endforeach
            </div>
        @endif



        </div>
    </div>

    <div id="imageModal"
        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50 px-4 py-8">
        <div class="relative bg-white p-4 rounded-lg max-w-4xl mx-auto">
            <!-- Close Button (Top-Left) -->
            <button onclick="closeModal()"
                class="absolute top-4 left-4 flex items-center justify-center w-8 h-8 bg-black text-white rounded-full hover:bg-opacity-75 focus:outline-none z-10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Prev Button Wrapper -->
            <div class="absolute inset-y-0 left-0 flex items-center">
                <button onclick="changeImage(-1)"
                    class="flex items-center justify-center w-12 h-12 bg-black text-white rounded-full z-10 hover:bg-opacity-75 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-6 h-6">
                        <path d="M15.41 7.41L10.83 12l4.58 4.59L14 18l-6-6 6-6z" />
                    </svg>
                </button>
            </div>

            <!-- Next Button Wrapper -->
            <div class="absolute inset-y-0 right-0 flex items-center">
                <button onclick="changeImage(1)"
                    class="flex items-center justify-center w-12 h-12 bg-black text-white rounded-full z-10 hover:bg-opacity-75 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-6 h-6">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z" />
                    </svg>
                </button>
            </div>

            <!-- Image -->
            <img id="modalImage" src="" alt="Modal Image" class="max-w-full max-h-[80vh] object-contain rounded-md">

            <!-- Close Button (Top-Right for Accessibility) -->
            <button onclick="closeModal()" class="absolute top-4 right-4 text-black text-3xl font-bold">
                &times;
            </button>
        </div>
    </div>



    <script>
        let currentIndex = 0;
        const images = @json($post->files->pluck('file_path')->toArray());

        // Function to open the modal and display the image
        function openModal(index) {
            currentIndex = index;
            updateModalImage();
            document.getElementById('imageModal').classList.remove('hidden');
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Function to change the image in modal (Prev / Next)
        function changeImage(direction) {
            currentIndex = (currentIndex + direction + images.length) % images.length; // Circular navigation
            updateModalImage();
        }

        // Function to update the modal image
        function updateModalImage() {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = '/storage/images/' + images[currentIndex];
        }

        // Keyboard navigation for the modal
        document.addEventListener('keydown', function(event) {
            if (!document.getElementById('imageModal').classList.contains('hidden')) {
                if (event.key === 'ArrowLeft') {
                    changeImage(-1); // Previous image
                } else if (event.key === 'ArrowRight') {
                    changeImage(1); // Next image
                } else if (event.key === 'Escape') {
                    closeModal(); // Close modal
                }
            }
        });

        // Backdrop click to close modal
        document.getElementById('imageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
    const videos = document.querySelectorAll('.post-video');

    const playVideo = (video) => {
        if (!video.paused) video.play(); // Play if not already playing
    };

    const pauseVideo = (video) => {
        if (!video.paused) video.pause(); // Pause only if playing
    };

    const observerOptions = {
        root: null, // Use the viewport as the root
        threshold: 0.5, // Video must be at least 50% visible to play
    };

    const videoObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const video = entry.target;

            if (entry.isIntersecting) {
                playVideo(video);
            } else {
                pauseVideo(video);
            }
        });
    }, observerOptions);

    videos.forEach(video => {
        videoObserver.observe(video);
    });
});


    </script>


@endsection
