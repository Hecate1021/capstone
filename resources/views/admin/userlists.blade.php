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
                        Print Users List
                    </button>
                </div>

                <!-- Table with print-friendly styles -->
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
                    <h1 class="text-center text-2xl font-bold mb-4">User List</h1>
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Date of Verified</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($users as $user)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm font-semibold">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-xs">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight {{ $user->role == 'admin' ? 'text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100' : 'text-blue-700 bg-blue-100 dark:bg-blue-700 dark:text-blue-100' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->format('m/d/Y') : 'Not Verified' }}
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
