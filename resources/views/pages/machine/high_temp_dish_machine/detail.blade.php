@extends('layout.app')
@section('title', 'High Temp Dish Machine')

@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted">High Temp Dish Machine </h6>
        </div>
        <div class="card-body">
            <section class="splide bg-light m-md-5 rounded" aria-label="Basic Structure Example">
                <div class="splide__track">
                    <ul class="splide__list text-center">
                        @foreach ($data['image'] as $item)
                            <li class="splide__slide position-relative">
                                <img src="{{ asset('/' . $item->value) }}" class="img-fluid w-50 ">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
            <div class="p-lg-3">
                {!! $data['description'] !!}
            </div>

        </div>
        <div class="card-footer text-right">
            <a class="btn btn-primary" href="{{ route('high-temp-dish-machine.detail') }}">
                View Log
            </a>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var splide = new Splide('.splide', {
            type: 'loop',
            focus: 'center',
            perMove: 1,
        });

        splide.mount();
    </script>
@endsection
