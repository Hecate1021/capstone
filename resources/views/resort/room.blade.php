@extends('design.header')
@section('content')
    @include('design.navbar')
    @include('design.profile-header')

    <div class="mt-5 md:mb-5 ">
        @if ($isOwner)
            <div class="mb-5 mt-5">
                <a href="{{ route('room.create') }}" class="px-2 py-2 rounded-md   text-gray-100 bg-blue-600">
                    Add Room</a>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 h-50 ">
            @foreach ($rooms as $room)
                <article class="rounded-xl bg-white p-3 shadow-lg hover:shadow-xl h-full border border-gray-300">

                    <div id="carouselExampleIndicators1{{ $loop->index }}" class="relative" data-twe-carousel-init
                        data-twe-ride="carousel">
                        <!-- Carousel indicators -->
                        <div class="absolute bottom-0 left-0 right-0 z-[2] mx-[15%] mb-4 flex list-none justify-center p-0"
                            data-twe-carousel-indicators>
                            @foreach ($room->images as $index => $image)
                                <div class="relative">
                                    <button type="button"
                                        data-twe-target="#carouselExampleIndicators{{ $loop->parent->index }}"
                                        data-twe-slide-to="{{ $index }}"
                                        class="mx-[3px] box-content h-[3px] w-[30px] flex-initial cursor-pointer border-0 border-y-[10px] border-solid border-transparent bg-white bg-clip-padding p-0 -indent-[999px] opacity-50 transition-opacity duration-[600ms] ease-[cubic-bezier(0.25,0.1,0.25,1.0)] motion-reduce:transition-none"
                                        aria-label="Slide {{ $index + 1 }}"
                                        @if ($index == 0) aria-current="true" data-twe-carousel-active @endif></button>

                                </div>
                            @endforeach
                        </div>


                        <!-- Carousel items -->
                        <div
                            class="relative w-full rounded-md overflow-hidden after:clear-both after:block after:content-[''] md:h-56 h-60">
                            @foreach ($room->images as $index => $image)
                                <div class="relative float-left -mr-[100%] w-full h-full transition-transform duration-[600ms] ease-in-out motion-reduce:transition-none"
                                    @if ($index == 0) data-twe-carousel-item data-twe-carousel-active @else hidden data-twe-carousel-item @endif>
                                    <img src="{{ asset('storage/images/' . $image->path) }}"
                                        class="block w-full h-full object-cover" alt="{{ $image->name }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Carousel controls - prev item -->
                        <button
                            class="absolute bottom-0 left-0 top-0 z-[1] flex w-[15%] items-center justify-center border-0 bg-none p-0 text-center text-white opacity-50 transition-opacity duration-150 ease-[cubic-bezier(0.25,0.1,0.25,1.0)] hover:text-white hover:no-underline hover:opacity-90 hover:outline-none focus:text-white focus:no-underline focus:opacity-90 focus:outline-none motion-reduce:transition-none"
                            type="button" data-twe-target="#carouselExampleIndicators1{{ $loop->index }}"
                            data-twe-slide="prev">
                            <span class="inline-block h-8 w-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </span>
                            <span
                                class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Previous</span>
                        </button>
                        <!-- Carousel controls - next item -->
                        <button
                            class="absolute bottom-0 right-0 top-0 z-[1] flex w-[15%] items-center justify-center border-0 bg-none p-0 text-center text-white opacity-50 transition-opacity duration-150 ease-[cubic-bezier(0.25,0.1,0.25,1.0)] hover:text-white hover:no-underline hover:opacity-90 hover:outline-none focus:text-white focus:no-underline focus:opacity-90 focus:outline-none motion-reduce:transition-none"
                            type="button" data-twe-target="#carouselExampleIndicators1{{ $loop->index }}"
                            data-twe-slide="next">
                            <span class="inline-block h-8 w-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </span>
                            <span
                                class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Next</span>
                        </button>
                    </div>


                    <div class="mt-1 p-2">
                        <h2 class="text-slate-700">{{ $room->name }}</h2>
                        <p class="text-slate-400 text-sm">{{ $room->description }}</p>

                        <div class="mt-3 flex items-center justify-between">
                            <div class="flex items-center">
                                <p class="mr-2">
                                    <span class="text-lg font-bold text-blue-500">${{ $room->price }}</span>
                                    <span class="text-slate-400 text-sm">/night</span>
                                </p>

                            </div>
                            </a>

                            @auth
                            <div>
                                @if (Auth::user()->role === 'resort')
                                <a href="{{url('resort/roomEdit', $room->id) }}"
                                    class="m-2 rounded-md bg-blue-500 text-white p-1.5 hover:bg-blue-200 hover:text-black focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <span class="ml-1">Edit</span>
                                </a>
                                    <!-- Delete button -->
                                    <button type="button" data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                                        class="rounded-full bg-red-500 text-white p-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        <i class="fas fa-trash-alt"></i> <!-- Font Awesome trash icon -->
                                    </button>


                                    @else
                                    <a href="{{ Auth::check() ? route('room.book', $room->id) : route('login') }}"
                                        class="rounded-md bg-blue-500 text-white p-1.5 hover:bg-blue-200 hover:text-black focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        <i class="fas fa-calendar-plus fa-sm"></i> <!-- Font Awesome calendar-plus icon -->
                                        <span class="ml-1">Book Now</span>
                                    </a>

                                @endif
                            @endauth
                        </div>
                        </div>
                    </div>

                </article>
            @endforeach
        </div>
        <div class="p-10">
            {{-- loading --}}
        </div>
        @if ($isOwner)
            {{-- modal Delete --}}
            <div id="popup-modal" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to
                                delete
                                this item?</h3>
                            @foreach ($rooms as $room)
                                <form action="{{ route('room.destroy', $room->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                            @endforeach
                            <button data-modal-hide="popup-modal" type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                            </form>

                            <button data-modal-hide="popup-modal" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endsection
