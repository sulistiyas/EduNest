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
                                <h1 class="m-0">Academic Years</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('dash') }}">Home</a></li>
                                    <li class="breadcrumb-item active"> Academic Years</li>
                                </ol>
                            </div>
                        </div><!-- /.row -->
                    </div>
                </div>
                <!--end::Row-->
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Academic Years</h3>
                                        <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_academic_year_create">
                                            <i class="fas fa-plus">&nbsp;Add Data</i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <table id="tbl_academic_year" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Academic Year</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Is Active</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($academicYears as $year)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $year->year_name }}</td>
                                                    <td>{{ $year->start_date }}</td>
                                                    <td>{{ $year->end_date }}</td>
                                                    <td>
                                                        <span class="{{ $year->is_active ? 'badge bg-success' : 'badge bg-danger' }}" style="cursor:pointer">
                                                            {{ $year->is_active ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($year->is_active)
                                                            <form action="{{ route('academic_year.setDeactive', $year->academic_year_id) }}"
                                                                method="POST"
                                                                class="d-inline deactivate-form">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-secondary">
                                                                    Deactivate
                                                                </button>
                                                            </form>
                                                            
                                                        @else
                                                            <form action="{{ route('academic_year.setActive', $year->academic_year_id) }}"
                                                                method="POST"
                                                                class="d-inline activate-form">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success">
                                                                    Activate
                                                                </button>
                                                            </form>
                                                        @endif
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
                @include('components.modal.academic_setup.academic_years.create')
                {{-- Show Modal --}}
                @include('components.modal.academic_setup.academic_years.show')
                {{-- Edit Modal --}}
                @if(isset($academicYears) && count($academicYears) > 0)
                    @include('components.modal.academic_setup.academic_years.edit', ['academicYear' => $year])
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
            $("#tbl_academic_year").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf"]
            }).buttons().container().appendTo('#tbl_academic_year_wrapper .col-md-6:eq(0)');
        });
        // View Academic Year Modal
        $('#modal_academic_year_view').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var academicYearId = button.data('id');
            $.ajax({
                url: '/academic-year/show/' + academicYearId,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        $('#view_year_name').text(response.data.year_name);
                        $('#view_start_date').text(response.data.start_date);
                        $('#view_end_date').text(response.data.end_date);
                        $('#view_is_active').text(response.data.is_active ? 'Yes' : 'No');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
        // Edit Academic Year Modal
        $('#modal_academic_year_edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var academicYearId = button.data('id');
            $.ajax({
                url: 'academic_years/edit/' + academicYearId,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        $('#update_academic_year_name').val(response.data.year_name);
                        $('#update_start_date').val(response.data.start_date);
                        $('#update_end_date').val(response.data.end_date);
                        $('#update_is_active').val(response.data.is_active);
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
        document.querySelectorAll('.activate-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are You Sure?',
                    text: "Academic Year Will be Activated!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Activate!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.deactivate-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are You Sure?',
                    text: "Academic Year Will be Deactivated!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Deactivate!',
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
