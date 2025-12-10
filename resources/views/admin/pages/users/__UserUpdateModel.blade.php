<!-- Update User Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.update') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Update User Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="modal_name" class="form-label">Name</label>
                        <input type="text" name="name" id="modal_name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="modal_email" class="form-label">Email</label>
                        <input type="email" name="email" id="modal_email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <!-- Mobile -->
                    <div class="mb-3">
                        <label for="modal_mobile" class="form-label">Mobile</label>
                        <input type="text" name="mobile" id="modal_mobile" class="form-control" value="{{ $user->mobile }}" required>
                    </div>

                    <!-- Block Status -->
                    <div class="mb-3">
                        <label for="modal_is_block" class="form-label">Block Status</label>
                        <select name="is_block" id="modal_is_block" class="form-control" required>
                            <option value="0" {{ !$user->is_block ? 'selected' : '' }}>Unblocked</option>
                            <option value="1" {{ $user->is_block ? 'selected' : '' }}>Blocked</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
