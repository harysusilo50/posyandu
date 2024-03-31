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
Route::get('/home', function () {
    return view('pages.home');
});
Route::get('/', function () {
    return view('pages.home');
})->name('home');
Route::get('admin/login', [LoginController::class, 'showLoginFormAdmin'])->name('admin.login');
Route::get('admin/keuangan', [KeuanganController::class, 'index'])->name('admin.keuangan.index');
// User
Route::resource('admin/user', UserController::class);
Route::get('admin/report/user', [UserController::class, 'export_pdf'])->name('user.report');

// Anggota
Route::resource('admin/anggota', AnggotaController::class);
Route::get('admin/report/anggota', [AnggotaController::class, 'export_pdf'])->name('anggota.report');

// Peralatan
Route::resource('admin/peralatan', PeralatanController::class);
Route::get('admin/report/peralatan', [PeralatanController::class, 'export_pdf'])->name('peralatan.report');

// Jadwal
Route::resource('admin/jadwal', JadwalController::class);
Route::get('admin/report/jadwal', [JadwalController::class, 'export_pdf'])->name('jadwal.report');
Route::post('admin/add/jenis-pelayanan', [JadwalController::class, 'add_jenis_pelayanan'])->name('jadwal.add_jenis_pelayanan');

// Pelayanan
Route::resource('admin/pelayanan', PelayananController::class);
Route::get('admin/report/pelayanan', [PelayananController::class, 'export_pdf'])->name('pelayanan.report');
Route::post('admin/add/jenis-imunisasi', [PelayananController::class, 'add_jenis_imunisasi'])->name('pelayanan.add_jenis_imunisasi');
Route::post('admin/add/jenis-vitamin', [PelayananController::class, 'add_jenis_vitamin'])->name('pelayanan.add_jenis_vitamin');
