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
                                    <li class="breadcrumb-item active"> Schedules</li>
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
                                            <h3 class="card-title">Schedules</h3>
                                        @elseif(Auth::user()->hasRole('school_admin'))
                                        <h3 class="card-title">Schedules for School <strong> {{ Auth::user()->school->name }} </strong></h3><br>
                                        <h3 class="card-title">Academic Year - Semester : <strong>{{ $getActiveAcademicYear->year_name }} - {{ $getActiveSemester->semester_name }} </strong></h3>
                                        @endif
                                        <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_schedule_create">
                                            <i class="fas fa-plus">&nbsp;Add Schedule</i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <table id="tbl_schedule_all" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Day</th>
                                                    <th>Subject</th>
                                                    <th>Teacher</th>
                                                    <th>Time</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($schedules as $schedule)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}.</td>
                                                        <td>
                                                            @switch($schedule->day_of_week)
                                                                @case(1)
                                                                    Monday
                                                                    @break
                                                                @case(2)
                                                                    Tuesday
                                                                    @break
                                                                @case(3)
                                                                    Wednesday
                                                                    @break
                                                                @case(4)
                                                                    Thursday
                                                                    @break
                                                                @case(5)
                                                                    Friday
                                                                    @break
                                                                @case(6)
                                                                    Saturday
                                                                    @break
                                                                @default
                                                                    Unknown Day
                                                            @endswitch
                                                        </td>
                                                        <td>{{ $schedule->subject_name }}</td>
                                                        <td>{{ $schedule->teacher }}</td>
                                                        <td>{{ $schedule->start_time}} - {{ $schedule->end_time }}</td>
                                                        <td></td>
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
                @include('components.modal.schedule.create')
                <!-- /.content -->
            </div>
        <!--end::App Main-->
        @include('components.footer_body')
    </div>
    @include('components.footer')
    <script>
        // Datatables
        $(function () {
            $("#tbl_schedule_all").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf"]
            }).buttons().container().appendTo('#tbl_schedule_all_wrapper .col-md-6:eq(0)');
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