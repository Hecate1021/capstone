@extends('layout.header')
@include('layout.balai-navbar')
<div class="py-12" style="margin-top: 70px">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="container my-4 d-flex justify-content-center">
            <div class="bg-white shadow-sm rounded p-4" style="max-width: 600px;">
                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    <div class="text-center mb-4 position-relative" style="display: inline-block;">
                        <img src="{{ asset(($userInfo && $userInfo->profilePath) ? 'storage/images/' . $userInfo->profilePath : 'images/default-avatar.png') }}"
                        alt="Profile Picture" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">


                        <!-- Camera Icon Trigger for Modal -->
                        <span class="position-absolute d-flex align-items-center justify-content-center"
                            style="bottom: 0; right: 0; background-color: white; border-radius: 50%; width: 30px; height: 30px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); cursor: pointer;"
                            data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                            <i class="fas fa-camera" style="color: #007bff; font-size: 16px;"></i>
                        </span>
                    </div>



                </div>
                <!-- Upload Photo Modal -->
                <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadPhotoModalLabel">Upload Profile Photo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('profilePhoto') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch') <!-- Add this line to specify the PATCH method -->
                                    <div class="mb-3">
                                        <label for="profilePhoto" class="form-label">Choose a new profile photo</label>
                                        <input type="file" class="filepond" name="image" multiple credits="false" />
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Upload Photo</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>


                <!-- Profile Information Section -->
                <div class="text-center">
                    <h2 class="h5 text-dark mb-1">Profile Information</h2>
                    <p class="text-muted small">Update your account's profile information and email address.</p>
                </div>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                    @csrf
                    @method('patch')

                    <!-- Name Input -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" name="name" type="text" class="form-control text-center"
                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control text-center"
                            value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="mt-2">
                                <p class="text-muted small">
                                    Your email address is unverified.
                                    <button form="send-verification" class="btn btn-link p-0 small">Click here to
                                        re-send the verification email.</button>
                                </p>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="text-success small">A new verification link has been sent to your email
                                        address.</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Contact Number Input -->
                    <div class="mb-3">
                        <label for="contactNo" class="form-label">Contact No</label>
                        <input id="contactNo" name="contactNo" type="text" class="form-control text-center"
                            value="{{ old('contactNo', $userInfo->contactNo ?? '') }}" required pattern="\d{1,13}"
                            maxlength="13" oninput="this.value = this.value.replace(/\D/, '')">
                        @error('contactNo')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address Input -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input id="address" name="address" type="text" class="form-control text-center"
                            value="{{ old('address', $userInfo->address ?? '') }}" required>
                        @error('address')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description Input -->
                    {{-- <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input id="description" name="description" type="text" class="form-control text-center" value="{{ old('description', $userInfo->description ?? '') }}" required>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div> --}}

                    <!-- Save Button and Confirmation Message -->
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                        @if (session('status') === 'profile-updated')
                            <p class="text-success small mb-0">Saved.</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>



        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
