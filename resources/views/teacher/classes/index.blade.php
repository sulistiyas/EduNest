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
                                    <li class="breadcrumb-item active"> My Classes</li>
                                    <li class="breadcrumb-item"><a href="{{ route('teacher.dash') }}">Home</a></li>
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
                                        <table id="tbl_classes" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Class Name</th>
                                                    <th>Enrolled Students</th>
                                                    <th>Subject Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($classes as $class)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $class->class_name }}</td>
                                                        <td>
                                                            <span class="badge bg-info btn-students"
                                                                style="cursor:pointer"
                                                                data-id="{{ $class->class_id }}"
                                                                data-toggle="modal"
                                                                data-target="#modal_students">
                                                                {{ $class->total_students }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="badge bg-success btn-subjects"
                                                                style="cursor:pointer"
                                                                data-id="{{ $class->class_id }}"
                                                                data-toggle="modal"
                                                                data-target="#modal_subjects">
                                                                {{ $class->total_subjects }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary btn-view" data-id="{{ $class->class_id }}" data-toggle="modal" data-target="#modal_view_class">View</button>
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
                @include('components.modal.teacher.class.show_detail_student')
                @include('components.modal.teacher.class.show_detail_subject')
            </div>
        <!--end::App Main-->
        @include('components.footer_body')
    </div>
    @include('components.footer')
<script>
    $(function () {
        $('#tbl_classes').DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tbl_classes_wrapper .col-md-6:eq(0)');
    });
    $(document).on('click', '.btn-students', function(){
        let classId = $(this).data('id');

        $.get('classes/' + classId + '/students', function(data){
            let html = '';
            data.forEach((item, index) => {
                html += `<tr>
                            <td>${index + 1}</td>
                            <td>${item.name}</td>
                        </tr>`;
            });
            $('#students_body').html(html);
        });
    });

    $(document).on('click', '.btn-subjects', function(){
        let classId = $(this).data('id');

        $.get('classes/' + classId + '/subjects', function(data){
            let html = '';
            data.forEach((item, index) => {
                html += `<tr>
                            <td>${index + 1}</td>
                            <td>${item.subject_name}</td>
                        </tr>`;
            });
            $('#subjects_body').html(html);
        });
    });
</script>
</body>   