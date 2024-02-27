@extends('layout.app')
@section('title', 'Weekly Breakage Report')
@section('content')
    <div class="d-md-flex justify-content-between mb-4 text-center text-md-left">
        <div>
            <h3 class="h4">WEEKLY BREAKAGE REPORT</h3>
        </div>
        <div>
            <a href="{{ route('weekly-breakage.create') }}" class="btn btn-primary"> <i class="fa fa-plus"
                    aria-hidden="true"></i> Create New Report</a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

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
                            <th>Date</th>
                            <th>Items</th>
                            <th>Breakage By</th>
                            <th>Deskripsi</th>
                            <th>Total</th>
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
                    url: '{!! route('datatable.weekly_breakage') !!}',
                    type: 'GET',
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'format_date',
                        name: 'Date',
                    },
                    {
                        data: 'inventory.item_name',
                        name: 'Items',
                    },
                    {
                        data: 'breakage_by',
                        name: 'Breakage By',
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var remarks = $("<div></div>").html(row.remarks).text();
                            var action_plan = $("<div></div>").html(row.action_plan).text();
                            var output = `<button type="button" class="btn btn-sm btn-primary my-1 mx-1" data-toggle="modal" data-target="#model${data}">Lihat <i class="fas fa-eye"></i></a></button>
                                <div class="modal fade" id="model${data}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Deskripsi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="font-weight-bolder mb-1">Remarks</p>
                                                <div class="mb-3" id="remarks">${remarks}</div>
                                                <p class="font-weight-bolder mb-1">Action Plan</p>
                                                <div id="action_plan">${action_plan}</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            return output;

                        }
                    },
                    {
                        data: 'total',
                        name: 'Total',
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
