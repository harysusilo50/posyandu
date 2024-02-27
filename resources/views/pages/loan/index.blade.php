@extends('layout.app')
@section('title', 'List Loan')

@section('content')
    <div class="d-md-flex justify-content-between mb-4 text-center text-md-left">
        <div>
            <h3 class="h4">List Loan</h3>
        </div>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-bordered  table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ttd</th>
                            <th>Order Code</th>
                            <th>Items</th>
                            <th>Borrowing Date</th>
                            <th>Return Date</th>
                            <th>Borrowing Name</th>
                            <th>Department</th>
                            <th>Returning Name</th>
                            <th>Status</th>
                            <th>Total Borrowing</th>
                            <th>Total Returned</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        $(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('datatable.loan') }}",
                search: {
                    return: true
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'id',
                        name: 'id',
                        className: 'text-center',
                        render: function(data, type, row) {
                            var url = "{{ url('/storage') }}";
                            return `<button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#modal${row.id}"> 
                                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                                    </button>
                                    <div class="modal fade" id="modal${row.id}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tanda Tangan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">Borrowing <br> Signature</td>
                                                                <td><img src="${url}/${row.signature_borrowing}" class="img-fluid rounded w-50"></td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">Return <br> Signature</td>
                                                                <td><img src="${url}/${row.signature_return}" class="img-fluid rounded w-50"></td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `
                        }
                    },
                    {
                        data: 'no_order',
                        name: 'no_order',
                    },
                    {
                        data: 'inventory.item_name',
                        name: 'inventory.item_name',
                    },
                    {
                        data: 'borrowing_date',
                        name: 'borrowing_date',
                    },
                    {
                        data: 'return_date',
                        name: 'return_date',
                    },
                    {
                        data: 'borrowing_name',
                        name: 'borrowing_name',
                    },
                    {
                        data: 'departmen',
                        name: 'departmen',
                    },
                    {
                        data: 'return_name',
                        name: 'return_name',
                        render: function(data) {
                            return data != '' ? data : '-';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            var status = '';
                            switch (data) {
                                case 'borrowed':
                                    status = '<span class="badge badge-secondary">Borrowed</span>';
                                    break;
                                case 'returned':
                                    status = '<span class="badge badge-success">Returned</span>';
                                    break;
                                case 'minus_return':
                                    status = '<span class="badge badge-danger">Minus Return</span>';
                                    break;

                                default:
                                    break;
                            }

                            return status;
                        }
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        className: 'font-weight-bold'
                    },
                    {
                        data: 'qty_return',
                        name: 'qty_return',
                        className: 'font-weight-bold',
                        render: function(data) {
                            return data != '' ? data : '-'
                        }
                    },
                ],
                initComplete: function() {
                    $('.dataTables_filter input').unbind();
                    $('.dataTables_filter input').bind('keyup', function(e) {
                        var code = e.keyCode || e.which;
                        if (code == 13) {
                            table.search(this.value).draw();
                        }
                    });
                },
            });

        });
    </script>
@endsection
