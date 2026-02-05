@include('components.header')
<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
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
                                <h1 class="m-0">Roles</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('dash') }}">Home</a></li>
                                    <li class="breadcrumb-item active"> Roles</li>
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
                                        <h3 class="card-title">Roles Information</h3>
                                        <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_roles">
                                            <i class="fas fa-plus">&nbsp;Add Data</i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <table id="tbl_roles" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Role Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($roles as $role)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning" data-id="{{ $role->role_id }}" data-toggle="modal" data-target="#modal_edit_role">
                                                            <i class="fas fa-edit"></i>&nbsp;Edit
                                                        </button>
                                                        <form action="{{ route('roles.destroy', $role->role_id) }}" method="POST" style="display: inline-block;" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>&nbsp;Delete
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
                <!-- /.content -->
                {{-- Create Modal --}}
                @include('components.modal.role.create')
                {{-- Edit Modal --}}
                @include('components.modal.role.edit')
        </div>
        @include('components.footer_body')
    </div>
    @include('components.footer')
    <script>
        // Datatables
        $(function () {
            $("#tbl_roles").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf"]
            }).buttons().container().appendTo('#tbl_roles_wrapper .col-md-6:eq(0)');
        });
        // Edit Modal Population
        $('#modal_edit_role').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var roleId = button.data('id');
            $.ajax({
                url: '/roles/edit/' + roleId,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        $('#update_name').val(response.data.name);
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
                    text: "Role Data will be deleted permanently!",
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