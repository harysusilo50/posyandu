@extends('layout.app')
@section('title', 'Edit data Peralatan ' . $peralatan->nama_peralatan)
@section('content')
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-medkit mr-1"></i> Edit Peralatan
                {{ $peralatan->nama_peralatan }}</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>

                </div>
            @endif
            <form method="POST" action="{{ route('peralatan.update', $peralatan->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-1">
                    <label class="col-form-label" for="nama_peralatan" style="font-weight: 500">Nama Peralatan</label>
                    <input id="nama_peralatan" type="text"
                        class="form-control @error('nama_peralatan') is-invalid @enderror" name="nama_peralatan"
                        value="{{ $peralatan->nama_peralatan }}" required autocomplete="nama_peralatan" autofocus>
                    @error('nama_peralatan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-1">
                    <label class="col-form-label" for="jumlah" style="font-weight: 500">Jumlah</label>
                    <input id="jumlah" type="number" min="0"
                        class="form-control @error('jumlah') is-invalid @enderror" name="jumlah"
                        value="{{ $peralatan->jumlah }}" autocomplete="jumlah" autofocus>
                    @error('jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-1">
                    <label class="col-form-label" for="satuan" style="font-weight: 500">Satuan</label>
                    <input id="satuan" type="text" class="form-control @error('satuan') is-invalid @enderror"
                        name="satuan" value="{{ $peralatan->satuan }}" autocomplete="satuan" autofocus>
                    @error('satuan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-1">
                    <label class="col-form-label" for="tgl_pembelian" style="font-weight: 500">Tanggal
                        Pembelian</label>
                    <input id="tgl_pembelian" type="date"
                        class="form-control @error('tgl_pembelian') is-invalid @enderror" name="tgl_pembelian"
                        value="{{ $peralatan->tgl_pembelian }}" required autocomplete="tgl_pembelian" autofocus>
                    @error('tgl_pembelian')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="status" style="font-weight: 500">Status Peralatan</label>
                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status"
                        required>
                        <option value="bagus"{{ $peralatan->status == 'bagus' ? ' selected' : '' }}>
                            Bagus</option>
                        <option value="rusak"{{ $peralatan->status == 'rusak' ? ' selected' : '' }}>
                            Rusak</option>
                        <option value="rusak_sebagian"{{ $peralatan->status == 'rusak_sebagian' ? ' selected' : '' }}>
                            Rusak Sebagian</option>
                        <option value="hilang"{{ $peralatan->status == 'hilang' ? ' selected' : '' }}>
                            Hilang</option>
                        <option value="hilang_sebagian"{{ $peralatan->status == 'hilang_sebagian' ? ' selected' : '' }}>
                            Hilang Sebagian</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="5">{{ $peralatan->keterangan }}</textarea>
                </div>
                <div class="form-group col-12 text-center">
                    <a href="{{ route('peralatan.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
