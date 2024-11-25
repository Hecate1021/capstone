@extends('design.header')


@section('content')
    @include('design.navbar')
    @include('design.sidebar')

    <div class="p-4 sm:ml-64 mt-10">
        <div class="p-4 rounded-lg dark:border-gray-700">

            <div class="overflow-x-auto mt-5">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">User</th>
                            <th class="py-3 px-6 text-left">Review</th>
                            <th class="py-3 px-6 text-left">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($reviews as $review)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <!-- User Name -->
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $review->user->name }}</td>

                                <!-- Review -->
                                <td class="py-3 px-6 text-left">{{ $review->review }}</td>

                                <!-- Rating -->
                                <td class="py-3 px-6 text-left">
                                    <!-- Show stars or numeric rating -->
                                    <div class="star-rating" style="font-size: 2em;"> <!-- Add a custom style to increase the size -->
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="text-yellow-500">
                                                @if ($i <= $review->rating)
                                                    ★ <!-- Filled Star -->
                                                @else
                                                    ☆ <!-- Empty Star -->
                                                @endif
                                            </span>
                                        @endfor
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>


@endsection
