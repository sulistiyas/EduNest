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
                                <h1 class="m-0">Users</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('dash') }}">Home</a></li>
                                    <li class="breadcrumb-item active"> Users</li>
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
                                        <h3 class="card-title">User List</h3>
                                        <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_users">
                                            <i class="fas fa-plus">&nbsp;Add Data</i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <table id="tbl_school" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>School</th>
                                                    <th>Role</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users_data as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->school_name ?? 'N/A' }}</td>
                                                    <td>{{ $user->role_name ?? 'N/A' }}</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm" data-id="{{ $user->id }}" data-toggle="modal" data-target="#modal_users_show">View</button>
                                                        <button class="btn btn-warning btn-sm" data-id="{{ $user->id }}" data-toggle="modal" data-target="#modal_users_edit">Edit</button>
                                                        <form action="{{ route('users.destroy', $user->id) }}"
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
                @include('components.modal.users.create')
                {{-- Show Modal --}}
                @include('components.modal.users.show')
                {{-- Edit Modal --}}
                @if(isset($user))
                    @include('components.modal.users.edit')
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
            $("#tbl_school").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf"]
            }).buttons().container().appendTo('#tbl_school_wrapper .col-md-6:eq(0)');
        });
    // View School Modal Population
    $('#modal_users_show').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('id');
        // console.log("User ID:", userId);
        // AJAX request to fetch user details
        $.ajax({
            url: '/users/show/' + userId,
            method: 'GET',
            success: function(response){
                console.log(response);
                if(response.status){
                    $('#show_name').text(response.data.name);
                    $('#show_email').text(response.data.email);
                    $('#show_school').text(response.data.school || 'N/A');
                    $('#show_role').text(response.data.role || 'N/A');
                }
            },
            error: function(xhr, status, error){
                console.log(error);
            }
        });
    });
    // Edit User Modal Population
    $('#modal_users_edit').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let userId = button.data('id');

        $.ajax({
            url: '/users/edit/' + userId,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('#update_name').val(response.data.name);
                    $('#update_email').val(response.data.email);

                    // KUNCI UTAMA 🔥
                    $('#update_role_id')
                        .val(response.data.role_id)
                        .trigger('change');

                    $('#update_school_id')
                        .val(response.data.school_id)
                        .trigger('change');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
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
                    text: "User Data will be deleted permanently!",
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
