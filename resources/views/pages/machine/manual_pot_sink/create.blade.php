@extends('layout.app')
@section('title', 'Create New Log')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-weight: 500">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item "><a href="{{ route('manual-pot-sink.index') }}">Manual Pot Sink</a></li>
            <li class="breadcrumb-item"><a href="{{ route('manual-pot-sink.detail') }}">Log Report</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create New Report</li>
        </ol>
    </nav>

    <h3 class="h4 mb-4">MANUAL POT SINK <span class="text-danger h5 font-weight-bold">>> New</span></h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"> Create New Log </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('manual-pot-sink.store') }}">
                @csrf
                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="meal_period">Meal Period</label>
                    <select class="form-control" name="meal_period" id="meal_period" required>
                        <option value="" disabled selected>-Pilih-</option>
                        <option value="Breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                    </select>
                </div>

                <div class="form-group col-6 col-lg-2">
                    <label class="col-form-label" for="wash_temp">Wash Temp</label>
                    <div class="d-flex">
                        <input type="number" class="form-control" name="wash_temp" id="wash_temp" required>
                        <h5 class="ml-2">&deg;C</h5>
                    </div>
                </div>

                <div class="form-group col-6 col-lg-2">
                    <label class="col-form-label" for="sanitizer_temp">Sanitizer Temp</label>
                    <div class="d-flex">
                        <input type="number" class="form-control" name="sanitizer_temp" id="sanitizer_temp" required>
                        <h5 class="ml-2">&deg;C</h5>
                    </div>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="sanitizer_type">Sanitizer Type</label>
                    <input type="text" class="form-control" name="sanitizer_type" id="sanitizer_type"
                        placeholder="Masukan Tipe Sanitizer" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="sanitizer_strength">Sanitizer Strength</label>
                    <input type="text" class="form-control" name="sanitizer_strength" id="sanitizer_strength"
                        placeholder="Masukan Sanitizer Strength" required>
                </div>
                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="nama_petugas">Nama Petugas</label>
                    <input type="text" class="form-control" name="nama_petugas" id="nama_petugas"
                        placeholder="Masukan Nama Petugas" required>
                </div>

                <div class="form-group col-12 col-lg-4">
                    <label class="col-form-label" for="date">Date</label>
                    <input type="date" class="form-control" name="date" id="date" required>
                </div>

                <div class="form-group col-12 text-center">
                    <a href="{{ route('manual-pot-sink.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')

@endsection
