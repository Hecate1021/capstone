@extends('layout.header')
@include('layout.balai-navbar')
<div class="py-12" style="margin-top: 70px">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="container my-5 d-flex justify-content-center">
            <div class="bg-white shadow-sm rounded p-4" style="max-width: 600px; width: 100%;">

                <!-- Cover Photo Section -->
                @if (auth()->user()->role === 'resort')
                    <div class="position-relative"
                        style="width: 100%; height: 200px; background-color: #f8f9fa; border-radius: 10px; overflow: hidden;">
                        <img class="object-fit-cover w-100 h-100"
                            src="{{ $user->userinfo && $user->userinfo->coverPath ? asset('storage/images/' . $user->userinfo->coverPath) : asset('images/lake-sebu.jpg') }}"
                            alt="Cover Image">

                        <!-- Camera Icon (Cover Photo) -->
                        <div class="position-absolute d-flex align-items-center justify-content-center"
                            style="bottom: 10px; left: 10px; width: 35px; height: 35px; background-color: rgba(255, 255, 255, 0.8); color: #007bff; border-radius: 50%; cursor: pointer; transition: 0.3s;"
                            onmouseover="this.style.backgroundColor='#007bff'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.8)'; this.style.color='#007bff';"
                            data-bs-toggle="modal" data-bs-target="#staticBackdropCoverPhoto">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                @endif

                <!-- Profile Picture Section -->
                <div class="position-relative d-flex justify-content-center" style="margin-top: -50px;">
                    <div class="position-relative"
                        style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; background-color: white; border: 3px solid white;">
                        <img src="{{ asset($userInfo && $userInfo->profilePath ? 'storage/images/' . $userInfo->profilePath : 'images/default-avatar.png') }}"
                            alt="Profile Picture" class="w-100 h-100 rounded-circle" style="object-fit: cover;">
                    </div>

                    <!-- Camera Icon (Profile Picture) -->
                    <div class="position-absolute d-flex align-items-center justify-content-center"
                        style="bottom: 5px; right: 5px; background-color: rgba(255, 255, 255, 0.8); border-radius: 50%; width: 30px; height: 30px; cursor: pointer; box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);"
                        data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                        <i class="fas fa-camera" style="color: #007bff;"></i>
                    </div>
                </div>

                <!-- Profile Information Section -->
                <div class="text-center mt-3">
                    <h2 class="h5 text-dark">Profile Information</h2>
                    <p class="text-muted small">Update your account's profile information and email address.</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="mt-3">
                    @csrf
                    @method('patch')

                    <!-- Name Input -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" name="name" type="text" class="form-control w-100"
                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control w-100"
                            value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Number Input -->
                    <div class="mb-3">
                        <label for="contactNo" class="form-label">Contact No</label>
                        <input id="contactNo" name="contactNo" type="text" class="form-control w-100"
                            value="{{ old('contactNo', $userInfo->contactNo ?? '') }}" required pattern="\d{1,13}"
                            maxlength="13" oninput="this.value = this.value.replace(/\D/, '')">
                        @error('contactNo')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address Input -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input id="address" name="address" type="text" class="form-control w-100"
                            value="{{ old('address', $userInfo->address ?? '') }}" required>
                        @error('address')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description Input (Only for Resort Role) -->
                    @if (auth()->user()->role === 'resort')
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input id="description" name="description" type="text" class="form-control w-100"
                                value="{{ old('description', $userInfo->description ?? '') }}" required>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <!-- Save Button -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                        @if (session('status') === 'profile-updated')
                            <p class="text-success small ms-3 mb-0">Saved.</p>
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

    <!-- Upload profile Photo Modal -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadPhotoModalLabel">Upload Profile Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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


    <!-- Upload Cover Photo Modal -->
    <div class="modal fade" id="staticBackdropCoverPhoto" data-bs-backdrop="true" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change Cover Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('coverPhoto') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <input type="file" class="filepond" id="coverPhotoInput" name="image" multiple
                            credits="false" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Change Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
