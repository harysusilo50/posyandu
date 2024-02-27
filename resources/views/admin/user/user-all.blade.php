@extends('layout.app')
@section('title', 'List All User')
@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-user mr-1"></i> List All User </h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive">
                <!--Table-->
                <table class="table table-striped" id="dataTable" cellspacing="0">

                    <!--Table head-->
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
                <!--Table-->
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        var table;
        var _token = "{{ csrf_token() }}";

        $(document).ready(function() {
            table = $('#dataTable').DataTable({
                serverSide: false,
                processing: true,
                ajax: {
                    url: '{!! route('datatable.user.all') !!}',
                    type: 'GET',
                },
                columns: [{
                        data: 'id',
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nim',
                        name: 'nim',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'role',
                        name: 'role',
                        render: function(data) {
                            switch (data) {
                                case 'admin':
                                    return '<span class="badge badge-pill badge-primary">Administrator</span>'
                                    break;
                                case 'user':
                                    return '<span class="badge badge-pill badge-secondary">Mahasiswa</span>'
                                    break;
                                case 'dosen':
                                    return '<span class="badge badge-pill badge-success">Dosen</span>'
                                    break;

                                default:
                                    break;
                            }
                        }
                    },
                    {
                        data: 'id',
                        className: "text-center",
                        render: function(data, type, row) {
                            var url_edit = "{{ \Request::url() }}" + "/" + data + "/edit";
                            var url_show = "{{ \Request::url() }}" + "/" + data;
                            return '\<div class="d-flex gap-3 justify-content-center">\
                                                            <button class="btn btn-sm btn-danger my-1" id="delete" onclick="delete_data_user(' +
                                data +
                                ')"><i class="far fa-trash-alt"></i></button></div>';

                        }
                    },
                ]
            });

        });

        function delete_data_user(id) {
            var text = "Data akan dihapus dan tidak bisa dikembalikan"
            var url = "{{ url('/admin/user/') }}";
            var _token = "{{ csrf_token() }}";
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url + "/" + id,
                        type: 'DELETE',
                        data: {
                            _token: _token
                        },
                        dataType: 'JSON',
                        success: function(data) {
                            table.ajax.reload();
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Terhapus!',
                                    data.message,
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    data.message,
                                    'error'
                                )
                            }
                            console.log(data)
                        },
                        error: function(ajaxContext) {
                            table.ajax.reload();
                            Swal.fire(
                                'Oops...',
                                'Terjadi kesalahan',
                                'error',
                            )
                        }
                    });
                }
            })
        };
    </script>
@endsection
