@extends('auth.layout')
@section('title', 'Register')
@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="card o-hidden border-0 shadow-lg my-lg-5 my-2">
                <div class="card-body p-0">
                    <div class="px-5 py-4">
                        <div class="text-center text-md-left">
                            <h1 class="h4 text-gray-900 mb-3" style="font-weight: 500">Register</h1>
                        </div>
                        <div class="text-center">
                            <img class="w-50" src="{{ asset('img/register.png') }}" alt="register icon">
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-1">
                                <label class="col-form-label" for="name" style="font-weight: 500">Nama Lengkap</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-1">
                                <label class="col-form-label" for="nim" style="font-weight: 500">NIM</label>
                                <input id="nim" type="text" class="form-control @error('nim') is-invalid @enderror"
                                    name="nim" value="{{ old('nim') }}" required autocomplete="nim" autofocus>
                                @error('nim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-1">
                                <label class="col-form-label" for="email" style="font-weight: 500">Email</label>
                                <input id="email" type="text"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-1">
                                <label class="col-form-label" for="password" style="font-weight: 500">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="password-confirm" style="font-weight: 500">Konfirmasi
                                    Password</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <button class="btn btn-primary btn-block" style="font-weight: 500"
                                type="submit">Registrasi</button>
                        </form>
                        <hr>
                        <div class="text-left small">
                            <span> Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></span> <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card o-hidden border-0 shadow-lg my-lg-5 my-2">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-3" style="font-weight: 500">About</h1>
                        </div>
                        <div class="text-justify" style="font-size: 15px">
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
                            How to Use the Apps</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
