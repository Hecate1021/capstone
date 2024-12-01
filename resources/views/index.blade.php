@extends('layout.header')
@section('content')
    @include('layout.balai-navbar')
    @if (Auth::check())
        @include('resort.chatlist')
    @endif

    <style>
        .banner_area {
            position: relative;
            overflow: hidden;
        }

        .banner_area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Black overlay with transparency */
            z-index: 1; /* Overlay sits above the background image */
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0; /* Background image stays behind everything */
            pointer-events: none;
        }

        .overlay img.background-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner_content {
            position: relative;
            z-index: 2; /* Ensure content is above the overlay */
            color: #fff;
            text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.7); /* Enhanced text shadow for readability */
        }

        .logo-text {
            font-size: 2em;
            text-align: center;
            margin-top: -20px;
            color: #fff;
        }

        .rating-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .stars {
            display: inline-block;
            font-size: 2em;
            color: lightgray;
            position: relative;
            letter-spacing: 5px;
        }

        .stars::before {
            content: "★★★★★";
            position: absolute;
            top: 0;
            left: 0;
            width: calc(var(--rating) / 5 * 100%);
            color: gold;
            overflow: hidden;
        }
    </style>

    <section class="banner_area">
        <div class="booking_table d_flex align-items-center">
            <!-- Background Image -->
            <div class="overlay">
                <img src="{{ asset('images/background.png') }}" alt="Background Image" class="background-image" />
            </div>
            <div class="container">
                <!-- Banner Content -->
                <div class="banner_content text-center">
                    <h6></h6>
                    <h2 style="font-family: 'Alishah', cursive;">Sa Balai</h2>

                    <div class="logo-text">
                        <h3>Lake View Resort</h3>
                    </div>

                    <p style="font-size:20px;">"A Taste of Your Own Home - Where the Ambiance Always Feels Like Home"</p>

                    <!-- Ratings -->
                    <div class="rating-container">
                        <div class="stars" style="--rating: {{ $averageRating ?? 0 }};">
                            ★★★★★
                        </div>
                        <span class="rating-number">({{ number_format($averageRating, 1) ?? '0.0' }})</span>
                    </div>

                    <div>
                        <a href="{{ route('balai') }}" class="btn theme_btn button_hover">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--================Banner Area =================-->
    <div class="">
        <div class="shadow-lg mb-5 bg-white rounded">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs justify-content-center" id="bookingTab" role="tablist"
                style="    display: flex; padding-left: 0; margin-bottom: 0; list-style: none;">
                <li class="nav-item">
                    <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab"
                        aria-controls="overview" aria-selected="true">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="room-tab" data-toggle="tab" href="#room" role="tab" aria-controls="room"
                        aria-selected="false">Room</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="event-tab" data-toggle="tab" href="#event" role="tab" aria-controls="event"
                        aria-selected="false">Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="menus-tab" data-toggle="tab" href="#menus" role="tab" aria-controls="menus"
                        aria-selected="false">Menus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#Timeline" role="tab"
                        aria-controls="Timeline" aria-selected="false">Timeline</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab"
                        aria-controls="review" aria-selected="false">Review</a>
                </li>

            </ul>

            <style>
                .sticky-nav {
                    margin-top: 50px;
                    position: fixed;
                    top: 0;
                    width: 100%;
                    z-index: 1000;
                    background-color: white;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .sticky-placeholder {
                    height: 50px;
                }

                @media (max-width: 768px) {
                    .sticky-nav {
                        margin-top: 0;
                    }

                    .sticky-placeholder {
                        height: 0;
                    }

                    .nav-tabs .nav-link {
                        display: block;
                        padding: 0.5rem 4px;
                        color: black;
                    }
                }

                .nav-tabs .nav-link {
                    color: black;
                }



                .nav-tabs .nav-link.active {
                    color: blue;
                }
            </style>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var navbar = document.getElementById("bookingTab");
                    var stickyOffset = navbar.offsetTop;

                    // Sticky navbar on scroll
                    window.onscroll = function() {
                        if (window.pageYOffset >= stickyOffset) {
                            navbar.classList.add("sticky-nav");
                            navbar.parentElement.classList.add("sticky-placeholder");
                        } else {
                            navbar.classList.remove("sticky-nav");
                            navbar.parentElement.classList.remove("sticky-placeholder");
                        }
                    };

                    // Get the active tab from localStorage
                    var activeTab = localStorage.getItem('activeTab');
                    if (activeTab) {
                        // Remove 'active' class from all tabs
                        var tabs = document.querySelectorAll('#bookingTab .nav-link');
                        tabs.forEach(function(tab) {
                            tab.classList.remove('active');
                            tab.setAttribute('aria-selected', 'false');
                        });

                        // Activate the saved tab
                        var savedTab = document.querySelector(`a[href="${activeTab}"]`);
                        if (savedTab) {
                            savedTab.classList.add('active');
                            savedTab.setAttribute('aria-selected', 'true');

                            // Activate the corresponding tab content
                            var tabContent = document.querySelector(activeTab);
                            if (tabContent) {
                                var tabPanels = document.querySelectorAll('.tab-pane');
                                tabPanels.forEach(function(panel) {
                                    panel.classList.remove('show', 'active');
                                });
                                tabContent.classList.add('show', 'active');
                            }
                        }
                    }

                    // Save the active tab in localStorage on click
                    var tabLinks = document.querySelectorAll('#bookingTab .nav-link');
                    tabLinks.forEach(function(link) {
                        link.addEventListener('click', function(e) {
                            e.preventDefault(); // Prevent the default link behavior

                            // Remove 'active' class from all tabs before adding to the clicked one
                            tabLinks.forEach(function(tab) {
                                tab.classList.remove('active');
                                tab.setAttribute('aria-selected', 'false');
                            });

                            // Add 'active' class to the clicked tab
                            link.classList.add('active');
                            link.setAttribute('aria-selected', 'true');

                            // Show the corresponding tab content
                            var tabContentId = link.getAttribute('href');
                            var tabContent = document.querySelector(tabContentId);
                            var tabPanels = document.querySelectorAll('.tab-pane');
                            tabPanels.forEach(function(panel) {
                                panel.classList.remove('show', 'active');
                            });
                            if (tabContent) {
                                tabContent.classList.add('show', 'active');
                            }

                            // Save the active tab in localStorage
                            localStorage.setItem('activeTab', tabContentId);
                        });
                    });
                });
            </script>



            <!-- Tab panes -->
            <div class="tab-content mt-4 bg-light rounded">
                <!-- Overview -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <!--================ Accomodation Area  =================-->
                    <section class="accomodation_area section_gap">
                        <div class="container">
                            <div class="section_title text-center">
                                <h2 class="title_color">Resort Accommodation</h2>
                                {{-- <p>We all live in an age that belongs to the young at heart. Life that is becoming extremely
                                    fast,</p> --}}
                            </div>
                            <style>
                                .row1 {
                                    display: -ms-flexbox;
                                    display: flex;
                                    -ms-flex-wrap: wrap;
                                    flex-wrap: wrap;
                                    margin-right: -15px;
                                    margin-left: -15px;
                                    flex-direction: row;
                                    justify-content: center;
                                    align-content: stretch;
                                }
                            </style>
                            <div class="row1 mb_30 room-slider">
                                @foreach ($rooms as $room)
                                    @if ($room->status !== 'offline')
                                        <!-- Check if room status is not 'offline' -->
                                        <div class="col-lg-3 col-sm-6 room-item">
                                            <div class="accomodation_item text-center">
                                                <!-- Initialize Owl Carousel for individual room images -->
                                                <div class="owl-carousel hotel_img">
                                                    @foreach ($room->images as $image)
                                                        <div>
                                                            <img src="{{ asset('storage/images/' . $image->path) }}"
                                                                alt="Room Image">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a href="#">
                                                    <h4 class="sec_h4">{{ $room->name }}</h4>
                                                </a>
                                                <p>{{ $room->description }}</p>
                                                <h5>
                                                    ₱{{ $room->price }}<small>/night</small></h5>
                                                <a href="{{ route('room.book', $room->id) }}"
                                                    class="btn theme_btn button_hover">Book Now</a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    </section>
                    <!--================ Accomodation  End Area  =================-->
                    <!--================ Event Area =================-->
                    <section class="facilities_area section_gap">
                        <div class="container">
                            <div class="section_title text-center">
                                <h2 style="color: white">Event</h2>
                            </div>

                            @if ($events->isEmpty())
                                <div class="row mb-5">
                                    <div class="col-md-12 text-center">
                                        <h3 class="text-white">No events available</h3>
                                    </div>
                                </div>
                            @else
                                @foreach ($events as $event)
                                    <div class="row mb-5">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="about_content">
                                                <h2 class="title title_color text-white">{{ $event->event_name }}</h2>
                                                <p class="text-white">
                                                    {{ $event->description ?? 'No description available' }}
                                                </p>

                                                @if ($event->discount)
                                                    <h4 class="text-white">

                                                        ₱{{ number_format($event->price, 2) }}
                                                        <span>{{ $event->discount }}% off</span>
                                                    </h4>
                                                @else
                                                    <h4 class="text-white">
                                                        ₱{{ number_format($event->price, 2) }}</h4>
                                                @endif

                                                <p class="text-white">
                                                    From: {{ $event->event_start->format('M d, Y') }} to
                                                    {{ $event->event_end->format('M d, Y') }}
                                                </p>

                                                <a href="{{ route('register.event', $event->id) }}"
                                                    class="button_hover theme_btn_two">Book Now</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="hotel_img owl-carousel owl-theme">
                                                @foreach ($event->eventImages as $image)
                                                    <div class="item">
                                                        <img class="img-fluid" style="width: 100%; height: 486px;"
                                                            src="{{ asset('storage/images/' . $image->path) }}"
                                                            alt="{{ $event->event_name ?? 'Event Image' }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </section>


                    <!--================ Event Area End =================-->
                    <section class="accomodation_area section_gap">
                        <div class="container">
                            <div class="section_title text-center">
                                <h2 class="title_color">Menus</h2>
                                {{-- <p>We all live in an age that belongs to the young at heart. Life that is becoming extremely
                                    fast,</p> --}}
                            </div>

                            <!-- Loop through each category -->
                            @foreach ($categories as $category)
                                <!-- Check if the category has any menus in its subcategories -->
                                @php
                                    $hasMenus = false;
                                    foreach ($category->subcategories as $subcategory) {
                                        if ($subcategory->menus->isNotEmpty()) {
                                            $hasMenus = true;
                                            break;
                                        }
                                    }
                                @endphp

                                @if ($hasMenus)
                                    <div class="text-center">
                                        <h2>{{ $category->name }}</h2> <!-- Display Category Name -->
                                    </div>

                                    <!-- Loop through each subcategory -->
                                    @foreach ($category->subcategories as $subcategory)
                                        <!-- Check if the subcategory has any menus -->
                                        @if ($subcategory->menus->isNotEmpty())
                                            <h3>{{ $subcategory->name }}</h3> <!-- Display SubCategory Name -->

                                            <div class="row accomodation_two">
                                                <!-- Loop through each menu under the subcategory -->
                                                @foreach ($subcategory->menus as $menu)
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="accomodation_item text-center">
                                                            <div class="hotel_img">
                                                                @if ($menu->images->first())
                                                                    <img src="{{ asset('storage/images/' . $menu->images->first()->path) }}"
                                                                        alt="Menu Image"> <!-- Display Menu Image -->
                                                                @else
                                                                    <img src="{{ asset('storage/default.jpg') }}"
                                                                        alt="Default Image"> <!-- Default Image -->
                                                                @endif
                                                                {{-- <a href="#" class="btn theme_btn button_hover"
                                                                    style="padding:5px 17px;">Reserve Now</a> --}}
                                                            </div>

                                                            <h4 class="sec_h4">{{ $menu->name }}</h4>
                                                            <!-- Menu Name -->
                                                            <p>{{ $menu->description }}</p>
                                                            <h5>
                                                                ₱{{ $menu->price }}<small></small></h5>
                                                            <!-- Menu Price -->
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </section>

                    {{-- Timeline Section --}}
                    <div class="section_title text-center">
                        <h2 class="title_color">Timeline</h2>
                    </div>
                    <div class="container py-4">
                        @if ($posts->isNotEmpty())
                            @foreach ($posts->take(8) as $post)
                                <!-- Limit to latest 8 posts -->
                                <!-- Post Card -->
                                <div class="card shadow-sm mb-4 mx-auto" style="max-width: 70%; border:none;">
                                    <div class="card-body">
                                        <!-- User Info with Three-Dot Menu -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('images/lake-sebu.jpg') }}" alt="User Avatar"
                                                    class="rounded-circle" style="width: 40px; height: 40px;">
                                                <div class="ms-2">
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted d-flex align-items-center">
                                                        <i class="far fa-clock me-1"></i>
                                                        Posted {{ $post->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Post Content -->
                                        <a href="{{ route('viewpost', $post->id) }}"
                                            class="text-decoration-none text-dark">
                                            <p class="mb-3">{{ $post->content }}</p>

                                            <!-- Post Images -->
                                            <div class="row g-3">
                                                @if ($post->files->count() == 1)
                                                    <!-- One Media -->
                                                    <div class="col-12">
                                                        @if (in_array(pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                            <video controls class="w-100 rounded" style="height: auto;">
                                                                <source
                                                                    src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                    type="video/{{ pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION) }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @else
                                                            <img src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                alt="Post Image" class="img-fluid rounded w-100">
                                                        @endif
                                                    </div>
                                                @elseif ($post->files->count() == 2)
                                                    <!-- Two Media -->
                                                    @foreach ($post->files as $file)
                                                        <div class="col-6">
                                                            <div class="media-container">
                                                                @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                    <video controls class="rounded"
                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                        <source
                                                                            src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                            type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @else
                                                                    <img src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                        alt="Post Image" class="img-fluid rounded w-100"
                                                                        style="height: 100%; object-fit: cover;">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @elseif ($post->files->count() == 3)
                                                    <!-- Three Media -->
                                                    <div class="col-8">
                                                        <div class="media-container">
                                                            @if (in_array(pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                <video controls class="rounded"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                                    <source
                                                                        src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                        type="video/{{ pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION) }}">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            @else
                                                                <img src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                    alt="Post Image" class="img-fluid rounded w-100"
                                                                    style="height: 100%; object-fit: cover;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-4 d-flex flex-column justify-content-between">
                                                        @foreach ($post->files->slice(1) as $file)
                                                            <div class="media-container mb-2">
                                                                @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                    <video controls class="rounded"
                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                        <source
                                                                            src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                            type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @else
                                                                    <img src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                        alt="Post Image" class="img-fluid rounded w-100"
                                                                        style="height: 100%; object-fit: cover;">
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif ($post->files->count() >= 4)
                                                    <!-- Four or More Media -->
                                                    <div class="col-12">
                                                        <div class="media-container" style="height: 300px;">
                                                            @if (in_array(pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                <video controls class="rounded"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                                    <source
                                                                        src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                        type="video/{{ pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION) }}">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            @else
                                                                <img src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                    alt="Post Image" class="img-fluid rounded w-100"
                                                                    style="height: 100%; object-fit: cover;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 justify-content-center"
                                                        style="margin-top: 10px; margin-left: 1px;">
                                                        @foreach ($post->files->slice(1, 3) as $key => $file)
                                                            <div
                                                                class="col-4 position-relative d-flex justify-content-center">
                                                                <div class="media-container"
                                                                    style="height: 200px; width: 100%;">
                                                                    @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                        <video controls class="rounded"
                                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                                            <source
                                                                                src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                                type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    @else
                                                                        <img src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                            alt="Post Image"
                                                                            class="img-fluid rounded w-100"
                                                                            style="height: 100%; object-fit: cover;">
                                                                    @endif

                                                                    @if ($loop->last && $post->files->count() > 4)
                                                                        <div
                                                                            class="overlay d-flex align-items-center justify-content-center">
                                                                            <span>+{{ $post->files->count() - 4 }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-muted">No posts available.</p>
                        @endif
                    </div>

                    <!--================ Testimonial Area  =================-->
                    <div class="comments-area">
                        <h4>{{ $reviews->total() }} Review{{ $reviews->total() > 1 ? 's' : '' }}</h4>
                        @foreach ($reviews as $review)
                            <div class="comment-list left-padding {{ $loop->index > 0 ? '' : '' }}">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img style="width: 50px; height: 50px;"
                                                src="{{ optional($review->user->userInfo)->profilePath ? asset('storage/images/' . $review->user->userInfo->profilePath) : asset('images/default-avatar.png') }}"
                                                alt="User Image">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">{{ $review->user->name }}</a></h5>
                                            <p class="date">{{ $review->created_at->format('F j, Y \a\t g:i a') }}</p>
                                            <p class="comment">
                                                {{ $review->review }}
                                            </p>
                                            <div class="star">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <a href="#"><i class="fa fa-star text-warning"></i></a>
                                                        <!-- Yellow-filled star -->
                                                    @else
                                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                                        <!-- Empty star -->
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination Links -->
                        <nav class="blog-pagination justify-content-center d-flex">
                            {{ $reviews->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>


                    <!--================ Testimonial Area  =================-->

                </div>



                <!-- Room -->
                <div class="tab-pane fade" id="room" role="tabpanel" aria-labelledby="room-tab">
                    <!--================ Accomodation Area  =================-->
                    <section class="accomodation_area section_gap">
                        <div class="container">
                            <div class="section_title text-center">
                                <h2 class="title_color">Resort Accommodation</h2>
                                {{-- <p>We all live in an age that belongs to the young at heart. Life that is becoming extremely
                                    fast,</p> --}}
                            </div>
                            <style>
                                .row1 {
                                    display: -ms-flexbox;
                                    display: flex;
                                    -ms-flex-wrap: wrap;
                                    flex-wrap: wrap;
                                    margin-right: -15px;
                                    margin-left: -15px;
                                    flex-direction: row;
                                    justify-content: center;
                                    align-content: stretch;
                                }
                            </style>
                            <div class="row1 mb_30 room-slider">
                                @foreach ($rooms as $room)
                                    @if ($room->status !== 'offline')
                                        <!-- Check if room status is not 'offline' -->
                                        <div class="col-lg-3 col-sm-6 room-item">
                                            <div class="accomodation_item text-center">
                                                <!-- Initialize Owl Carousel for individual room images -->
                                                <div class="owl-carousel hotel_img">
                                                    @foreach ($room->images as $image)
                                                        <div>
                                                            <img src="{{ asset('storage/images/' . $image->path) }}"
                                                                alt="Room Image">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a href="#">
                                                    <h4 class="sec_h4">{{ $room->name }}</h4>
                                                </a>
                                                <p>{{ $room->description }}</p>
                                                <h5>
                                                    ₱{{ $room->price }}<small>/night</small></h5>
                                                <a href="{{ route('room.book', $room->id) }}"
                                                    class="btn theme_btn button_hover">Book Now</a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    </section>
                    <!--================ Accomodation Area  =================-->

                </div>



                <!-- Event -->
                <div class="tab-pane fade" id="event" role="tabpanel" aria-labelledby="event-tab">
                    <!--================ Event Area =================-->
                    <section class="facilities_area section_gap">
                        <div class="container">
                            <div class="section_title text-center">
                                <h2 style="color: white">Event</h2>
                            </div>

                            @if ($events->isEmpty())
                                <div class="row mb-5">
                                    <div class="col-md-12 text-center">
                                        <h3 class="text-white">No events available</h3>
                                    </div>
                                </div>
                            @else
                                @foreach ($events as $event)
                                    <div class="row mb-5">
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="about_content">
                                                <h2 class="title title_color text-white">{{ $event->event_name }}</h2>
                                                <p class="text-white">
                                                    {{ $event->description ?? 'No description available' }}
                                                </p>

                                                @if ($event->discount)
                                                    <h4 class="text-white">

                                                        ₱{{ number_format($event->price, 2) }}
                                                        <span>{{ $event->discount }}% off</span>
                                                    </h4>
                                                @else
                                                    <h4 class="text-white">
                                                        ₱{{ number_format($event->price, 2) }}</h4>
                                                @endif

                                                <p class="text-white">
                                                    From: {{ $event->event_start->format('M d, Y') }} to
                                                    {{ $event->event_end->format('M d, Y') }}
                                                </p>

                                                <a href="{{ route('register.event', $event->id) }}"
                                                    class="button_hover theme_btn_two">Book Now</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="hotel_img owl-carousel owl-theme">
                                                @foreach ($event->eventImages as $image)
                                                    <div class="item">
                                                        <img class="img-fluid" style="width: 100%; height: 486px;"
                                                            src="{{ asset('storage/images/' . $image->path) }}"
                                                            alt="{{ $event->event_name ?? 'Event Image' }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </section>




                    <!--================ Event Area End =================-->
                </div>



                <!-- Menus -->
                <div class="tab-pane fade" id="menus" role="tabpanel" aria-labelledby="menus-tab">
                    <section class="accomodation_area section_gap">
                        <div class="container">
                            <div class="section_title text-center">
                                <h2 class="title_color">Menus</h2>
                                {{-- <p>We all live in an age that belongs to the young at heart. Life that is becoming extremely
                                    fast,</p> --}}
                            </div>

                            <!-- Loop through each category -->
                            @foreach ($categories as $category)
                                <!-- Check if the category has any menus in its subcategories -->
                                @php
                                    $hasMenus = false;
                                    foreach ($category->subcategories as $subcategory) {
                                        if ($subcategory->menus->isNotEmpty()) {
                                            $hasMenus = true;
                                            break;
                                        }
                                    }
                                @endphp

                                @if ($hasMenus)
                                    <div class="text-center">
                                        <h2>{{ $category->name }}</h2> <!-- Display Category Name -->
                                    </div>

                                    <!-- Loop through each subcategory -->
                                    @foreach ($category->subcategories as $subcategory)
                                        <!-- Check if the subcategory has any menus -->
                                        @if ($subcategory->menus->isNotEmpty())
                                            <h3>{{ $subcategory->name }}</h3> <!-- Display SubCategory Name -->

                                            <div class="row accomodation_two">
                                                <!-- Loop through each menu under the subcategory -->
                                                @foreach ($subcategory->menus as $menu)
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="accomodation_item text-center">
                                                            <div class="hotel_img">
                                                                @if ($menu->images->first())
                                                                    <img src="{{ asset('storage/images/' . $menu->images->first()->path) }}"
                                                                        alt="Menu Image"> <!-- Display Menu Image -->
                                                                @else
                                                                    <img src="{{ asset('storage/default.jpg') }}"
                                                                        alt="Default Image"> <!-- Default Image -->
                                                                @endif
                                                                {{-- <a href="#" class="btn theme_btn button_hover"
                                                                    style="padding:5px 17px;">Reserve Now</a> --}}
                                                            </div>

                                                            <h4 class="sec_h4">{{ $menu->name }}</h4>
                                                            <!-- Menu Name -->
                                                            <p>{{ $menu->description }}</p>
                                                            <h5>
                                                                ₱{{ $menu->price }}<small></small></h5>
                                                            <!-- Menu Price -->
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </section>

                </div>





                <!-- Review -->
                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="comments-area">
                        <h4>{{ $reviews->total() }} Review{{ $reviews->total() > 1 ? 's' : '' }}</h4>
                        @foreach ($reviews as $review)
                            <div class="comment-list left-padding {{ $loop->index > 0 ? '' : '' }}">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img style="width: 50px; height: 50px;"
                                                src="{{ optional($review->user->userInfo)->profilePath ? asset('storage/images/' . $review->user->userInfo->profilePath) : asset('images/default-avatar.png') }}"
                                                alt="User Image">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">{{ $review->user->name }}</a></h5>
                                            <p class="date">{{ $review->created_at->format('F j, Y \a\t g:i a') }}</p>
                                            <p class="comment">
                                                {{ $review->review }}
                                            </p>
                                            <div class="star">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <a href="#"><i class="fa fa-star text-warning"></i></a>
                                                        <!-- Yellow-filled star -->
                                                    @else
                                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                                        <!-- Empty star -->
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination Links -->
                        <nav class="blog-pagination justify-content-center d-flex">
                            {{ $reviews->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                </div>

                <div class="tab-pane fade" id="Timeline" role="tabpanel" aria-labelledby="timeline-tab">
                    <div class="comments-area">
                        <div class="section_title text-center">
                            <h2 class="title_color">Timeline</h2>
                        </div>

                        <div class="container py-4">
                            @if ($posts->isNotEmpty())
                                @foreach ($posts as $post)
                                    <!-- Post Card -->
                                    <div class="card shadow-sm mb-4 mx-auto" style="max-width: 70%;">
                                        <div class="card-body">
                                            <!-- User Info with Three-Dot Menu -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('images/lake-sebu.jpg') }}" alt="User Avatar"
                                                        class="rounded-circle" style="width: 40px; height: 40px;">
                                                    <div class="ms-2">
                                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                                        <small class="text-muted d-flex align-items-center">
                                                            <i class="far fa-clock me-1"></i>
                                                            Posted {{ $post->created_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Post Content -->
                                            <a href="{{ route('viewpost', $post->id) }}" class="text-decoration-none text-dark">
                                                <p class="mb-3">{{ $post->content }}</p>

                                                <!-- Post Images -->
                                                <div class="row g-3">
                                                    @if ($post->files->count() == 1)
                                                        <!-- One Media -->
                                                        <div class="col-12">
                                                            @if (in_array(pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                <video controls class="w-100 rounded" style="height: auto;">
                                                                    <source
                                                                        src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                        type="video/{{ pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION) }}">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            @else
                                                                <img src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                    alt="Post Image" class="img-fluid rounded w-100">
                                                            @endif
                                                        </div>
                                                    @elseif ($post->files->count() == 2)
                                                        <!-- Two Media: Side by Side with Equal Heights -->
                                                        @foreach ($post->files as $file)
                                                            <div class="col-6">
                                                                <div class="media-container">
                                                                    @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                        <video controls class="rounded"
                                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                                            <source
                                                                                src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                                type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    @else
                                                                        <img src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                            alt="Post Image"
                                                                            class="img-fluid rounded w-100"
                                                                            style="height: 100%; object-fit: cover;">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @elseif ($post->files->count() == 3)
                                                        <!-- Three Media: One Large, Two Vertically Stacked -->
                                                        <div class="col-8">
                                                            <div class="media-container">
                                                                @if (in_array(pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                    <video controls class="rounded"
                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                        <source
                                                                            src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                            type="video/{{ pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION) }}">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @else
                                                                    <img src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                        alt="Post Image" class="img-fluid rounded w-100"
                                                                        style="height: 100%; object-fit: cover;">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-4 d-flex flex-column justify-content-between">
                                                            @foreach ($post->files->slice(1) as $file)
                                                                <div class="media-container mb-2">
                                                                    @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                        <video controls class="rounded"
                                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                                            <source
                                                                                src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                                type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    @else
                                                                        <img src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                            alt="Post Image"
                                                                            class="img-fluid rounded w-100"
                                                                            style="height: 100%; object-fit: cover;">
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @elseif ($post->files->count() >= 4)
                                                        <!-- Four Media: One Large on Top, Three Below with Equal Heights -->
                                                        <div class="col-12">
                                                            <div class="media-container" style="height: 300px;">
                                                                <!-- Larger height for the top media -->
                                                                @if (in_array(pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                    <video controls class="rounded"
                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                        <source
                                                                            src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                            type="video/{{ pathinfo($post->files->first()->file_name, PATHINFO_EXTENSION) }}">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @else
                                                                    <img src="{{ asset('storage/images/' . $post->files->first()->file_path) }}"
                                                                        alt="Post Image" class="img-fluid rounded w-100"
                                                                        style="height: 100%; object-fit: cover;">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 justify-content-center"
                                                            style="margin-top: 10px;margin-left:1px;">
                                                            @foreach ($post->files->slice(1, 3) as $key => $file)
                                                                <div
                                                                    class="col-4 position-relative d-flex justify-content-center">
                                                                    <div class="media-container"
                                                                        style="height: 200px; width: 100%;">
                                                                        <!-- Adjusted height -->
                                                                        @if (in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                                                            <video controls class="rounded"
                                                                                style="width: 100%; height: 100%; object-fit: cover;">
                                                                                <source
                                                                                    src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                                    type="video/{{ pathinfo($file->file_name, PATHINFO_EXTENSION) }}">
                                                                                Your browser does not support the video tag.
                                                                            </video>
                                                                        @else
                                                                            <img src="{{ asset('storage/images/' . $file->file_path) }}"
                                                                                alt="Post Image"
                                                                                class="img-fluid rounded w-100"
                                                                                style="height: 100%; object-fit: cover;">
                                                                        @endif

                                                                        <!-- Overlay for the Last Media -->
                                                                        @if ($loop->last && $post->files->count() > 4)
                                                                            <div class="overlay d-flex align-items-center justify-content-center"
                                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); color: white; font-size: 24px; border-radius: 8px;">
                                                                                <span>+{{ $post->files->count() - 4 }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-muted">No posts available.</p>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
