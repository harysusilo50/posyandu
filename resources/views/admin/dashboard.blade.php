@extends('layout.app')
@section('title', 'Dashboard Admin')
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
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 px-4">
        <h3 class="h4 mb-0 ">DASHBOARD</h3>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>
    <div class="row col-10 mx-auto mx-lg-0 col-lg-12 mb-3">
        <div class="col-lg-4">
            <a href="{{ route('inventory.warelist') }}" class="card shadow mb-4 rounded-lg text-decoration-none ">
                <!-- Card Body -->
                <div class="card-body text-center">
                    <img class="w-50 mb-2" src="{{ asset('img/dashboard_inventory.png') }}" alt="inventory">
                    <p class="text-center font-weight-bold ">INVENTORY</p>
                </div>
            </a>
        </div>
        {{-- <div class="col-lg-6">
            <a href="{{ route('manual-pot-sink.index') }}" class="card shadow mb-4 rounded-lg text-decoration-none ">
                <!-- Card Body -->
                <div class="card-body text-center">
                    <img class="w-50 mb-2" src="{{ asset('img/dashboard_machine.png') }}" alt="inventory">
                    <p class="text-center font-weight-bold ">MACHINE</p>
                </div>
            </a>
        </div> --}}
        <div class="col-lg-4">
            <a href="{{ route('loan.index') }}" class="card shadow mb-4 rounded-lg text-decoration-none ">
                <!-- Card Body -->
                <div class="card-body text-center">
                    <img class="w-50 mb-2" src="{{ asset('img/dashboard_loan.png') }}" alt="inventory">
                    <p class="text-center font-weight-bold ">LOAN</p>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="{{ route('task.index') }}" class="card shadow mb-4 rounded-lg text-decoration-none ">
                <!-- Card Body -->
                <div class="card-body text-center">
                    <img class="w-50 mb-2" src="{{ asset('img/dashboard_exercise.png') }}" alt="inventory">
                    <p class="text-center font-weight-bold ">TASK & EXERCISE</p>
                </div>
            </a>
        </div>
    </div>

    <h3 class="h4 px-4 mb-3">ABOUT</h3>
    <div class="text-justify px-4" style="font-size: 15px">
        <p>Stewarding Learning merupakan sebuah platform media pembelajaran yang dapat digunakan oleh
            para mahasiswa Pendidikan Kesejahteraan Keluarga konsentrasi Akomodasi Perhotelan. Khususnya
            mahasiswa yang sedang mempelajari mata kuliah stewarding. Dengan adanya platform media
            pembelajaran ini diharapkan mahasiswa dapat belajar mandiri dan dapat membantu menambah
            pengetahuan mahasiswa terhadap mata kuliah stewarding.</p>
        <p>
            Media pembelajaran ini dikembangkan oleh pengembang sebagai syarat kelulusan dan mendapatkan
            gelar Sarjana Pendidikan di Universitas Negeri Jakarta.
        </p>
        <p>
            Terima kasih banyak saya ucapkan kepada pihak yang telah membantu dalam proses pengembangan
            media pembelajaran ini diantaranya:
        </p>
    </div>
    <div class="text-center">
        <a href="{{ asset('web-guide.pdf') }}" target="blank" class="btn btn-primary col-10 col-lg-5"
            style="font-weight: 500">
            How to Use the Apps</a>
    </div>

@endsection
