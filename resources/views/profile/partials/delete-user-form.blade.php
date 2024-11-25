<div class="container my-4 d-flex justify-content-center">
    <div class="bg-white shadow-sm rounded p-4" style="max-width: 600px;">
        <!-- Header -->
        <div class="text-center mb-4">
            <h2 class="h5 text-dark mb-2">Delete Account</h2>
            <p class="text-muted small">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </p>
        </div>

        <!-- Delete Account Button -->
        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
            Delete Account
        </button>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Are you sure you want to delete your account?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <p class="text-muted small">
                                Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                            </p>

                            <!-- Password Input -->
                            <div class="mb-3">
                                <label for="password" class="form-label visually-hidden">Password</label>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                                @if ($errors->userDeletion->has('password'))
                                    <div class="text-danger small">{{ $errors->userDeletion->first('password') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript for modal functionality (add at the end of your HTML file) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js"></script>
