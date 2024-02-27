@extends('layout.app')
@section('title', 'Add Inventory')
@section('css')
    <style>
        .dropify-wrapper .dropify-message .file-icon {
            font-size: 24px !important;
        }
    </style>
@endsection
@section('content')
    <h3 class="h4 mb-4">ADD INVENTORY</h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"> Create New Inventory </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('inventory.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-12 col-lg-4">
                    @include('components.upload_image.html')
                </div>
                <textarea id="image-dropify-send" class="d-none" name="image" required></textarea>

                <div class="form-group col-12 col-lg-8">
                    <label for="pattern" class="col-form-label" style="font-weight: 500">Pattern</label>
                    <input id="pattern" type="text" class="form-control" placeholder="Masukan Nomor Pattern"
                        name="pattern" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label for="item_name" class="col-form-label" style="font-weight: 500">Item Name</label>
                    <input id="item_name" type="text" placeholder="Masukan nama barang" class="form-control"
                        name="item_name" required>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label" style="font-weight: 500">
                        Category
                    </label>
                    <div class="form-check">
                        <input class=" form-check-inline check_category" value="ware" type="radio" name="category"
                            id="ware" required>
                        <label class="form-check-label" for="ware" style="font-weight: 500">
                            Ware List
                        </label>
                    </div>
                    <div class="form-check">
                        <input class=" form-check-inline check_category" value="chemical" type="radio" name="category"
                            id="chemical" required>
                        <label class="form-check-label" for="chemical" style="font-weight: 500">
                            Chemical List
                        </label>
                    </div>
                </div>

                <div class="form-group col-12" id="typeware">

                </div>
                <div class="form-group col-12 col-lg-8">
                    <label for="qty" class="col-form-label" style="font-weight: 500">Quantity</label>
                    <input id="qty" type="number" placeholder="Masukan Jumlah Item" class="form-control"
                        name="qty" required>
                </div>

                <div class="form-group col-12">
                    <label for="desc" class="col-form-label" style="font-weight: 500">Deskripsi</label>
                    <textarea id="desc" class="form-control" name="desc" rows="5" required></textarea>
                </div>

                <div class="form-group col-12 text-center">
                    <a href="{{ route('inventory.warelist') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.check_category').change(function(e) {
            e.preventDefault();
            if ($('#ware').is(':checked')) {
                $('#typeware').append(`
                    <div class="btn-group" data-bs-toggle="buttons">
                        <label class="btn btn-outline-secondary label-chinaware" for="chinaware">
                            <input type="radio" class="me-2 typeware" name="type" value="chinaware" id="chinaware" autocomplete="off" required>
                            Chinaware
                        </label>
                        <label class="btn btn-outline-secondary label-silverware" for="silverware">
                            <input type="radio" class="typeware" name="type" value="silverware" id="silverware" autocomplete="off" required> Silverware
                        </label>
                        <label class="btn btn-outline-secondary label-glassware" for="glassware">
                            <input type="radio" class="typeware" name="type" value="glassware" id="glassware" autocomplete="off" required> Glassware
                        </label>
                    </div>`);

                $('.typeware').change(function(e) {
                    e.preventDefault();
                    if ($('#chinaware').is(':checked')) {
                        $('.label-chinaware').addClass('active');
                        $('.label-silverware').removeClass('active');
                        $('.label-glassware').removeClass('active');
                    }
                    if ($('#silverware').is(':checked')) {
                        $('.label-chinaware').removeClass('active');
                        $('.label-silverware').addClass('active');
                        $('.label-glassware').removeClass('active');
                    }
                    if ($('#glassware').is(':checked')) {
                        $('.label-chinaware').removeClass('active');
                        $('.label-silverware').removeClass('active');
                        $('.label-glassware').addClass('active');
                    }
                });
            } else {
                $('#typeware').empty();
            }
        });
    </script>
    <script>
        CKEDITOR.replace('desc');
    </script>
    @include('components.upload_image.js')
@endsection
