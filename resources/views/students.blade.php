<x-app-layout>
    <x-slot name="styles">
        <!-- Toastr -->
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/toastr/toastr.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <span id="success" {{ session('success') ? 'data-success = true' : false }}
            data-success-message='{{ json_encode(session('success')) }}'></span>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Students</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Layout</a></li>
                            <li class="breadcrumb-item active">Fixed Layout</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Students</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Admission No</th>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Sex</th>
                                            <th>Class</th>
                                            <th>Guardian</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo $no;
                                                    $no++;
                                                    ?>
                                                </td>
                                                <td>{{ $student->admission_no }}</td>
                                                <td>
                                                    {{ $student->first_name }}
                                                </td>
                                                <td>
                                                    {{ $student->last_name }}
                                                </td>
                                                <td>
                                                    {{ $student->sex }}
                                                </td>
                                                <td>
                                                    {{ $student->classroom->name }}
                                                </td>
                                                <td>
                                                    {{ $student->guardian->title . ' ' . $student->guardian->first_name . ' ' . $student->guardian->last_name }}
                                                </td>
                                                <td>{{ $student->status }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="/view/student/{{ $student->admission_no }}">
                                                            <button type="button" id="" class="btn btn-default btn-flat"
                                                                title="Student detailed view">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </a>
                                                        {{-- render if user is authorized to delete --}}
                                                        @can('delete', $student)
                                                            <button type="submit" class="btn btn-default btn-flat"
                                                                title="Delete"
                                                                onclick="deleteConfirmationModal({{ $student }})">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            {{-- TODO: Add confirmation modal --}}
                                                        @endcan

                                                        {{-- render if user is not authorized to delete --}}
                                                        @cannot('delete', $student)
                                                        <button type="submit" class="btn btn-default btn-flat"
                                                            title="Delete" disabled>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        @endcannot
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Admission No</th>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Sex</th>
                                            <th>Class</th>
                                            <th>Guardian</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->

        {{-- Delete confirmation modal --}}
        <div class="modal fade" id="deleteConfirmationModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete <span id="deleteItemName" class="font-bold"></span>?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <form action="" method="POST" id="yesDeleteConfirmation">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>

    <x-slot name="scripts">
        <!-- Toastr -->
        <script src="{{ asset('TAssets/plugins/toastr/toastr.min.js') }}"></script>
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('TAssets/plugins/datatables/jquery.dataTables.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.html5.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.print.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}">
        </script>
        <!-- AdminLTE App -->
        <script>
            function deleteConfirmationModal(data) {
                let deleteItemUrl = '/delete/student/' + data.id
                $('#yesDeleteConfirmation').attr("action", deleteItemUrl)
                $('#deleteItemName').html(data.name)
                $('#deleteConfirmationModal').modal('show')
            }

            //launch toastr
            $(function() {
                let Success = document.getElementById('success')
                // if data-success = 'true' display alert
                if (Success.dataset.success == 'true')
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Success',
                        subtitle: 'Close',
                        body: JSON.parse(Success.dataset.successMessage)
                    })

            });

            //datatables
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            });

        </script>
    </x-slot>
</x-app-layout>
