@extends('layout.app')
@section('title', 'Create New Log')

@section('content')
    <h3 class="h4 mb-4">HIGH TEMP. DISH MACHINE <span class="text-danger h5 font-weight-bold">>> New</span></h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"> Create New Log </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('high-temp-dish-machine.store') }}" enctype="multipart/form-data">
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

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label col-12 pl-0" for="final_temp_rinse">Final Temp Rinse</label>
                    <div class="d-flex">
                        <input type="number" class="form-control col-6 col-lg-2" name="final_temp_rinse"
                            id="final_temp_rinse" required>
                        <h5 class="ml-2">&deg;C</h5>
                    </div>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label col-12 pl-0" for="temp_from_dishwasher">Temp From Dishwasher
                        Thermometer</label>
                    <div class="d-flex">
                        <input type="number" class=" form-control col-6 col-lg-2" name="temp_from_dishwasher"
                            id="temp_from_dishwasher" required>
                        <h5 class="ml-2">&deg;C</h5>
                    </div>
                </div>

                <div class="form-group col-12">
                    <label for="corrective_action" class="col-form-label" style="font-weight: 500">Corrective Action</label>
                    <textarea id="corrective_action" class="form-control" name="corrective_action" rows="5" required></textarea>
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
                    <a href="{{ route('high-temp-dish-machine.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        CKEDITOR.replace('corrective_action');
    </script>
@endsection
