<form action="{{ route('class.store') }}" method="POST" enctype="multipart/form-data" id="classForm" name="classForm">
    @csrf
    <div class="modal fade" id="modal_class" tabindex="-1" role="dialog" aria-labelledby="modal_classLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_classLabel">Add Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Class Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Class Name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>