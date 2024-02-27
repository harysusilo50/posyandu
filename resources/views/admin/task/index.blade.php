@extends('layout.app')
@section('title', 'Task & Exercise')
@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-book mr-1"></i> List Task & Exercise </h6>
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
                            <th>Aksi</th>
                            <th>Judul</th>
                            <th>Deadline</th>
                            <th>Tipe</th>
                            <th>File</th>
                            <th>Link</th>
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
                    url: '{!! route('datatable.task') !!}',
                    type: 'GET',
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'id',
                        className: "text-center",
                        render: function(data, type, row) {
                            var url_edit = "{{ \Request::url() }}" + "/" + data + "/edit";
                            if (row.tipe == 'tugas') {
                                var url_show = "{{ \Request::url() }}" + "/" + data;
                            } else {
                                var url_show = "{{ \Request::url() }}" + "-link/" + data;
                            }
                            return '\<div class="d-flex gap-3 justify-content-center">\
                                                                                                                                    \<a href="' +
                                url_edit +
                                '" class="btn btn-sm btn-warning my-1"><i class="fas fa-edit"></i></a>\
                                                                                                                            \<a class="btn btn-sm btn-primary my-1 mx-1" href="' +
                                url_show +
                                '"><i class="fas fa-eye"></i></a>\
                                                                                                                                    <button class="btn btn-sm btn-danger my-1" id="delete" onclick="delete_data_task(' +
                                data +
                                ')"><i class="far fa-trash-alt"></i></button></div>';

                        }
                    },
                    {
                        data: 'judul',
                        name: 'Judul',
                    },
                    {
                        data: 'deadline_tugas',
                        name: 'Deadline Tugas',
                    },
                    {
                        data: 'tipe',
                        name: 'Tipe',
                    },
                    {
                        data: 'file',
                        className: "text-center",
                        name: 'File',
                        render: function(data) {
                            if (data == null) {
                                return '-';
                            }
                            var base_url = "{{ url('/') }}";
                            return `<a target="_blank" class="btn btn-primary btn-sm" href="${base_url}/${data}"><i class="fas fa-file"></i></a>`;
                        }
                    },
                    {
                        data: 'link',
                        className: "text-center",
                        name: 'Link',
                        render: function(data) {
                            if (data == null) {
                                return '-';
                            }
                            var base_url = "{{ url('/') }}";
                            return `<a target="_blank" class="btn btn-secondary btn-sm" href="${data}"> <i class="fas fa-link"></i></a>`;
                        }
                    },
                ]
            });

        });
    </script>
    <script type="text/javascript">
        function delete_data_task(id) {
            var text = "Data akan dihapus dan tidak bisa dikembalikan"
            var url = "{{ url('/' . \Request::segment(1) . '/task') }}";
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
