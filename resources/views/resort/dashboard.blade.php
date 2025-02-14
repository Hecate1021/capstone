@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')
    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-5">
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total clients with bookings
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $totalClientsWithBookings }}
                            <!-- This will display the total number of clients with bookings -->
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Account balance
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            ₱ {{ number_format($totalPayment, 2) }} <!-- Format the number to 2 decimal places -->
                        </p>
                    </div>

                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Room bookings
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $newBookingsCount }} <!-- This will display the count of new bookings -->
                        </p>
                    </div>


                </div>
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Event bookings
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $eventBooking }} <!-- This will display the count of new bookings -->
                        </p>
                    </div>


                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Pending bookings
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $pendingBookingsCount }} <!-- This will display the count of pending bookings -->
                        </p>
                    </div>

                </div>
            </div>
            <h3 class="mb-4 mt-10 font-semibold text-gray-800 dark:text-gray-300">Room Bookings</h3>
            <!-- Charts Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Monthly Ratings Line Chart -->
                <div class="bg-white rounded-lg shadow-xs dark:bg-gray-800 p-4">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Average Rating Per Month</h4>
                    <div style="position: relative; height: 300px;">
                        <canvas id="monthlyRatingsChart"></canvas>
                    </div>
                </div>

                <!-- Weekly Bookings Pie Chart -->
                <div class="bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Weekly Bookings</h4>
                    <div style="position: relative; height: 300px;">
                        <canvas id="weeklyPieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Monthly Bookings Line Chart -->
            <div class="mt-6 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Monthly Bookings</h4>
                <div style="position: relative; height: 300px;">
                    <canvas id="monthlyLineChart"></canvas>
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('monthlyRatingsChart').getContext('2d');

                        // Monthly Ratings Data (from Laravel)
                        const monthlyRatings = @json($monthlyRatings);

                        const months = monthlyRatings.map(item => item.month);
                        const ratings = monthlyRatings.map(item => item.average_rating);

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: 'Average Rating',
                                    data: ratings,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.3
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 5,
                                        title: {
                                            display: true,
                                            text: 'Rating (0 - 5)'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Months'
                                        }
                                    }
                                }
                            }
                        });
                    });

                    // Weekly Bookings Pie Chart
                    const weeklyCtx = document.getElementById('weeklyPieChart').getContext('2d');
                    const weeklyLabels = {!! json_encode($weeklyBookings->pluck('week')) !!};
                    const weeklyData = {!! json_encode($weeklyBookings->pluck('bookings')) !!};
                    new Chart(weeklyCtx, {
                        type: 'pie',
                        data: {
                            labels: weeklyLabels.map(week => `Week ${week}`),
                            datasets: [{
                                data: weeklyData,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(255, 206, 86, 0.6)',
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(153, 102, 255, 0.6)',
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right'
                                }
                            }
                        }
                    });

                    // Monthly Bookings Line Chart
                    const monthlyCtx = document.getElementById('monthlyLineChart').getContext('2d');
                    const monthlyLabels = {!! json_encode($monthlyBookings->pluck('month')) !!};
                    const monthlyData = {!! json_encode($monthlyBookings->pluck('bookings')) !!};
                    new Chart(monthlyCtx, {
                        type: 'line',
                        data: {
                            labels: monthlyLabels,
                            datasets: [{
                                label: 'Monthly Bookings',
                                data: monthlyData,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderWidth: 2,
                                tension: 0.3,
                                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Month'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Bookings'
                                    },
                                    ticks: {
                                        stepSize: 1, // Ensure only whole numbers are displayed
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value :
                                                null; // Display only whole numbers
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>



        </div>
    </div>
@endsection
