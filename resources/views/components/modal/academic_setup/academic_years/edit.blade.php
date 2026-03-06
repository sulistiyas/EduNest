<form action="{{ route('academic_year.update', $year->academic_year_id) }}" method="POST" enctype="multipart/form-data" id="editacademicYearForm" name="editacademicYearForm">
    @csrf
    <div class="modal fade" id="modal_academic_year_edit" tabindex="-1" role="dialog" aria-labelledby="modal_academic_yearLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_academic_yearLabel">Edit Academic Year</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_academic_year_name">Academic Year Name</label>
                        <input type="text" class="form-control" id="update_academic_year_name" name="update_academic_year_name" placeholder="Enter Academic Year Name" value="{{ $year->year_name }}" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="update_start_date">Start Date</label>
                        <input type="date" class="form-control" id="update_start_date" name="update_start_date" value="{{ $year->start_date }}" required>
                    </div>
                    <div class="form-group">
                        <label for="update_end_date">End Date</label>
                        <input type="date" class="form-control" id="update_end_date" name="update_end_date" value="{{ $year->end_date }}" required>
                    </div>
                    <div class="form-group">
                        <label for="update_is_active">Is Active</label>
                        <select class="form-control" id="update_is_active" name="update_is_active" required>
                            <option value="1" {{ $year->is_active == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $year->is_active == 0 ? 'selected' : '' }}>No</option>
                        </select>
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