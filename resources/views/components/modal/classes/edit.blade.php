<form action="{{ route('class.update', $class->class_id) }}" method="POST" enctype="multipart/form-data" id="editclassForm" name="editclassForm">
    @csrf
    <div class="modal fade" id="modal_class_edit" tabindex="-1" role="dialog" aria-labelledby="modal_classLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_classLabel">Edit Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_class_name">Class Name</label>
                        <input type="text" class="form-control" id="update_class_name" name="update_name" placeholder="Enter Class Name" value="{{ $class->name }}" required>
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