@extends('layout.app')
@section('title', 'Create New Log')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-weight: 500">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="{{ route('daily-scoop.index') }}">Daily Scoop,
                    Container Cleaning &
                    Sanitation</a></li>
            <li class="breadcrumb-item"><a href="{{ route('daily-scoop.detail') }}">Log Report</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create New Report</li>
        </ol>
    </nav>

    <h3 class="h4 mb-4">DAILY SCOOP, CONTAINER CLEANING & SANITATION LOG <span class="text-danger h5 font-weight-bold">
            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            New</span></h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"> Create New Log </h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="mb-2">{{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>

                </div>
            @endif
            <form method="POST" action="{{ route('daily-scoop.store') }}">
                @csrf
                <div class="form-group col-12 col-lg-4">
                    <label class="col-form-label" for="">Date</label>
                    <input type="date" class="form-control" name="date" id="date" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="nama_petugas">Nama Petugas</label>
                    <input type="text" class="form-control" name="nama_petugas" id="nama_petugas"
                        placeholder="Masukan Nama" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="time">Time</label>
                    <select class="form-control" name="time" id="time" required>
                        <option value="" disabled selected>-Pilih Waktu-</option>
                        <option value="08.00">08.00</option>
                        <option value="12.00">12.00</option>
                        <option value="16.00">16.00</option>
                        <option value="20.00">20.00</option>
                    </select>
                </div>

                <div class="form-group col-12 text-center">
                    <a href="{{ route('daily-scoop.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')

@endsection
