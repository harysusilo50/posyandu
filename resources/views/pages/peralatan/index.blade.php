@extends('layout.app')
@section('title', 'Data Peralatan')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-medkit mr-1"></i> Data Peralatan </h6>
        </div>
        <div class="card-body">
            <div class="d-lg-flex justify-content-lg-between mb-3 d-block">
                <div class="my-2">
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('peralatan.create') }}" class="btn btn-primary btn-sm">
                            New
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    @endif
                </div>
                <form action="" method="GET">
                    <div class="input-group my-2">
                        <input type="text" class="form-control" placeholder="Search" name="search" aria-label="Search"
                            value="{{ $search ?? '' }}" aria-describedby="search_button" />
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit" id="search_button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    @if (!empty($search))
                        <div class="text-end">
                            <a href="{{ route('peralatan.index') }}" class="btn btn-sm btn-danger">
                                Reset
                            </a>
                        </div>
                    @endif
                </form>
            </div>
            <div class="d-lg-flex justify-content-lg-end mb-3 d-block">
                <form action="{{ route('peralatan.index') }}" method="GET">
                    <div class="input-group my-2">
                        <select name="choose_bulan" id="choose_bulan" class="custom-select ">
                            <option value="" {{ empty($choose_bulan) ? 'selected' : '' }}>Semua Bulan</option>
                            @foreach ($bulan as $item)
                                <option value="{{ $item->bulan }}"
                                    {{ $choose_bulan == $item->bulan ? 'selected' : '' }}>{{ $item->nama_bulan }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit" id="search_button">
                                Filter
                            </button>
                        </div>
                    </div>
                    @if (!empty($month))
                        <div class="text-end">
                            <a href="{{ route('peralatan.index') }}" class="btn btn-sm btn-danger">
                                Reset
                            </a>
                        </div>
                    @endif
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama Peralatan</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tgl Pembelian</th>
                            <th class="text-center">Keterangan</th>
                            @if (Auth::user()->role == 'admin')
                                <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center" style="width:5%">
                                    {{ $data->firstItem() + $loop->index }}</td>
                                <td>
                                    {{ $item->nama_peralatan }}
                                </td>
                                <td>{{ $item->jumlah . '/' . $item->satuan }}</td>
                                <td class="text-center" style="width: 10%">
                                    @switch($item->status)
                                        @case('bagus')
                                            <span class="badge badge-pill badge-primary">Bagus</span>
                                        @break

                                        @case('rusak')
                                            <span class="badge badge-pill badge-danger">Rusak</span>
                                        @break

                                        @case('rusak_sebagian')
                                            <span class="badge badge-pill badge-warning">Rusak Sebagian</span>
                                        @break

                                        @case('hilang')
                                            <span class="badge badge-pill badge-dark">Hilang</span>
                                        @break

                                        @case('hilang_sebagian')
                                            <span class="badge badge-pill badge-secondary">Hilang Sebagian</span>
                                        @break

                                        @default
                                            <span class="badge rounded-pill text-bg-danger">{{ $item->status }}</span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    {{ $item->format_tgl_pembelian }}
                                </td>
                                <td>{{ $item->keterangan }}</td>

                                {{-- <td class="text-center" style="width: 10%">
                                    @switch($item->role)
                                        @case('superadmin')
                                            <span class="badge rounded-pill text-bg-primary">Superadmin</span>
                                        @break

                                        @case('admin')
                                            <span class="badge rounded-pill text-bg-secondary">Administrator</span>
                                        @break

                                        @case('cashier')
                                            <span class="badge rounded-pill text-bg-warning">Cashier</span>
                                        @break

                                        @default
                                            <span class="badge rounded-pill text-bg-danger">{{ $item->role }}</span>
                                        @break
                                    @endswitch
                                </td> --}}
                                @if (Auth::user()->role == 'admin')
                                    <td class="text-center" style="width: 10%">
                                        <div class="d-flex row justify-content-center">
                                            <a class="btn btn-success btn-sm col-8 m-1"
                                                href="{{ route('peralatan.edit', $item->id) }}">
                                                Edit <i class="bi bi-pencil ms-2"></i>
                                            </a>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger btn-sm col-8 m-1"
                                                data-toggle="modal" data-target="#model_delete{{ $item->id }}">
                                                Delete <i class="bi bi-trash3-fill ms-2"></i>
                                            </button>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="model_delete{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('peralatan.destroy', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">Peringatan!</h5>
                                                            <button type="button" class="btn btn-close bg-light"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true"></span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body border-0">
                                                            Apakah anda yakin ingin menghapus data ini?
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center border-0">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit"class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="my-2">
                    <a href="{{ route('peralatan.report') }}" class="btn btn-danger btn-sm" target="_blank">Cetak
                        <i class="fas fa-file-pdf"></i></a>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
