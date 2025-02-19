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
            background: rgba(0, 0, 0, 0.5);
            /* Black overlay with transparency */
            z-index: 1;
            /* Overlay sits above the background image */
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            /* Background image stays behind everything */
            pointer-events: none;
        }

        .overlay img.background-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner_content {
            position: relative;
            z-index: 2;
            /* Ensure content is above the overlay */
            color: #fff;
            text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.7);
            /* Enhanced text shadow for readability */
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
            <div class="overlay">
                <img src="{{ asset('images/lake1.jpg') }}" alt="Background Image" class="background-image" />
            </div>
            <div class="container">
                <div class="banner_content text-center">
                    <h2 class="title">Lake Sebu</h2>
                    <p class="subtitle">"Home of the Living Treasure"</p>
                </div>

                <!-- Weather Section (Inside Banner) -->
                <div class="weather_container p-4 rounded-lg">
                    <div class="row justify-content-center">
                        <!-- Current Weather -->
                        <div class="col-md-4 col-sm-12 weather_box">
                            <h2 id="temperature" class="weather-title">Loading...<br>Lake Sebu, PH</h2>
                            <p id="date" class="text-muted"></p>
                            <div id="extra-weather-details" class="extra-details d-none d-md-block">
                                <p>🌬 Wind Speed: <span id="wind-speed">0 m/s</span></p>
                                <p>🔽 Pressure: <span id="pressure">0 hPa</span></p>
                                <p>🌡 Feels Like: <span id="feels-like">0°C</span></p>
                                <p>👁 Visibility: <span id="visibility">0 km</span></p>
                            </div>
                        </div>

                        <!-- 5 Days Forecast (Hidden on Mobile) -->
                        <div class="col-md-8 col-sm-12 forecast_box d-none d-md-block">
                            <h3 class="forecast-title">Next 5 Days Forecast</h3>
                            <div id="forecast" class="forecast-container">
                                <!-- Forecast items added dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Weather API Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const apiKey = "e174e93b570221df4ab7045f4f6ecaea";
            const city = "Lake Sebu, PH";

            const weatherApiUrl =
                `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;
            const forecastApiUrl =
                `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}&units=metric`;

            fetch(weatherApiUrl)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("temperature").innerHTML = `${data.main.temp}°C<br>Lake Sebu, PH`;
                    document.getElementById("date").innerText = new Date().toLocaleDateString("en-US", {
                        month: "long",
                        day: "numeric",
                        year: "numeric"
                    });

                    document.getElementById("wind-speed").innerText = `${data.wind.speed} m/s`;
                    document.getElementById("pressure").innerText = `${data.main.pressure} hPa`;
                    document.getElementById("feels-like").innerText = `${data.main.feels_like}°C`;
                    document.getElementById("visibility").innerText =
                        `${(data.visibility / 1000).toFixed(1)} km`;
                })
                .catch(error => console.error("Error fetching weather data:", error));

            fetch(forecastApiUrl)
                .then(response => response.json())
                .then(data => {
                    const forecastDiv = document.getElementById("forecast");
                    forecastDiv.innerHTML = "";

                    // Get unique dates and their first forecast starting from tomorrow
                    const uniqueDates = {};
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1); // Start from tomorrow
                    tomorrow.setHours(0, 0, 0, 0); // Reset time to start of day

                    data.list.forEach(entry => {
                        const entryDate = new Date(entry.dt_txt);
                        const date = entryDate.toLocaleDateString();

                        if (entryDate >= tomorrow && !uniqueDates[date]) {
                            uniqueDates[date] = entry;
                        }
                    });

                    // Convert to array and take first 5 days
                    const dailyForecasts = Object.values(uniqueDates).slice(0, 5);

                    dailyForecasts.forEach(day => {
                        const date = new Date(day.dt_txt).toLocaleDateString("en-US", {
                            weekday: "short",
                            day: "numeric",
                            month: "short"
                        });
                        const tempMax = Math.round(day.main.temp_max);
                        const description = day.weather[0].description;
                        const icon = `https://openweathermap.org/img/wn/${day.weather[0].icon}.png`;

                        forecastDiv.innerHTML += `
                        <div class="forecast-item">
                            <p class="forecast-date">${date}</p>
                            <img src="${icon}" alt="${description}" class="forecast-icon">
                            <p class="forecast-temp">${tempMax}°C</p>
                        </div>`;
                    });
                })
                .catch(error => console.error("Error fetching forecast data:", error));
        });
    </script>

    <style>
        /* General Layout */
        .banner_area {
            position: relative;
            min-height: 90vh;
        }

        .overlay img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Title Styling */
        .title {
            font-family: 'Alishah', cursive;
            font-size: 4rem;
            margin-bottom: 1rem;
            color: white;
        }

        .subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            color: white;
        }

        /* Weather Container */
        .weather_container {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            color: white;
        }

        /* Forecast */
        .forecast-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        .forecast-item {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 10px;
            text-align: center;
            flex: 1;
            min-width: 100px;
        }

        .forecast-item:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.4);
        }

        .forecast-date {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .forecast-icon {
            width: 50px;
            height: 50px;
            margin: 10px 0;
        }

        .forecast-temp {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .min-temp {
            font-size: 0.9rem;
            color: #d1d1d1;
            margin-left: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .title {
                font-size: 3rem;
            }

            .subtitle {
                font-size: 1.2rem;
            }

            .weather-title {
                font-size: 1.5rem;
            }

            .extra-details {
                display: none !important;
            }

            .forecast_box {
                display: none !important;
            }
        }
    </style>










    <!--================Banner Area =================-->
    <div class="">
        <div class="shadow-lg mb-5 bg-white rounded">
            <!-- Tab panes -->

            <!--================ Accomodation Area  =================-->
            <section class="accomodation_area section_gap">
                <div class="container">
                    <div class="section_title text-center">
                        <h2 class="title_color">Resorts</h2>
                    </div>
                    <div class="row mb_30">
                        @foreach ($resorts as $resort)
                            <div class="col-lg-3 col-sm-6">
                                <div class="accomodation_item text-center">
                                    <div class="hotel_img">
                                        <img src="{{ asset('storage/images/' . $resort->image) }}" alt="Resort Image"
                                            class="img-fluid">
                                        <a href="{{ route('resort.show', ['id' => $resort->id]) }}"
                                            class="btn theme_btn button_hover">Explore</a>
                                    </div>
                                    <a href="#">
                                        <h4 class="sec_h4">{{ $resort->name }}</h4>
                                    </a>
                                    <h5>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $resort->averageRating)
                                                <i class="fa fa-star text-warning"></i>
                                            @else
                                                <i class="fa fa-star text-secondary"></i>
                                            @endif
                                        @endfor
                                        ({{ $resort->averageRating }})
                                    </h5>

                                    <!-- Availability popup -->
                                    <div class="availability">
                                        <button class="btn btn-info availability-btn" type="button" data-bs-toggle="modal"
                                            data-bs-target="#availabilityModal{{ $resort->id }}">
                                            Check Availability
                                        </button>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="availabilityModal{{ $resort->id }}" tabindex="-1"
                                        aria-labelledby="availabilityModalLabel{{ $resort->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="availabilityModalLabel{{ $resort->id }}">
                                                        {{ $resort->name }} - Operating Hours</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="availability-schedule">
                                                        @foreach ($resort->availability as $day => $times)
                                                            <div class="schedule-row">
                                                                <strong class="day">{{ $day }}</strong>
                                                                <span class="hours">
                                                                    <span
                                                                        class="{{ $times['opening_time'] == 'Closed' ? 'text-danger' : '' }}">
                                                                        {{ $times['opening_time'] }}
                                                                    </span> -
                                                                    <span
                                                                        class="{{ $times['closing_time'] == 'Closed' ? 'text-danger' : '' }}">
                                                                        {{ $times['closing_time'] }}
                                                                    </span>
                                                                </span>


                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <style>
                    .availability-btn {
                        margin-top: 10px;
                        padding: 8px 20px;
                        border-radius: 20px;
                        background-color: #17a2b8;
                        border: none;
                        font-size: 14px;
                        transition: all 0.3s ease;
                    }

                    .availability-btn:hover {
                        background-color: #138496;
                        transform: translateY(-2px);
                    }

                    .availability-schedule {
                        padding: 10px;
                    }

                    .schedule-row {
                        display: flex;
                        justify-content: space-between;
                        padding: 8px 0;
                        border-bottom: 1px solid #eee;
                    }

                    .schedule-row:last-child {
                        border-bottom: none;
                    }

                    .day {
                        color: #333;
                        min-width: 100px;
                    }

                    .hours {
                        color: #666;
                    }

                    .modal-content {
                        border-radius: 15px;
                    }

                    .modal-header {
                        background-color: #f8f9fa;
                        border-radius: 15px 15px 0 0;
                    }
                </style>
            </section>



            <section class="facilities_area section_gap">
                <div class="container">
                    <div class="section_title text-center">
                        <h2 class="title_color" style="color: white;">Tourist Spot</h2>
                    </div>
                    <div class="row mb_30">
                        @foreach ($touristSpots as $spot)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="tourist-spot-card">
                                    <div class="thumb">
                                        @foreach ($spot->images as $image)
                                            <img class="img-fluid" src="{{ asset('storage/images/' . $image->path) }}"
                                                alt="{{ $image->image }}">
                                        @endforeach
                                    </div>
                                    <div class="details">
                                        <h4 class="spot-title">{{ $spot->name }}</h4>
                                        <p class="spot-description">{{ Str::limit($spot->description, 100) }}</p>
                                        <h6 class="spot-location">
                                            Located at: {{ $spot->location }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <style>
                .tourist-spot-card {
                    background: #fff;
                    backdrop-filter: blur(10px);
                    border-radius: 15px;
                    overflow: hidden;
                    transition: transform 0.3s ease;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }

                .tourist-spot-card:hover {
                    transform: translateY(-5px);
                }

                .thumb {
                    width: 100%;
                    height: 250px;
                    overflow: hidden;
                }

                .thumb img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: transform 0.3s ease;
                }

                .tourist-spot-card:hover .thumb img {
                    transform: scale(1.05);
                }

                .details {
                    padding: 20px;
                    text-align: center;
                }

                .spot-title {
                    color: #333;
                    font-size: 1.5rem;
                    font-weight: 600;
                    margin-bottom: 10px;
                }

                .spot-description {
                    color: #666;
                    font-size: 0.95rem;
                    line-height: 1.6;
                    margin-bottom: 15px;
                }

                .spot-location {
                    color: #444;
                    font-size: 0.9rem;
                    font-weight: 500;
                }
            </style>

            {{-- Event Calendar --}}
            <section class="testimonial_area section_gap">
                <style>
                    .testimonial_item img.rounded-circle {
                        width: 150px;
                        height: 150px;
                        object-fit: cover;
                        margin-right: 20px;
                        border-radius: 0 !important;
                        /* Remove border radius to make it square */
                    }
                </style>
                <div class="container">
                    <div class="section_title text-center">
                        <h2 class="title_color">Event Calendar</h2>
                    </div>
                    <div class="testimonial_slider owl-carousel">
                        @foreach ($events as $event)
                            <div class="media testimonial_item">
                                <img class="rounded-circle"
                                    src="{{ $event->images->first() ? asset('storage/images/' . $event->images->first()->path) : asset('default.jpg') }}"
                                    alt="{{ $event->name }}">
                                <div class="media-body">

                                    <h4 class="sec_h4">{{ $event->name }}</h4>
                                    <p>{{ Str::limit($event->description, 100) }}</p>
                                    <p><strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($event->event_start)->format('F d, Y') }} -
                                        {{ \Carbon\Carbon::parse($event->event_end)->format('F d, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="owl-nav">
                        <div class="owl-prev">prev</div>
                        <div class="owl-next">next</div>
                    </div>
                    <div class="owl-dots"></div>
                </div>
            </section>

            <section class="about_history_area section_gap">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="about_content">
                                <h2 class="title title_color mb-4">About Lake Sebu</h2>
                                <div class="about_text">
                                    <p class="mb-4">
                                        Lake Sebu is a natural lake located in the municipality of Lake Sebu, South
                                        Cotabato, Philippines.
                                        It is one of the major tourist destinations in South Cotabato known for its serene
                                        waters,
                                        rich biodiversity, and the home of the T'boli indigenous people.
                                    </p>

                                </div>
                                <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">Discover More</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about_image position-relative">
                                <img class="img-fluid rounded shadow-lg" src="{{ asset('images/lake-sebu.jpg') }}"
                                    alt="Lake Sebu">
                                <div class="image_overlay"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <style>
                .about_history_area {
                    padding: 80px 0;
                    background: #fff;
                }

                .about_content .title {
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: #333;
                    position: relative;
                }

                .about_text p {
                    color: #666;
                    line-height: 1.8;
                    font-size: 1.1rem;
                }

                .about_text ul li {
                    padding: 8px 0;
                    color: #555;
                    font-size: 1.1rem;
                }

                .about_image {
                    overflow: hidden;
                    border-radius: 8px;
                }

                .about_image img {
                    transition: transform 0.3s ease;
                }

                .about_image:hover img {
                    transform: scale(1.05);
                }

                .btn-primary {
                    background: #1e4356;
                    border: none;
                    transition: all 0.3s ease;
                }

                .btn-primary:hover {
                    background: #2a5f7a;
                    transform: translateY(-2px);
                }
            </style>

            <footer class="footer-area section_gap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="border_line mb-4"></div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="footer-text mb-3 mb-md-0">
                                    Copyright ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script> All rights reserved
                                </div>
                                <div class="footer-social">
                                    <a href="#" class="mx-2"><i class="fa fa-facebook"></i></a>
                                    <a href="#" class="mx-2"><i class="fa fa-twitter"></i></a>
                                    <a href="#" class="mx-2"><i class="fa fa-dribbble"></i></a>
                                    <a href="#" class="mx-2"><i class="fa fa-behance"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            <style>
                .footer-area {
                    padding: 20px 0;
                    background: #021b35;
                }

                .border_line {
                    border-top: 1px solid #ddd;
                }

                .footer-social a {
                    color: #666;
                    font-size: 18px;
                    transition: color 0.3s ease;
                }

                .footer-social a:hover {
                    color: #333;
                }

                .footer-text {
                    color: #666;
                }
            </style>






        </div>
    </div>
@endsection
