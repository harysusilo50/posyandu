@extends('layout.app')
@section('title', 'Inventory Chemical List')
@section('content')
    <h3 class="h4 mb-4">INVENTORY CHEMICAL LIST</h3>
    <div class="px-lg-4 mb-5">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item"
                src="https://docs.google.com/presentation/d/e/{{ $slides->link ?? '' }}/embed?" allowfullscreen="true"
                mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
        </div>
    </div>
    <div class="d-block d-md-flex mb-4">
        <div class="col-12 col-md-3">
            <h3 class="h4 mb-3">Inventory Chemical</h3>
        </div>
        {{-- <div class="col-12 col-md-3">
            <select class="form-control border-primary" name="" id="" required>
                <option disabled selected>Choose Type</option>
            </select>
        </div> --}}
    </div>
    <div class="row px-lg-4 mb-5">
        @foreach ($data as $item)
            <div class="col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3 mb-3">
                <div class="card shadow-sm">
                    <div class="p-2 rounded-lg mw-100">
                        <img class="card-img-top mx-auto mh-100" src="{{ asset($item->image) }}" alt="image product">
                    </div>
                    <div class="card-body">
                        <span class="text-muted">{{ $item->pattern }}</span>
                        <h4 class="card-title mb-0 align-middle " style="height: 4rem;">{{ $item->title_card }}
                        </h4>
                        <p class="text-danger text-right font-weight-bolder">Stock : {{ $item->qty }}</p>
                        <div class="text-right ">
                            <form action="{{ route('inventory.show') }}" method="get">
                                <input type="text" class="d-none" name="id" value="{{ encrypt($item->id) }}">
                                <button type="submit" class="btn btn-primary btn-sm col-6">
                                    Detail
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $data->links() }}
    </div>
@endsection
