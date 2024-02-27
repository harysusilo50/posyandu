@extends('layout.app')
@section('title', 'Requisition Equipment Form')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css"
        integrity="sha512-MMojOrCQrqLg4Iarid2YMYyZ7pzjPeXKRvhW9nZqLo6kPBBTuvNET9DBVWptAo/Q20Fy11EIHM5ig4WlIrJfQw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .kbw-signature {
            width: 300px;
            height: 200px;
        }
    </style>

@endsection
@section('content')
    <h3 class="h4 mb-4">Requisition Equipment Form <span class="text-danger h5 font-weight-bold">
            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            New</span></h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"> Create New Form </h6>
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
            <form method="POST" action="{{ route('loan.borrowing_store') }}">
                @csrf
                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="borrowing_name">Request By</label>
                    <input type="text" placeholder="Masukan nama peminjam" class="form-control" name="borrowing_name"
                        id="borrowing_name" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="select-item">Item</label>
                    <select class="form-control" name="inventory_id" id="select-item" required>
                        <option value=""></option>
                        @foreach ($data as $item)
                            <option value="{{ $item->id }}">{{ $item->item_name }} | Qty : {{ $item->qty }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="qty">Quantity</label>
                    <input type="number" placeholder="Masukan Jumlah Item yang akan dipinjam" class="form-control"
                        name="qty" id="qty" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="departmen">Departmen</label>
                    <input type="text" placeholder="Masukan nama departmen" class="form-control" name="departmen"
                        id="departmen" required>
                </div>
                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="borrowing_date">Borrowing Date</label>
                    <input type="date" class="form-control" name="borrowing_date" id="borrowing_date" required>
                </div>
                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="return_date">Returning Date</label>
                    <input type="date" class="form-control" name="return_date" id="return_date" required>
                </div>

                @include('components.signature.html')
                <textarea id="signature64" name="signature" style="display: none" required></textarea>

                <div class="form-group col-12 text-center">
                    <a href="{{ route('loan.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    @include('components.signature.js')
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
@endsection
