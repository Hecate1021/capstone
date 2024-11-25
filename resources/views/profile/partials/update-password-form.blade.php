<div class="container my-4 d-flex justify-content-center">
    <div class="bg-white shadow-sm rounded p-4" style="max-width: 600px;">
        <!-- Section Header -->
        <div class="text-center mb-4">
            <h2 class="h5 text-dark mb-1">Update Password</h2>
            <p class="text-muted small">Ensure your account is using a long, random password to stay secure.</p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="mt-4">
            @csrf
            @method('put')

            <!-- Current Password Input -->
            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">Current Password</label>
                <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                @error('current_password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password Input -->
            <div class="mb-3">
                <label for="update_password_password" class="form-label">New Password</label>
                <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                @error('password_confirmation')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Save Button and Confirmation Message -->
            <div class="d-flex justify-content-center align-items-center gap-2">
                <button type="submit" class="btn btn-primary">Save</button>
                @if (session('status') === 'password-updated')
                    <p class="text-success small mb-0" style="animation: fadeOut 2s forwards;">Saved.</p>
                @endif
            </div>
        </form>
    </div>
</div>

<style>
    /* Optional: Fade-out effect for the Saved message */
    @keyframes fadeOut {
        0% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
