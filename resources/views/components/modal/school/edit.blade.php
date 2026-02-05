<form action="{{ route('school.update', ['id' => $school->school_id]) }}" method="POST" enctype="multipart/form-data" id="editSchoolForm" name="editSchoolForm" class="edit-school-form">
    @csrf
    <div class="modal fade" id="modal_school_edit" tabindex="-1" role="dialog" aria-labelledby="modal_edit_schoolLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_edit_schoolLabel">Update School Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">School Name</label>
                        <input type="text" class="form-control" id="update_name" name="update_name" value="{{ $school->name }}" placeholder="Enter School Name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="update_address" name="update_address" value="{{ $school->address }}" placeholder="Enter Address" required>
                    </div>
                    <div class="form-group">
                        <label for="update_phone">Contact Number</label>
                        <input type="text" class="form-control" id="update_phone" name="update_phone" value="{{ $school->phone }}" placeholder="Enter Contact Number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="update_email" name="update_email" value="{{ $school->email }}" placeholder="Enter Email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- Custom CSS for update Button --}}
{{-- <script>
    document.querySelectorAll('.edit-school-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Save Updated Data?',
                text: 'School data will be updated.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    }); 
</script> --}}

