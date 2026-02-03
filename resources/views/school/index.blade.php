@include('components.header')
<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="wrapper">
        @include('components.navbar')
        @include('components.sidebar')
        <!--begin::App Main-->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">School</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('dash') }}">Home</a></li>
                                    <li class="breadcrumb-item active"> School</li>
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
                                        <h3 class="card-title">School Information</h3>
                                        <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_school">
                                            <i class="fas fa-plus">&nbsp;Add Data</i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <table id="tbl_school" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>School Name</th>
                                                    <th>Address</th>
                                                    <th>Contact Number</th>
                                                    <th>Email</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($schools as $school)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $school->name }}</td>
                                                    <td>{{ $school->address }}</td>
                                                    <td>{{ $school->phone }}</td>
                                                    <td>{{ $school->email }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary btn-view" data-id="{{ $school->school_id }}" data-toggle="modal" data-target="#modal_school_view">View</button>
                                                        <a href="{{ route('school.edit', $school->school_id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="{{ route('school.destroy', $school->school_id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this school?')">Delete</button>
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
                @include('components.modal.school.school_create')
                {{-- Show Modal --}}
                @include('components.modal.school.show')
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
        // View School Modal
        $('#modal_school_view').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var schoolId = button.data('id');
            $.ajax({
                url: '/school/show/' + schoolId,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        $('#view_name').text(response.data.name);
                        $('#view_address').text(response.data.address);
                        $('#view_phone').text(response.data.phone);
                        $('#view_email').text(response.data.email);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>
</body>
</html>   
