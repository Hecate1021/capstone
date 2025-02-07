@extends('design.header')
@section('content')
<div class="flex items-center min-h-screen p-6 bg-gray-100">
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl">
        <div class="flex flex-col overflow-y-auto md:flex-row">
            <div class="h-32 md:h-auto md:w-1/2">
                <img aria-hidden="true" class="object-cover w-full h-full"
                    src="{{asset('images/lake-sebu.jpg')}}" alt="Office" />
            </div>
            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <div class="w-full">
                    <h1 class="mb-4 text-xl font-semibold text-gray-700">
                        Create account
                    </h1>
                    <form method="POST" action="{{ route('user.RegisterStore') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Name -->
                        <label class="block text-sm">
                            <span class="text-gray-700">Name</span>
                            <input
                                class="block w-full mt-1 text-sm border-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                placeholder="Jane Doe" name="name" value="{{ old('name') }}" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </label>

                        <!-- Email -->
                        <label class="block text-sm mt-4">
                            <span class="text-gray-700">Email</span>
                            <input
                                class="block w-full mt-1 text-sm border-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                placeholder="example@gmail.com" name="email" value="{{ old('email') }}" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </label>

                        <!-- Contact Number -->
                        <label class="block text-sm mt-4">
                            <span class="text-gray-700">Contact Number</span>
                            <input
                                class="block w-full mt-1 text-sm border-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                placeholder="09 1234 123" name="contact_number" value="{{ old('contact_number') }}" />
                            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                        </label>

                        <!-- Address -->
                        <label class="block text-sm mt-4">
                            <span class="text-gray-700">Address</span>
                            <input
                                class="block w-full mt-1 text-sm border-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                placeholder="123 Main St, City, Country" name="address" value="{{ old('address') }}" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </label>

                        <!-- Password -->
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700">Password</span>
                            <input
                                class="block w-full mt-1 text-sm border-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                placeholder="***************" type="password" name="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </label>

                        <!-- Confirm Password -->
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700">Confirm Password</span>
                            <input
                                class="block w-full mt-1 text-sm border-gray-300 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                placeholder="***************" type="password" name="password_confirmation" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </label>

                        <!-- Profile Picture -->
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700">Profile Picture</span>
                            <input type="file" class="filepond" name="image" multiple credits="false" />
                            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                        </label>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Create account
                        </button>
                    </form>

                        <hr class="my-8" />

                        <a href="{{ route('auth.redirection','google') }}"
                            class="flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                            <span class="w-8 h-8 mr-2">
                                <svg width="30px" height="30px" viewBox="-408.69 -408.69 2094.53 2094.53"
                                    xmlns="http://www.w3.org/2000/svg" fill="#000000" stroke="#000000"
                                    stroke-width="10.217192">
                                    <path
                                        d="M1179.439 7.087c57.543 0 104.627 47.083 104.627 104.626v30.331l-145.36 103.833-494.873 340.894L148.96 242.419v688.676h-37.247c-57.543 0-104.627-47.082-104.627-104.625V111.742C7.086 54.198 54.17 7.115 111.713 7.115l532.12 394.525L1179.41 7.115l.029-.028z"
                                        fill="#e75a4d"></path>
                                    <path fill="url(#a)" d="M111.713 7.087l532.12 394.525L1179.439 7.087z"></path>
                                    <path fill="#e7e4d7" d="M148.96 242.419v688.676h989.774V245.877L643.833 586.771z">
                                    </path>
                                    <path fill="#b8b7ae" d="M148.96 931.095l494.873-344.324-2.24-1.586L148.96 923.527z">
                                    </path>
                                    <path fill="#b7b6ad" d="M1138.734 245.877l.283 685.218-495.184-344.324z"></path>
                                    <path
                                        d="M1284.066 142.044l.17 684.51c-2.494 76.082-35.461 103.238-145.219 104.514l-.283-685.219 145.36-103.833-.028.028z"
                                        fill="#b2392f"></path>
                                </svg>
                            </span>
                            Sign up with Gmail
                        </a>

                        <p class="mt-4">
                            <a class="text-sm font-medium text-purple-600 hover:underline"
                                href="{{ route('login') }}">
                                Already have an account? Login
                            </a>
                        </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
