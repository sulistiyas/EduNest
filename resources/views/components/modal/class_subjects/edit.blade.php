<form action="{{ route('subject.assignTeachersUpdate') }}" method="POST" id="EditAssignForm">
    @csrf

    <input type="hidden" name="teacher_id" id="edit_teacher_id">
    <input type="hidden" name="class_id" id="edit_class_id">

    <div class="modal fade" id="modal_class_subject_edit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Teacher</label>
                        <input type="text" class="form-control" id="edit_teacher_name" readonly>
                    </div>

                    <div class="form-group">
                        <label>Class</label>
                        <input type="text" class="form-control" id="edit_class_name" readonly>
                    </div>

                    <div class="form-group">
                        <label>Subjects</label>
                        <div class="select2-purple">
                            <select name="subject_id[]" 
                                    id="edit_subject_id" 
                                    class="form-control select2"
                                    multiple required>

                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->subject_id }}">
                                        {{ $subject->subject_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-warning">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
