@extends('auth.layout')
@section('title', 'Login')
@section('content')
    <div class="row d0-flex justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card o-hidden border-0 shadow-lg my-lg-5 my-2">
                <div class="card-body p-0">
                    <div class="px-5 py-4">
                        <div class="text-center text-md-left">
                            <h1 class="h4 text-gray-900 mb-3" style="font-weight: 500">Login</h1>
                        </div>
                        <div class="text-center">
                            <img class="w-25" src="{{ asset('img/login.png') }}" alt="login icon">
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-1">
                                <label class="col-form-label" for="username" style="font-weight: 500">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="password" style="font-weight: 500">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button class="btn btn-primary btn-block" style="font-weight: 500" type="submit">Login</button>
                        </form>
                        <hr>
                        <div class="text-left small">
                            <span> Belum punya akun? <a href="{{ route('register') }}">Daftar Disini</a></span> <br>
                            <span> Masuk sebagai admin? <a href="{{ route('admin.login') }}">Klik Disini</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-7">
            <div class="card o-hidden border-0 shadow-lg my-lg-5 my-2">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-3" style="font-weight: 500">About</h1>
                        </div>
                        {{-- <div class="text-justify" style="font-size: 15px">
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
                        <a href="{{ asset('web-guide.pdf') }}" target="blank" class="btn btn-primary btn-block"
                            style="font-weight: 500">
                            How to Use the Apps</a> --}}
        {{-- </div>
                </div>
            </div>
        </div> --}}
    </div>

@endsection
