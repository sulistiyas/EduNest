<form action="{{ route('subject.assignTeachers') }}" method="POST" enctype="multipart/form-data" id="AssignTeacherForm" name="AssignTeacherForm">
    @csrf
    <div class="modal fade" id="modal_assignTeacher" tabindex="-1" role="dialog" aria-labelledby="modal_assignTeacherLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_assignTeacherLabel">Assign Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="teacher_id">Teacher Name</label>
                        <select name="teacher_id" id="teacher_id" class="form-control" required>
                            <option value="" disabled selected>Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class_id">Class Name</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="" disabled selected>Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="select2-purple">
                            <label for="subject_id">Subject Name</label>
                            <select name="subject_id[]" id="subject_id" class="form-control select2" data-dropdown-css-class="select2-purple" multiple="multiple" required>
                                <option value="" disabled>Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                        </div>
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
