@extends('design.header')

@section('content')
    @include('design.navbar')
    @include('design.admin-sidebar')
    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <!-- Dashboard Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
                <!-- Registered Resorts Card -->
                <div
                    class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v2H2v8h16v-8h-2V8a6 6 0 00-6-6zM8 8a2 2 0 114 0v2H8V8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Registered Resorts
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $resortCount }}
                        </p>
                    </div>
                </div>

                <!-- Registered Users Card -->
                <div
                    class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Registered Resorts
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $userCount }}
                    </p>
                </div>
            </div>

            <!-- Graph Section -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <button onclick="printGraph()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
                <div id="graphPrintArea">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-700">Ratings of Resort</h2>

                    </div>
                    <div class="w-full mx-auto graph-container">
                        <canvas id="bars"></canvas>
                    </div>
                </div>

            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var ctx = document.getElementById('bars').getContext('2d');

                    var resortNames = @json($resortRatings->pluck('name'));
                    var ratings = @json($resortRatings->pluck('reviews_avg_rating'));

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: resortNames,
                            datasets: [{
                                label: 'Resort Ratings',
                                data: ratings,
                                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Ratings of Resort',
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 5,
                                    title: {
                                        display: true,
                                        text: 'Rating'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Resorts'
                                    }
                                }
                            }
                        }
                    });
                });

                function printGraph() {
                    document.getElementById('graphPrintArea').classList.add('print-area');
                    window.print();
                    document.getElementById('graphPrintArea').classList.remove('print-area');
                }
            </script>

            <style>
                #bars {
                    min-height: 400px;
                    width: 100%;
                }

                .graph-container {
                    height: calc(100vh - 200px);
                    max-width: none;
                }

                @media print {
                    @page {
                        size: landscape;
                    }

                    .graph-container {
                        width: 100%;
                        height: 100vh;
                    }

                    #graphPrintArea {
                        page-break-inside: avoid;
                    }
                }
            </style>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Resorts Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="flex justify-between items-center p-4 bg-gray-50 border-b">
                        <h2 class="text-lg font-semibold"></h2>
                        <button onclick="printResorts()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            <i class="fas fa-print mr-2"></i>Print
                        </button>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <label for="resortsPerPage" class="text-sm font-medium text-gray-700">Show:</label>
                            <select id="resortsPerPage"
                                class="border rounded-md p-1 ml-2 focus:ring-blue-500 focus:border-blue-500"
                                onchange="window.location.href='?resortsPage='+this.value">
                                <option value="10" {{ request('resortsPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('resortsPage') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('resortsPage') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <span class="text-sm text-gray-600">entries per page</span>
                        </div>
                        <div class="overflow-x-auto" id="resortsPrintArea">
                            <h2 class="text-2xl font-bold mb-4 print-header">Registered Resorts</h2>
                            <table class="min-w-full">

                                <tbody>
                                    @foreach ($resorts as $resort)
                                        <tr>
                                            <td class="px-6 py-4 border-b">{{ $resort->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="flex justify-between items-center p-4 bg-gray-50 border-b">
                        <h2 class="text-lg font-semibold"></h2>
                        <button onclick="printUsers()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            <i class="fas fa-print mr-2"></i>Print
                        </button>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <label for="usersPerPage" class="text-sm font-medium text-gray-700">Show:</label>
                            <select id="usersPerPage"
                                class="border rounded-md p-1 ml-2 focus:ring-blue-500 focus:border-blue-500"
                                onchange="window.location.href='?usersPage='+this.value">
                                <option value="10" {{ request('usersPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('usersPage') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('usersPage') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <span class="text-sm text-gray-600">entries per page</span>
                        </div>
                        <div class="overflow-x-auto" id="usersPrintArea">
                            <h2 class="text-2xl font-bold mb-4 print-header">Registered Users</h2>
                            <table class="min-w-full">

                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 border-b">{{ $user->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                @media print {
                    body * {
                        visibility: hidden;
                    }

                    .print-area * {
                        visibility: visible;
                    }

                    .print-area {
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 210mm;
                        height: 297mm;
                        margin: 0;
                        padding: 20mm;
                    }
                }
            </style>

            <script>
                function printResorts() {
                    document.getElementById('resortsPrintArea').classList.add('print-area');
                    window.print();
                    document.getElementById('resortsPrintArea').classList.remove('print-area');
                }

                function printUsers() {
                    document.getElementById('usersPrintArea').classList.add('print-area');
                    window.print();
                    document.getElementById('usersPrintArea').classList.remove('print-area');
                }
            </script>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        </div>
    </div>
@endsection
