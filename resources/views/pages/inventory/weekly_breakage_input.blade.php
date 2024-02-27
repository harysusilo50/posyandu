@extends('layout.app')
@section('title', 'Create Breakage Report')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css"
        integrity="sha512-MMojOrCQrqLg4Iarid2YMYyZ7pzjPeXKRvhW9nZqLo6kPBBTuvNET9DBVWptAo/Q20Fy11EIHM5ig4WlIrJfQw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <h3 class="h4 mb-4">WEEKLY BREAKAGE REPORT <span class="text-danger h5 font-weight-bold">>> New</span></h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"> Create New Report </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('weekly-breakage.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="select-item">Item</label>
                    <select class="form-control" name="inventory_id" id="select-item" required>
                        <option value=""></option>
                        @foreach ($data as $item)
                            <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="breakage_by">Breakage By</label>
                    <input type="text" class="form-control" name="breakage_by" id="breakage_by"
                        placeholder="Masukan Nama" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="total">Total</label>
                    <input type="number" class="form-control" name="total" id="total"
                        placeholder="Masukan Total Barang" required>
                </div>

                <div class="form-group col-12 col-lg-4">
                    <label class="col-form-label" for="">Date</label>
                    <input type="date" class="form-control" name="date" id="date" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="remarks">Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" rows="3" required></textarea>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="action_plan">Action Plan</label>
                    <textarea class="form-control" name="action_plan" id="action_plan" rows="3" required></textarea>
                </div>

                <div class="form-group col-12 text-center">
                    <a href="{{ route('weekly-breakage.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"
        integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("#select-item").selectize({
            create: true,
            sortField: "text",
            placeholder: "Select Item",
            create: false,
        });
    </script>
    <script>
        CKEDITOR.replace('remarks');

        CKEDITOR.replace('action_plan');
    </script>

@endsection
