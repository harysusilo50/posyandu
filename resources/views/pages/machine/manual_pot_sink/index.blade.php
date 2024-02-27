@extends('layout.app')
@section('title', 'View Log Manual Pot Sink')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-weight: 500">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="{{ route('manual-pot-sink.index') }}">Manual Pot Sink</a></li>
            <li class="breadcrumb-item active" aria-current="page">Log Report</li>
        </ol>
    </nav>

    <div class="d-md-flex justify-content-between mb-4 text-center text-md-left">
        <div>
            <h3 class="h4">Manual Pot Sink</h3>
        </div>
        <div>
            <a href="{{ route('manual-pot-sink.create') }}" class="btn btn-primary"> <i class="fa fa-plus"
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
                        <th>Wash Temp</th>
                        <th>Sanitizer Temp</th>
                        <th>Sanitizer Type</th>
                        <th>Sanitizer Strength</th>
                        <th>Nama Petugas</th>
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
                ajax: "{{ route('datatable.manual-pot-sink') }}",
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
                    },
                    {
                        data: 'meal_period',
                        name: 'meal_period',
                        render: function(data) {
                            return data.toUpperCase()
                        }
                    },
                    {
                        data: 'wash_temp',
                        name: 'wash_temp',
                        render: function(data) {
                            return data + "&deg; C"
                        }
                    },
                    {
                        data: 'sanitizer_temp',
                        name: 'sanitizer_temp',
                        render: function(data) {
                            return data + "&deg; C"
                        }
                    },
                    {
                        data: 'sanitizer_type',
                        name: 'sanitizer_type',
                    },
                    {
                        data: 'sanitizer_strength',
                        name: 'sanitizer_strength',
                    },
                    {
                        data: 'nama_petugas',
                        name: 'nama_petugas',
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
