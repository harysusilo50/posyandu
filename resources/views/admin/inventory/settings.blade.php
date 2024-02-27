@extends('layout.app')
@section('title', 'Settings Inventory')
@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-cogs mr-1"></i> Settings Link Google Slides </h6>
        </div>
        <div class="card-body">
            <div class="form-group col-12 col-lg-8">
                <label for="link_ware_list" class="col-form-label" style="font-weight: 500">Inventory Ware
                    List</label>
                <div class="input-group">
                    <input id="link_ware_list" type="text" value="{{ $link_ware->link ?? '' }}"
                        placeholder="Input Link Google Slides Ware List" class="form-control" name="link_ware_list"
                        aria-describedby="update_ware_list">
                    <div class="input-group-append">
                        <button class="btn btn-primary " id="update_ware_list">Update</button>
                    </div>
                </div>
            </div>
            <div class="form-group col-12 col-lg-8">
                <label for="link_chemical_list" class="col-form-label" style="font-weight: 500">Inventory Chemical
                    List</label>
                <div class="input-group">
                    <input id="link_chemical_list" type="text" value="{{ $link_chemical->link ?? '' }}"
                        placeholder="Input Link Google Slides Chemical List" class="form-control" name="link_chemical_list"
                        aria-describedby="update_chemical_list">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="update_chemical_list">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-cogs mr-1"></i> Settings Inventory </h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <form action="{{ route('admin.inventory.settings') }}" method="GET">
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" placeholder="Search Inventory" name="search"
                            aria-label="Search Inventory" value="{{ $search ?? '' }}" aria-describedby="search_button" />

                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit" id="search_button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    @if (!empty($search))
                        <div class="text-right">
                            <a href="{{ route('admin.inventory.settings') }}" class="btn btn-sm btn-danger">
                                Reset
                            </a>
                        </div>
                    @endif
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Patern</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $data->firstItem() + $loop->index }}</td>
                                <td>{{ $item->pattern }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->category }}</td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-sm" href="{{ route('inventory.edit', $item->id) }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#model_delete{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="model_delete{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.inventory.destroy', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Peringatan!</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus data ini?
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit"class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
                <!--Table-->
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#update_chemical_list').click(function(e) {
                Swal.showLoading();
                e.preventDefault();
                var chemical = $('#link_chemical_list').val();
                var split = chemical.split("/");
                var value = split[6];
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.inventory.slide') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        type: "chemical",
                        link: value
                    },
                    dataType: "JSON",
                }).done(function(data, textStatus, jqXHR) {
                    $('#link_chemical_list').val(data.link);
                    Swal.fire({
                        icon: 'success',
                        text: data.message,
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        Swal.fire({
                            icon: 'warning',
                            text: "Link chemical harus diisi",
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: "Gagal!",
                        });
                    }
                }).always(function() {
                    Swal.hideLoading();
                });
            });
            $('#update_ware_list').click(function(e) {
                Swal.showLoading();
                e.preventDefault();
                var ware = $('#link_ware_list').val();
                var split = ware.split("/");
                var value = split[6];
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.inventory.slide') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        type: "ware",
                        link: value
                    },
                    dataType: "JSON",
                }).done(function(data, textStatus, jqXHR) {
                    $('#link_ware_list').val(data.link);
                    Swal.fire({
                        icon: 'success',
                        text: data.message,
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 422) {
                        Swal.fire({
                            icon: 'warning',
                            text: "Link harus diisi",
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: "Gagal!",
                        });
                    }
                }).always(function() {
                    Swal.hideLoading();
                });
            });
        });
    </script>
@endsection
