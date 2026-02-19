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
                                    <li class="breadcrumb-item active"> Student Enrollment</li>
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
                                        <h3 class="card-title">Class List for <strong> {{ Auth::user()->school->name }} </strong></h3>
                                        <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_enrollment">
                                            <i class="fas fa-plus">&nbsp;Enroll Student</i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <table id="tbl_enrollment" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Class Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($class_enrollments as $class)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $class->class_name }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary btn-view" data-id="{{ $class->class_id }}" data-toggle="modal" data-target="#modal_enrollment_view">View</button>
                                                        <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $class->class_id }}" data-toggle="modal" data-target="#modal_enrollment_edit">Edit</button>
                                                        <form action="{{ route('class.destroy', $class->class_id) }}"
                                                            method="POST"
                                                            class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
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
                @include('components.modal.classes.create_enroll_student')
                {{-- Show Modal --}}
                @include('components.modal.classes.show_enroll_student')
                {{-- Edit Modal --}}
                @if(isset($class))
                    @include('components.modal.classes.edit_enroll_student', ['class' => $class])
                @endif
                <!-- /.content -->
            </div>
        <!--end::App Main-->
        @include('components.footer_body')
    </div>
    @include('components.footer')
    <script>
        // Datatables
        $(function () {
            $("#tbl_enrollment").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf"]
            }).buttons().container().appendTo('#tbl_enrollment_wrapper .col-md-6:eq(0)');
        });
        // View Class Modal
        $('#modal_enrollment_view').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var classId = button.data('id');
            $.ajax({
                url: 'class/show/' + classId,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        $('#view_class_name').text(response.data.name);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
        // Edit Class Modal
        $('#modal_enrollment_edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var classId = button.data('id');
            $.ajax({
                url: '/class/edit/' + classId,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        $('#update_class_name').val(response.data.name);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>
        {{-- Custom Alert For delete button --}}
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are You Sure?',
                    text: "Class Data will be deleted permanently!",
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