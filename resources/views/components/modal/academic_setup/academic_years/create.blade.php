<form action="{{ route('academic_year.store') }}" method="POST" enctype="multipart/form-data" id="createacademicYearForm" name="createacademicYearForm">
    @csrf
    <div class="modal fade" id="modal_academic_year_create" tabindex="-1" role="dialog" aria-labelledby="modal_academic_yearLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_academic_yearLabel">Create Academic Year</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create_academic_year_name">Academic Year Name</label>
                        <select name="create_academic_year_name" id="create_academic_year_name" class="form-control select2" required>
                            <option value="" disabled selected>Select Academic Year</option>
                            @for ($year = date('Y'); $year >= date('Y') - 6; $year--)
                                <option value="{{ $year }}/{{ $year + 1 }}">{{ $year }}/{{ $year + 1 }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="create_start_date">Start Date</label>
                        <input type="date" class="form-control" id="create_start_date" name="create_start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="create_end_date">End Date</label>
                        <input type="date" class="form-control" id="create_end_date" name="create_end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="create_is_active">Is Active</label>
                        <select class="form-control" id="create_is_active" name="create_is_active" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
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