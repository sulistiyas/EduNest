<form action="{{ route('subject.update', $subject->subject_id) }}" method="POST" enctype="multipart/form-data" id="editsubjectForm" name="editsubjectForm">
    @csrf
    <div class="modal fade" id="modal_subject_edit" tabindex="-1" role="dialog" aria-labelledby="modal_subjectLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_subjectLabel">Edit Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_subject_name">Subject Name</label>
                        <input type="text" class="form-control" id="update_subject_name" name="update_subject_name" placeholder="Enter Subject Name" value="{{ $subject->subject_name }}" required>
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