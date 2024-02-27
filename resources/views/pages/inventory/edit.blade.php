@extends('layout.app')
@section('title', 'Edit Inventory ' . $data->item_name)
@section('css')
    <style>
        .dropify-wrapper .dropify-message .file-icon {
            font-size: 24px !important;
        }
    </style>
@endsection
@section('content')
    <h3 class="h4 mb-4">Edit INVENTORY {{ $data->item_name }}</h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"> Create New Inventory </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('inventory.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-12 col-lg-4">
                    <div id="container_upload">
                        @include('components.upload_image.html')
                        <textarea id="image-dropify-send" class="d-none" name="image"></textarea>
                    </div>
                    <div id="container_photos">
                        <img class="w-75" src="{{ asset($data->image) }}" alt="{{ asset($data->image) }}">
                    </div>
                    <button class="btn btn-secondary mt-3" id="btn_change">
                        Change <i class="bi bi-arrow-repeat"></i>
                    </button>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label for="pattern" class="col-form-label" style="font-weight: 500">Pattern</label>
                    <input id="pattern" type="text" class="form-control" placeholder="Masukan Nomor Pattern"
                        name="pattern" value="{{ $data->pattern }}" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label for="item_name" class="col-form-label" style="font-weight: 500">Item Name</label>
                    <input id="item_name" type="text" placeholder="Masukan nama barang" class="form-control"
                        name="item_name" value="{{ $data->item_name }}" required>
                </div>

                <div class="form-group col-12">
                    <label class="col-form-label" style="font-weight: 500">
                        Category
                    </label>
                    <div class="form-check">
                        <input class=" form-check-inline check_category" value="ware" type="radio" name="category"
                            id="ware">
                        <label class="form-check-label" for="ware" style="font-weight: 500">
                            Ware List
                        </label>
                    </div>
                    <div class="form-check">
                        <input class=" form-check-inline check_category" value="chemical" type="radio" name="category"
                            id="chemical">
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
                        name="qty" value="{{ $data->qty }}" required>
                </div>

                <div class="form-group col-12">
                    <label for="desc" class="col-form-label" style="font-weight: 500">Deskripsi</label>
                    <textarea id="desc" class="form-control" name="desc" rows="5" required></textarea>
                </div>

                <div class="form-group col-12 text-center">
                    <a href="{{ route('admin.inventory.settings') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <textarea class="d-none" id="output">{!! $data->desc !!}</textarea>
@endsection
@section('js')
    <script>
        CKEDITOR.replace('desc');
        var test = $('textarea#output').val();
        $(document).ready(function() {
            CKEDITOR.instances['desc'].setData(test)
        });
    </script>
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

    <script>
        $(document).ready(function() {
            $('#container_upload').hide();

            $('#btn_change').click(function(e) {
                e.preventDefault();
                $('#container_upload').toggle('slow');
                $('#container_photos').toggle('slow');
            });
        });
    </script>
@endsection
