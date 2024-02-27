@extends('layout.app')
@section('title', 'View Log Ice Machine Cleaning')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-weight: 500">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="{{ route('ice-machine-cleaning.index') }}">Ice Machine Cleaning</a></li>
            <li class="breadcrumb-item active" aria-current="page">Log Report</li>
        </ol>
    </nav>
    <div class="d-md-flex justify-content-between mb-4 text-center text-md-left">
        <div>
            <h3 class="h4">Ice Machine Cleaning</h3>
        </div>
        <div>
            <a href="{{ route('ice-machine-cleaning.create') }}" class="btn btn-primary"> <i class="fa fa-plus"
                    aria-hidden="true"></i> Create New Log</a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-body">
            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Meal Period</th>
                        <th>Cleaned By</th>
                        <th>Spv. Initial</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
@endsection
@section('js')
    <script>
        $(function() {
            var url = "{{ url('/storage') }}";
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('datatable.ice-machine') }}",
                search: {
                    return: true
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        orderable: true,
                        render: function(data) {
                            if (!data) {
                                return '-';
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'meal_period',
                        name: 'meal_period',
                        orderable: true,
                        render: function(data) {
                            if (!data) {
                                return '-';
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'nama_petugas',
                        name: 'nama_petugas',
                        orderable: true,
                        render: function(data) {
                            if (!data) {
                                return '-';
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'spv_initial',
                        name: 'spv_initial',
                        orderable: true,
                        render: function(data) {
                            if (!data) {
                                return '-';
                            } else {
                                var src = url + "/" + data;
                                return `<img src="${src}" class="img-fluid rounded" alt="spv_initial">`
                            }
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
