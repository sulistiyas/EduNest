<form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data" id="userFormupdate" name="userFormupdate">
    @csrf
    <div class="modal fade" id="modal_users_edit" tabindex="-1" role="dialog" aria-labelledby="modal_usersLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_usersLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="update_name" name="update_name" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="update_email" name="update_email" placeholder="Enter Email" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="update_password" name="update_password" placeholder="Enter Password" required>
                    </div> --}}
                    <div class="form-group">
                        <label for="school_id">School</label>
                        <select class="form-control" id="update_school_id" name="update_school_id" required>
                            <option value="" disabled>Select School</option>
                            @foreach($school_data as $school)
                                <option value="{{ $school->school_id }}">
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="update_role_id" name="update_role_id" required>
                            <option value="" disabled>Select Role</option>
                            @foreach($roles_data as $role)
                                <option value="{{ $role->role_id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </div>
        </div>
    </div>
</form>