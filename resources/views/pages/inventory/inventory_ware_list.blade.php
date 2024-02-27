@extends('layout.app')
@section('title', 'Inventory Ware List')
@section('content')
    <h3 class="h4 mb-4">INVENTORY WARE LIST</h3>
    <div class="px-lg-4 mb-5">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item"
                src="https://docs.google.com/presentation/d/e/{{ $slides->link ?? '' }}/embed?" allowfullscreen="true"
                mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
        </div>
    </div>
    <form action="{{ route('inventory.warelist') }}" method="GET">
        <div class="d-block d-md-flex mb-4">
            <div class="col-12 col-md-3">
                <h3 class="h4 mb-3">Inventory Ware</h3>
            </div>
            <div class="col-12 col-md-3">
                <select class="form-control border-primary" name="type" required>
                    <option value="all" {{ ($type == '' ? 'selected' : '' || $type == 'all') ? 'selected' : '' }}>All
                    </option>
                    <option value="silverware" {{ $type == 'silverware' ? 'selected' : '' }}>Silverware</option>
                    <option value="glassware" {{ $type == 'glassware' ? 'selected' : '' }}>Glassware</option>
                    <option value="chinaware" {{ $type == 'chinaware' ? 'selected' : '' }}>Chinaware</option>
                </select>
            </div>
            <div class="col-3 col-md-1 text-center my-1 my-md-0">
                <button class="btn btn-success btn-block" type="submit"><i class="fa fa-filter"
                        aria-hidden="true"></i></button>
            </div>
        </div>
    </form>
    <div class="row px-lg-4 mb-5">
        @foreach ($data as $item)
            <div class="col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3 mb-3">
                <div class="card shadow-sm">
                    <div class="p-2 rounded-lg mw-100">
                        <img class="card-img-top mx-auto mh-100" src="{{ asset($item->image) }}" alt="image product">
                    </div>
                    <div class="card-body">
                        @php
                            switch ($item->type) {
                                case 'chinaware':
                                    $badge = 'warning';
                                    break;
                                case 'glassware':
                                    $badge = 'success';
                                    break;
                                case 'silverware':
                                    $badge = 'info';
                                    break;
                                default:
                                    $badge = 'info';
                                    break;
                            }
                        @endphp
                        <span class="text-muted">{{ $item->pattern }}</span>
                        <h4 class="card-title mb-0 align-middle " style="height: 4rem;">{{ $item->title_card }}
                        </h4>
                        <span class="badge badge-{{ $badge }} text-capitalize"> {{ $item->type }} </span>
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
        {{ $data->withQueryString()->links() }}
    </div>

@endsection
