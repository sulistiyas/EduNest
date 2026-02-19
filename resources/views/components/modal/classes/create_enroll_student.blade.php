<form action="{{ route('enrollment.store') }}" method="POST" enctype="multipart/form-data" id="EnrollStudentForm" name="EnrollStudentForm">
    @csrf
    <div class="modal fade" id="modal_enrollment" tabindex="-1" role="dialog" aria-labelledby="modal_enrollmentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_enrollmentLabel">Enroll Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="class_id">Class Name</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="" disabled selected>Select Class</option>
                            @foreach($class_data as $class)
                                <option value="{{ $class->class_id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="select2-purple">
                            <label for="student_id">Student Name</label>
                            <select name="student_id[]" id="student_id" class="form-control select2" data-dropdown-css-class="select2-purple" multiple="multiple" required>
                                <option value="" disabled>Select Student</option>
                                @foreach($student_data as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
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
