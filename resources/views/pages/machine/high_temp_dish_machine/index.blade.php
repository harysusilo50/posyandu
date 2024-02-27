@extends('layout.app')
@section('title', 'View Log High Temp Dish Machine')

@section('content')
    <div class="d-md-flex justify-content-between mb-4 text-center text-md-left">
        <div>
            <h3 class="h4">High Temp Dish Machine</h3>
        </div>
        <div>
            <a href="{{ route('high-temp-dish-machine.create') }}" class="btn btn-primary"> <i class="fa fa-plus"
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
                        <th>Final Temp Rinse</th>
                        <th>Temp From Dishwasher Thermometer</th>
                        <th>Corrective Action</th>
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
                ajax: "{{ route('datatable.high-temp-dish-machine') }}",
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
                        data: 'final_temp_rinse',
                        name: 'final_temp_rinse',
                        render: function(data) {
                            return data + "&deg; C"
                        }
                    },
                    {
                        data: 'temp_from_dishwasher',
                        name: 'temp_from_dishwasher',
                        render: function(data) {
                            return data + "&deg; C"
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var corrective_action = $("<div></div>").html(row.corrective_action)
                                .text();
                            var output = `<button type="button" class="btn btn-sm btn-primary my-1 mx-1" data-toggle="modal" data-target="#model${data}">Lihat <i class="fas fa-eye"></i></a></button>
                                <div class="modal fade" id="model${data}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Corrective Action</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3" id="corrective_action">${corrective_action}</div>
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
