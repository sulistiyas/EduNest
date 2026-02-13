@include('components.header')
<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    @include('sweetalert::alert')
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('admin_lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div> --}}
        @include('components.navbar')
        @include('components.sidebar')
        <!--begin::App Main-->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0"></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item active"> Assign Teachers</li>
                                    <li class="breadcrumb-item"><a href="{{ route('dash') }}">Home</a></li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        @if(Auth::user()->hasRole('super_admin'))
                                            <h3 class="card-title">Assigned Teacher</h3>
                                        @elseif(Auth::user()->hasRole('school_admin'))
                                            <h3 class="card-title">Assigned Teacher for <strong> {{ Auth::user()->school->name }} </strong></h3>
                                        @endif
                                        <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_assignTeacher">
                                            <i class="fas fa-plus">&nbsp;Assign Teacher</i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <table id="tbl_assigned_teacher" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Class Name</th>
                                                    <th>Teacher Name</th>
                                                    <th>Subject Names</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($grouped as $index => $row)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $row['class_name'] }}</td>
                                                        <td>{{ $row['teacher_name'] }}</td>
                                                        <td>{{ $row['subjects'] }}</td>
                                                        <td>
                                                            {{-- <button class="btn btn-sm btn-primary btn-view" data-id="{{ $row['class_id'] }}" data-toggle="modal" data-target="#modal_class_view">View</button> --}}
                                                            <button class="btn btn-sm btn-warning btn-edit" 
                                                                data-teacher="{{ $row['teacher_id'] }}"
                                                                data-class="{{ $row['class_id'] }}"
                                                                data-teacher-name="{{ $row['teacher_name'] }}"
                                                                data-class-name="{{ $row['class_name'] }}"
                                                                data-subjects="{{ $row['subject_ids'] ?? '' }}"
                                                                data-toggle="modal"
                                                                data-target="#modal_class_subject_edit">
                                                                Edit
                                                            </button>
                                                            <form method="POST" action="{{ route('subject.assignTeachersDelete') }}" class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="teacher_id" value="{{ $row['teacher_id'] }}">
                                                                <input type="hidden" name="class_id" value="{{ $row['class_id'] }}">
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {{-- Modal Section --}}
                {{-- Create Modal --}}
                @include('components.modal.class_subjects.create')
                {{-- Show Modal --}}
                {{-- @include('components.modal.class_subjects.show') --}}
                {{-- Edit Modal --}}
                @include('components.modal.class_subjects.edit')
                <!-- /.content -->
            </div>
        <!--end::App Main-->
        @include('components.footer_body')
    </div>
    @include('components.footer')
    <script>
        // Datatables
        $(function () {
            $("#tbl_assigned_teacher").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf"]
            }).buttons().container().appendTo('#tbl_assigned_teacher_wrapper .col-md-6:eq(0)');
        });
        // View Subject Modal
        $('#modal_subject_view').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var subjectId = button.data('id');
            $.ajax({
                url: 'subject/show/' + subjectId,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        $('#view_subject_name').text(response.data.subject_name);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
        // Edit Subject Modal
        $(document).on('click', '.btn-edit', function() {

        let teacherId = $(this).data('teacher');
        let classId = $(this).data('class');
        let teacherName = $(this).data('teacher-name');
        let className = $(this).data('class-name');
        let subjects = $(this).data('subjects');

        $('#edit_teacher_id').val(teacherId);
        $('#edit_class_id').val(classId);
        $('#edit_teacher_name').val(teacherName);
        $('#edit_class_name').val(className);

        let subjectArray = subjects.toString().split(',');

        $('#edit_subject_id').val(subjectArray).trigger('change');
    });
    </script>
        {{-- Custom Alert For delete button --}}
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are You Sure?',
                    text: "Subject Data will be deleted permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>   
</html>