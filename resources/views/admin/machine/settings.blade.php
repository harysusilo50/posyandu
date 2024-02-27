@extends('layout.app')
@section('title', 'Settings Machine')
@section('css')
    <style>
        .card {
            color: #5a5c69;
        }

        .card:hover {
            background-color: #858796;
            transition-duration: 500ms;
            color: white;
            font-size: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 px-4">
        <h3 class="h4 mb-0 "><i class="fas fa-cogs mr-1"></i> Settings Machine </h3>
    </div>

    <div class="row col-10 mx-auto mx-lg-0 col-lg-8 mb-3">
        <div class="col-lg-6">
            <a href="{{ route('admin.machine.settings.manual_pot_sink') }}"
                class="card shadow mb-4 rounded-lg text-decoration-none ">
                <!-- Card Body -->
                <div class="card-body text-center">
                    <img class="w-50 mb-2" src="{{ asset('img/manual_pot_sink.png') }}" alt="inventory">
                    <p class="text-center font-weight-bold ">Manual Pot Sink</p>
                </div>
            </a>
        </div>
        <div class="col-lg-6">
            <a href="{{ route('admin.machine.settings.high_temp_dish_machine') }}"
                class="card shadow mb-4 rounded-lg text-decoration-none ">
                <!-- Card Body -->
                <div class="card-body text-center">
                    <img class="w-50 mb-2" src="{{ asset('img/high_temp.png') }}" alt="inventory">
                    <p class="text-center font-weight-bold ">High Temp. Dish Machine</p>
                </div>
            </a>
        </div>
        <div class="col-lg-6">
            <a href="{{ route('admin.machine.settings.ice_machine_cleaning') }}"
                class="card shadow mb-4 rounded-lg text-decoration-none ">
                <!-- Card Body -->
                <div class="card-body text-center">
                    <img class="w-50 mb-2" src="{{ asset('img/ice_cleaning.png') }}" alt="inventory">
                    <p class="text-center font-weight-bold ">Ice Machine Cleaning</p>
                </div>
            </a>
        </div>
        <div class="col-lg-6">
            <a href="{{ route('admin.machine.settings.daily_scoop') }}"
                class="card shadow mb-4 rounded-lg text-decoration-none ">
                <!-- Card Body -->
                <div class="card-body text-center">
                    <img class="w-50 mb-2" src="{{ asset('img/daily_scoop.png') }}" alt="inventory">
                    <p class="text-center font-weight-bold ">Daily Scoop, Container Cleaning & Sanitation</p>
                </div>
            </a>
        </div>
    </div>


@endsection
