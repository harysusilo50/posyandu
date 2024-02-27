@extends('layout.app')
@section('title', $data->item_name)

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-weight: 500">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            @if ($data->category == 'ware')
                <li class="breadcrumb-item"><a href="{{ route('inventory.warelist') }}">Inventory Ware List</a></li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('inventory.chemicallist') }}">Inventory Chemical List</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $data->item_name }}</li>
        </ol>
    </nav>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted">Detail Item {{ $data->item_name }} </h6>
        </div>
        <div class="card-body">
            <div class="text-center">
                <img class="w-50" src="{{ asset($data->image) }}" alt="">
            </div>
            <div class="p-lg-3">
                {!! $data->desc !!}
            </div>
            <div class="p-lg-3">
                @if ($data->category == 'ware')
                    <a href="{{ route('inventory.warelist') }}" class="btn btn-danger">Kembali</a>
                @else
                    <a href="{{ route('inventory.chemicallist') }}" class="btn btn-danger">Kembali</a>
                @endif
            </div>
        </div>
    </div>
@endsection
