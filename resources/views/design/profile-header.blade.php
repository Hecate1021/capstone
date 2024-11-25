<!-- Main Content with Margins -->
<div class="mx-4 md:mx-[15%]">
    <!-- Cover Photo Container -->
    <div class="relative mt-5 flex h-64 w-full items-center justify-center bg-gray-300">
        <!-- Main Image -->
        <img aria-hidden="true" class="object-cover w-full h-full shadow"
            src="{{ $user->userinfo && $user->userinfo->coverPath ? asset('storage/images/' . $user->userinfo->coverPath) : asset('images/lake-sebu.jpg') }}"
            alt="Resort Cover Image" />
        <!-- Profile Photo Container -->
        <div
            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 md:left-8 md:translate-x-4 flex h-32 w-32 md:h-40 md:w-40 items-center justify-center rounded-full border-4 border-gray-300 bg-white">
            <img aria-hidden="true" class="object-cover rounded-full w-full h-full shadow"
                src="{{ $user->userinfo && $user->userinfo->profilePath ? asset('storage/images/' . $user->userinfo->profilePath) : asset('images/default-avatar.png') }}"
                alt="Office" />
            <!-- Camera Icon on Profile Photo -->
            <!-- Profile Photo Button -->
            @if ($isOwner)
                <div
                    class="absolute bottom-0 right-0 md:bottom-2 md:right-2 h-8 w-8 md:h-10 md:w-10 bg-gray-400 text-white flex items-center justify-center rounded-full cursor-pointer hover:bg-blue-500 hover:shadow-lg transition duration-300">
                    <button type="button" class="fas fa-camera" data-twe-toggle="modal"
                        data-twe-target="#staticBackdropProfilePhoto" data-twe-ripple-init
                        data-twe-ripple-color="light"></button>
                </div>
            @endif

        </div>
        @if ($isOwner)
            <!-- Cover Photo Button -->
            <div
                class="absolute bottom-0 right-0 md:bottom-2 md:right-2 h-8 w-8 md:h-10 md:w-10 bg-gray-400 text-white flex items-center justify-center rounded-full cursor-pointer hover:bg-blue-500 hover:shadow-lg transition duration-300">
                <button type="button" class="fas fa-camera" data-twe-toggle="modal"
                    data-twe-target="#staticBackdropCoverPhoto" data-twe-ripple-init
                    data-twe-ripple-color="light"></button>
            </div>
        @endif
    </div>

    <div class="bg-white border border-gray-300 shadow-lg md:mt-0">
        <!-- Profile Information -->
        <div class="flex flex-col justify-between md:flex-row items-center md:items-start md:ml-16 p-6 md:space-x-4">
            <div class="text-center md:text-left  mt-12 md:ml-36 md:-mt-4">
                <h1 class="text-2xl font-semibold">{{ $user->name }}</h1>
                <p class="text-gray-600">
                    @if (is_null($averageRating))
                    {{-- Display some default value or message when $averageRating is null --}}
                    {{ '0' }}
                @elseif (is_int($averageRating))
                    {{ $averageRating }}
                @else
                    {{ number_format($averageRating, 1) }}
                @endif
                    Rating
                </p>
            </div>
            @if ($isOwner)
                <div class="flex space-x-4 mt-4 md:mt-0 md:ml-auto md:mr-10">
                    <a href="{{ route('profile.edit') }}" class="rounded-md bg-blue-500 px-4 py-2 text-white">Edit</a>
                    <a class="rounded-md bg-gray-500 px-4 py-2 text-white">Dashboard</a>
                </div>
            @endif
        </div>
    </div>

    <div
        class="flex flex-wrap rounded-b-lg justify-center shadow-lg space-x-4 px-4 pb-8 border bg-white border-gray-300">
        <div class="mt-2 flex flex-wrap justify-center space-x-4 ">
            @if (Auth::user()->role === 'user')
            <a href="{{ route('resort.profiles', $user->name) }}"
                class="text-lg font-semibold {{ request()->routeIs('resort.profiles') ? 'text-blue-600 underline' : 'text-gray-600' }}">Post</a>
            <a href="{{ route('resort.Room', $user->name) }}"
                class="text-lg font-semibold {{ request()->routeIs('resort.Room') ? 'text-blue-600 underline' : 'text-gray-600' }}">Room</a>
                @endif

                @if (Auth::user()->role === 'resort')
            <a href="{{ route('resort.profile') }}"
                class="text-lg font-semibold {{ request()->routeIs('resort.profile') ? 'text-blue-600 underline' : 'text-gray-600' }}">Post</a>
            <a href="{{ route('resort.room') }}"
                class="text-lg font-semibold {{ request()->routeIs('resort.room') ? 'text-blue-600 underline' : 'text-gray-600' }}">Room</a>
                @endif
            <a href="#" class="text-gray-600 text-lg font-semibold">Event</a>
            <a href="#" class="text-gray-600 text-lg font-semibold">Menus</a>
            <a href="#" class="text-gray-600 text-lg font-semibold">Services</a>
            <a href="#" class="text-gray-600 text-lg font-semibold">Review</a>
        </div>
    </div>

    <!-- Profile Photo Modal -->
    <div data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="staticBackdropProfilePhoto" data-twe-backdrop="static" data-twe-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div data-twe-modal-dialog-ref
            class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
                <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                    <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLabel">
                        Change Profile Photo
                    </h5>
                    <button type="button"
                        class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                        data-twe-modal-dismiss aria-label="Close">
                        <span class="[&>svg]:h-6 [&>svg]:w-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </button>
                </div>
                <form action="{{ route('profilePhoto') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="m-4" data-twe-modal-body-ref>
                        <input type="file" class="filepond" id="profilePhotoInput" name="image" multiple
                            credits="false" />
                    </div>
                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4 dark:border-white/10">
                        <button type="submit"
                            class="inline-block rounded bg-primary px-6 mr-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                            data-twe-ripple-init data-twe-ripple-color="light">
                            Change Profile
                        </button>
                </form>
                <button type="button"
                    class="ms-1 inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-200 focus:bg-primary-accent-200 focus:outline-none focus:ring-0 active:bg-primary-accent-200 dark:bg-primary-300 dark:hover:bg-primary-400 dark:focus:bg-primary-400 dark:active:bg-primary-400"
                    data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="light">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<div data-twe-modal-init
    class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="staticBackdropCoverPhoto" data-twe-backdrop="static" data-twe-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div data-twe-modal-dialog-ref
        class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
        <div
            class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLabel">
                    Change Cover Photo
                </h5>
                <button type="button"
                    class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                    data-twe-modal-dismiss aria-label="Close">
                    <span class="[&>svg]:h-6 [&>svg]:w-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </button>
            </div>
            <form action="{{ route('coverPhoto') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="m-4" data-twe-modal-body-ref>
                    <input type="file" class="filepond" id="coverPhotoInput" name="image" multiple
                        credits="false" />
                </div>
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4 dark:border-white/10">
                    <button type="submit"
                        class="inline-block rounded bg-primary px-6 mr-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                        data-twe-ripple-init data-twe-ripple-color="light">
                        Change Profile
                    </button>
            </form>
            <button type="button"
                class="ms-1 inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-200 focus:bg-primary-accent-200 focus:outline-none focus:ring-0 active:bg-primary-accent-200 dark:bg-primary-300 dark:hover:bg-primary-400 dark:focus:bg-primary-400 dark:active:bg-primary-400"
                data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="light">
                Close
            </button>
        </div>
    </div>
</div>
</div>
