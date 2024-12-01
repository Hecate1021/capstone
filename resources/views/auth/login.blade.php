@extends('design.header')
@section('content')
    <div class="flex items-center min-h-screen p-6 bg-white">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full" src="{{ asset('images/lake-sebu.jpg') }}"
                        alt="Office" />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700">
                            Login
                        </h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <label class="block text-sm">
                                <span class="text-gray-700">Email</span>
                                <input
                                    class="block w-full mt-1 text-sm border-gray-300 bg-white focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-gray-700 form-input"
                                    placeholder="example@gmail.com" name="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700">Password</span>
                                <input
                                    class="block w-full mt-1 text-sm border-gray-300 bg-white focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-gray-700 form-input"
                                    placeholder="***************" type="password" name="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </label>

                            <button type="submit"
                                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Log in
                            </button>

                            <hr class="my-8" />
                        </form>
                        <!-- Facebook Login Button -->
                        <button
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                            <svg class="w-4 h-4 mr-2" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M22.675 0h-21.35C.6 0 0 .6 0 1.35v21.3c0 .75.6 1.35 1.35 1.35h11.5v-9.3h-3.1v-3.6h3.1v-2.7c0-3.1 1.9-4.8 4.6-4.8 1.3 0 2.5.1 2.8.1v3.2h-1.9c-1.5 0-1.8.7-1.8 1.7v2.5h3.5l-.5 3.6h-3v9.3h5.9c.75 0 1.35-.6 1.35-1.35V1.35C24 .6 23.4 0 22.675 0z" />
                            </svg>
                            Facebook
                        </button>

                        <a href="{{ route('auth.google') }}"
    class="flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
    <span class="w-8 h-8 mr-2">
        <svg width="30px" height="30px" viewBox="-408.69 -408.69 2094.53 2094.53" xmlns="http://www.w3.org/2000/svg" fill="#000000" stroke="#000000" stroke-width="10.217192">
            <path d="M1179.439 7.087c57.543 0 104.627 47.083 104.627 104.626v30.331l-145.36 103.833-494.873 340.894L148.96 242.419v688.676h-37.247c-57.543 0-104.627-47.082-104.627-104.625V111.742C7.086 54.198 54.17 7.115 111.713 7.115l532.12 394.525L1179.41 7.115l.029-.028z" fill="#e75a4d"></path>
            <path fill="url(#a)" d="M111.713 7.087l532.12 394.525L1179.439 7.087z"></path>
            <path fill="#e7e4d7" d="M148.96 242.419v688.676h989.774V245.877L643.833 586.771z"></path>
            <path fill="#b8b7ae" d="M148.96 931.095l494.873-344.324-2.24-1.586L148.96 923.527z"></path>
            <path fill="#b7b6ad" d="M1138.734 245.877l.283 685.218-495.184-344.324z"></path>
            <path d="M1284.066 142.044l.17 684.51c-2.494 76.082-35.461 103.238-145.219 104.514l-.283-685.219 145.36-103.833-.028.028z" fill="#b2392f"></path>
        </svg>
    </span>
    Login with Gmail
</a>





                        <p class="mt-4">
                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-purple-600 hover:underline"
                                    href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>
                            @endif
                        </p>
                        <p class="mt-1">
                            <a class="text-sm font-medium text-purple-600 hover:underline" href="{{ route('register') }}">
                                Create account
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
