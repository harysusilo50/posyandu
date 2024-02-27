@extends('layout.app')
@section('title', 'Create New Log')
@section('css')
    <style>
        .kbw-signature {
            width: 300px;
            height: 200px;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-weight: 500">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="{{ route('ice-machine-cleaning.index') }}">Ice Machine Cleaning</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ice-machine-cleaning.detail') }}">Log Report</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create New Report</li>
        </ol>
    </nav>

    <h3 class="h4 mb-4">ICE MACHINE CLEANING <span class="text-danger h5 font-weight-bold"><i
                class="fa fa-angle-double-right" aria-hidden="true"></i> New</span></h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"> Create New Log </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('ice-machine-cleaning.store') }}">
                @csrf

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="nama_petugas">Nama Petugas</label>
                    <input type="text" class="form-control" name="nama_petugas" id="nama_petugas"
                        placeholder="Masukan Nama" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="meal_period">Meal Period</label>
                    <select class="form-control" name="meal_period" id="meal_period" required>
                        <option value="" disabled selected>-Pilih-</option>
                        <option value="Breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                    </select>
                </div>

                <div class="form-group col-12 col-lg-4">
                    <label class="col-form-label" for="">Date</label>
                    <input type="date" class="form-control" name="date" id="date" required>
                </div>
                @include('components.signature.html')
                <textarea id="signature64" name="signature" style="display: none" required></textarea>
                <div class="form-group col-12 text-center">
                    <a href="{{ route('ice-machine-cleaning.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    @include('components.signature.js')
@endsection
