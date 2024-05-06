<?php

use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PeralatanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\PelayananController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function () {
    return view('index');
});
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('login-admin', [LoginController::class, 'showLoginFormAdmin'])->name('admin.login');
Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/dashboard', function () {
            return view('pages.home');
        })->name('home');

        // User
        Route::resource('user', UserController::class);
        Route::get('report/user', [UserController::class, 'export_pdf'])->name('user.report');

        // Anggota
        Route::resource('anggota', AnggotaController::class);
        Route::get('report/anggota', [AnggotaController::class, 'export_pdf'])->name('anggota.report');

        // Peralatan
        Route::resource('peralatan', PeralatanController::class);
        Route::get('report/peralatan', [PeralatanController::class, 'export_pdf'])->name('peralatan.report');

        // Jadwal
        Route::resource('jadwal', JadwalController::class);
        Route::get('report/jadwal', [JadwalController::class, 'export_pdf'])->name('jadwal.report');
        Route::post('add/jenis-pelayanan', [JadwalController::class, 'add_jenis_pelayanan'])->name('jadwal.add_jenis_pelayanan');

        // Pelayanan
        Route::resource('pelayanan', PelayananController::class);
        Route::get('report/pelayanan', [PelayananController::class, 'export_pdf'])->name('pelayanan.report');
        Route::post('add/jenis-imunisasi', [PelayananController::class, 'add_jenis_imunisasi'])->name('pelayanan.add_jenis_imunisasi');
        Route::post('add/jenis-vitamin', [PelayananController::class, 'add_jenis_vitamin'])->name('pelayanan.add_jenis_vitamin');

        // Keuangan
        Route::resource('/keuangan', KeuanganController::class);
        Route::get('/keuangan/report/', [KeuanganController::class, 'report'])->name('keuangan.report');
    }
);
