@extends('layout.header')
@section('content')
    @include('layout.balai-navbar')

    <div class="container py-4" style="margin-top: 6%;">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <!-- Post Card -->
        <div class="card shadow-sm mb-4 mx-auto" style="max-width: 70%;">
            <div class="card-body">
                <!-- User Info -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/lake-sebu.jpg') }}" alt="User Avatar"
                            class="rounded-circle" style="width: 40px; height: 40px;">
                        <div class="ms-2">
                            <h6 class="mb-0">{{ $post->user->name ?? 'Unknown User' }}</h6>
                            <small class="text-muted d-flex align-items-center">
                                <i class="far fa-clock me-1"></i>
                                Posted {{ $post->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Post Content -->
                <p class="mb-3">{{ $post->content }}</p>

                <!-- Post Media (Images & Videos) -->
                @if ($post->files->isNotEmpty())
                    <div class="d-flex flex-column align-items-center">
                        @foreach ($post->files as $file)
                            <div class="mb-3" style="width: 100%;">
                                @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                    <!-- Image -->
                                    <img src="{{ asset('storage/images/' . $file->file_path) }}" alt="Post Image"
                                        class="img-fluid rounded" style="display: block; margin: 0 auto;">
                                @elseif (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                    <!-- Video -->
                                    <video controls class="w-100 rounded">
                                        <source src="{{ asset('storage/images/' . $file->file_path) }}"
                                                type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">No media for this post.</p>
                @endif
            </div>
        </div>
    </div>




@endsection
