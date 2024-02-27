@extends('layout.app')
@section('title', 'Returning Form')
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
    <h3 class="h4 mb-4">Returning Form <span class="text-danger h5 font-weight-bold">
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
            <form method="POST" action="{{ route('loan.returning_store') }}">
                @csrf
                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="id">Order Code Borrowing</label>
                    <select class="form-control" name="id" id="id" required>
                        <option value=""></option>
                        @foreach ($loan as $item)
                            <option value="{{ $item->id }}">{{ $item->no_order }} | Name : {{ $item->borrowing_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="detail" class="form-group col-12 col-lg-8 collapse">
                    <div class="card card-body">
                        <table class="table border">
                            <tbody>
                                <tr>
                                    <td class="border" width="30%" scope="row">No Order</td>
                                    <td class="border" id="no_order"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Borrowing Name</td>
                                    <td class="border" id="borrowing_name"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Departmen</td>
                                    <td class="border" id="departmen"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Items</td>
                                    <td class="border" id="items"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Qty Items</td>
                                    <td class="border" id="qty_items"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Borrowing Date</td>
                                    <td class="border" id="borrowing_date"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Returning Date</td>
                                    <td class="border" id="returning_date"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Status</td>
                                    <td class="border" id="status"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Qty Borrowing</td>
                                    <td class="border" id="qty"></td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Return Name</td>
                                    <td class="border" id="return_name">-</td>
                                </tr>
                                <tr>
                                    <td class="border" width="30%" scope="row">Qty Return</td>
                                    <td class="border" id="qty_return">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="return_name">Returning Name</label>
                    <input type="text" placeholder="Masukan nama yang mengembalikan" class="form-control"
                        name="return_name" id="return_name" required>
                </div>

                <div class="form-group col-12 col-lg-8">
                    <label class="col-form-label" for="qty_return">Quantity Return</label>
                    <input type="number" placeholder="Masukan Jumlah Item yang akan dikembalikan" class="form-control"
                        name="qty_return" id="qty_return" required>
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
        $("#id").selectize({
            create: true,
            sortField: "text",
            placeholder: "Select Order Code ",
            create: false,
        });

        const loan = @json($loan);
        $('#id').change(function(e) {
            $('#detail').collapse('hide');
            e.preventDefault();
            setTimeout(() => {
                var value = $('#id').val();
                var result = '';
                $.each(loan, function(index, item) {
                    if (item.id == value) {
                        result = item;
                    }
                });
                var status = '';
                switch (result.status) {
                    case 'borrowed':
                        status = '<span class="badge badge-secondary">Borrowed</span>';
                        break;
                    case 'returned':
                        status = '<span class="badge badge-success">Returned</span>';
                        break;
                    case 'minus_return':
                        status = '<span class="badge badge-danger">Minus Return</span>';
                        break;

                    default:
                        break;
                }
                $('#no_order').text(result.no_order);
                $('#borrowing_name').text(result.borrowing_name);
                $('#departmen').text(result.departmen);
                $('#items').text(result.inventory.item_name);
                $('#qty_items').text(result.inventory.qty);
                $('#borrowing_date').text(result.borrowing_date);
                $('#returning_date').text(result.return_date);
                $('#status').html(status);
                $('#qty').text(result.qty);
                $('#return_name').text(result.return_name);
                $('#qty_return').text(result.qty_return);


                $('#detail').collapse('show');
            }, 500);
        });
    </script>
@endsection
