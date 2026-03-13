<form action="{{ route('schedule.store') }}" method="POST" id="ScheduleForm">
@csrf
<div class="modal fade" id="modal_schedule_create" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Schedule</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!-- Class Subject -->
                <div class="form-group">
                    <label>Class & Subject</label>
                    <select name="class_subject_id" class="form-control" required>
                        <option disabled selected>Select Class Subject</option>
                        @foreach($classSubjects as $cs)
                        <option value="{{ $cs->class_subject_id }}">
                            {{ $cs->class_name }} - {{ $cs->subject_name }} <strong>({{ $cs->teacher_name }})</strong>
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester -->
                <div class="form-group">
                    <label>Semester</label>
                    <select name="semester_id" class="form-control" required>
                        <option disabled>Select Semester</option>
                        @foreach($semesters as $semester)
                        <option value="{{ $semester->semester_id }}">
                            {{ $semester->semester_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Day -->
                <div class="form-group">
                    <label>Day</label>
                    <select name="day_of_week" class="form-control" required>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                    </select>
                </div>

                <!-- Start Time -->
                <div class="form-group">
                    <label>Start Time</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>

                <!-- End Time -->
                <div class="form-group">
                    <label>End Time</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>

                <!-- Room -->
                <div class="form-group">
                    <label>Room</label>
                    <input type="text" name="room" class="form-control" placeholder="Example: R101">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Schedule</button>
            </div>

        </div>
    </div>
</div>
</form>