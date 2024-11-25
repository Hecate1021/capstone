@extends('design.header')
@section('content')
    @include('design.navbar')

    <section class="relative md:pt-72 md:pb-60 py-24 md:py-36 table w-full items-center bg-top bg-no-repeat bg-cover" style="background-image: url('{{ asset('images/lake-sebu.jpg') }}');">
        <div class="absolute inset-0 bg-slate-900/40"></div>
        <div class="container mx-auto relative">
            <div class="grid md:grid-cols-12 grid-cols-1 items-center mt-10 gap-8">
                <div class="lg:col-span-8 md:col-span-7 md:order-1 order-2">
                    <h5 class="text-3xl font-dancing text-white">Beauty of Discover</h5>
                    <h4 class="font-bold text-white lg:leading-normal leading-normal text-4xl lg:text-6xl mb-6 mt-5">Let's Leave The Road, <br> And Take The Travosy</h4>
                    <p class="text-white/70 text-xl max-w-xl">Planning for a trip? We will organize your trip with the best places and within best budget!</p>
                </div>

                <div class="lg:col-span-4 md:col-span-5 md:text-center md:order-2 order-last">
                    <a href="#!"
                       class="inline-flex items-center lg:h-12 h-10 w-50 rounded-full shadow-lg bg-white hover:bg-red-500 text-red-500 hover:text-white duration-500 ease-in-out mx-auto px-4 py-2">
                        <i class="fas fa-compass text-xl mr-2"></i>
                        <span class="text-xl font-semibold">Explore</span>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <section class="py-16 overflow-hidden">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 pb-8 text-center">
                <h3 class="mb-6 md:text-3xl text-2xl md:leading-normal leading-normal font-semibold">Top Resort</h3>
                <p class="text-slate-400 max-w-xl mx-auto">Planning for a trip? We will organize your trip with the best
                    places and within best budget!</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ( $users as $user)
    <div class="group rounded-md shadow dark:shadow-gray-700 border border-gray-300 sm:w-96 w-full mx-auto mb-4">
        <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 mx-3 mt-3 h-80" >
            <img src="{{ $user->userInfo && $user->userInfo->profilePath ? asset('storage/images/' . $user->userInfo->profilePath) : asset('images/default-avatar.png') }}"
                class="w-full h-full object-cover scale-125 group-hover:scale-100 duration-500" alt="Profile Photo">
            <div class="absolute top-0 right-0 p-4">
                <a href="javascript:void(0)"
                    class="w-8 h-8 inline-flex justify-center items-center bg-white dark:bg-slate-900 shadow dark:shadow-gray-800 rounded-full text-slate-100 dark:text-slate-700 focus:text-red-500 dark:focus:text-red-500 hover:text-red-500 dark:hover:text-red-500">
                    <i class="fas fa-heart text-[20px] align-middle"></i>
                </a>
            </div>
        </div>
        <div class="p-4">
            <p class="flex items-center text-slate-400 font-medium mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-map-pin text-red-500 w-4 h-4 mr-1">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                @if ($user->userInfo && $user->userInfo->address)
            {{ $user->userInfo->address }}
            @endif
            </p>
            <a href="tour-detail-one.html"
                class="text-lg font-medium hover:text-red-500 duration-500 ease-in-out">{{$user->name}}</a>

            <div class="flex items-center mt-2">
                <span class="text-slate-400">Rating:</span>
                <ul class="text-lg font-medium text-amber-400 list-none ml-2">
                    <li class="inline"><i class="fas fa-star align-middle"></i></li>
                    <li class="inline"><i class="fas fa-star align-middle"></i></li>
                    <li class="inline"><i class="fas fa-star align-middle"></i></li>
                    <li class="inline"><i class="fas fa-star align-middle"></i></li>
                    <li class="inline"><i class="fas fa-star align-middle"></i></li>
                    <li class="inline text-black dark:text-white text-sm">5.0(30)</li>
                </ul>
            </div>
            <div>
                <a href="{{route('resort.profiles', $user->name)}}" class="mt-4 pt-4 flex justify-between items-center border-t border-slate-100 dark:border-gray-800 text-slate-400 hover:text-red-500">
                    Explore Now <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach

            </div>
        </div>
    </section>
@endsection
