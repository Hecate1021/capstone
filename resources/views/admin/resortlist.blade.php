@extends('design.header')

@section('content')
    @include('design.navbar')
    @include('design.admin-sidebar')

    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <div class="w-full overflow-x-auto">
                <!-- Print Button -->
                <div class="mb-4">
                    <button onclick="window.print()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Print Resort List
                    </button>
                </div>

                <!-- Print-friendly styles -->
                <style>
                    @media print {
                        body * {
                            visibility: hidden;
                        }

                        .print-section,
                        .print-section * {
                            visibility: visible;
                        }

                        .print-section {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 100%;
                        }

                        table {
                            border-collapse: collapse;
                            width: 100%;
                        }

                        td,
                        th {
                            border: 1px solid black;
                            color: black !important;
                            background: white !important;
                        }
                    }
                </style>

                <div class="print-section">
                    <h1 class="text-center text-2xl font-bold mb-4">Resort List</h1>
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Contact No.</th>
                                <th class="px-4 py-3">Address</th>
                                <th class="px-4 py-3">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($resorts as $resort)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm font-semibold">{{ $resort->name }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $resort->email }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $resort->contactNo ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $resort->address ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        ⭐ {{ number_format($resort->avg_rating, 1) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
