<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Jadwal;
use App\Models\Keuangan;
use App\Models\Pelayanan;
use App\Models\Peralatan;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $anggota = Anggota::count();
        $jadwal = Jadwal::count();
        $user = User::where('role','user')->count();
        $peralatan = Peralatan::count();
        $pelayanan = Pelayanan::count();
        $total_masuk = Keuangan::where('type', 'masuk')->sum('nominal');
        $total_keluar = Keuangan::where('type', 'keluar')->sum('nominal');
        $total_keseluruhan =  $total_masuk - $total_keluar;

        return view('pages.home', compact(
            'anggota',
            'jadwal',
            'user',
            'peralatan',
            'pelayanan',
            'total_masuk',
            'total_keluar',
            'total_keseluruhan',
        ));
    }
}
