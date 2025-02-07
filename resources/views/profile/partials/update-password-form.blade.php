<div class="container my-5 d-flex justify-content-center">
    <div class="bg-white shadow-sm rounded p-4" style="max-width: 500px; width: 100%;">
        <!-- Section Header -->
        <div class="text-center mb-4">
            <h2 class="h5 text-dark mb-1">Update Password</h2>
            <p class="text-muted small">Ensure your account is using a strong password to stay secure.</p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="mt-4">
            @csrf
            @method('put')

            <!-- Current Password Input -->
            <div class="mb-3">
                <label for="current_password" class="form-label fw-bold">Current Password</label>
                <input id="current_password" name="current_password" type="password"
                    class="form-control form-control-lg w-100" autocomplete="current-password">
                @error('current_password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">New Password</label>
                <input id="password" name="password" type="password" class="form-control form-control-lg w-100"
                    autocomplete="new-password">
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="form-control form-control-lg w-100" autocomplete="new-password">
                @error('password_confirmation')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Save Button and Confirmation Message -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Update Password</button>
                @if (session('status') === 'password-updated')
                    <p class="text-success small mt-3 fade-out">Password updated successfully.</p>
                @endif
            </div>
        </form>
    </div>
</div>

<style>
    /* Fade-out effect for success message */
    .fade-out {
        animation: fadeOut 3s ease-in-out forwards;
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
            display: none;
        }
    }
</style>
