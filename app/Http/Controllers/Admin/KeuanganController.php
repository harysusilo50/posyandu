<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KeuanganController extends Controller
{

    public function index(Request $request)
    {
        $total_masuk = Keuangan::where('type', 'masuk')->sum('nominal');
        $total_keluar = Keuangan::where('type', 'keluar')->sum('nominal');
        $total_keseluruhan =  $total_masuk - $total_keluar;

        $type = $request->get('type');
        if ($type == 'in') {
            $search = $request->get('search');
            if ($search) {
                $data = Keuangan::Where('keterangan', 'LIKE', "%$search%")
                    ->orWhere('type', 'masuk')
                    ->orWhere('jenis', 'LIKE', "%$search%")
                    ->orWhere('nominal', 'LIKE', "%$search%")
                    ->orWhere('tanggal', 'LIKE', "%$search%")
                    ->latest()
                    ->paginate(15)
                    ->withQueryString();
                return view('pages.keuangan.index', compact('data', 'search', 'type', 'total_masuk', 'total_keluar', 'total_keseluruhan'));
            }

            $data = Keuangan::where('type', 'masuk')->latest()->paginate(15)->withQueryString();

            return view('pages.keuangan.index', compact('data', 'type', 'total_masuk', 'total_keluar', 'total_keseluruhan'));
        } else if ($type == 'out') {
            $search = $request->get('search');
            if ($search) {
                $data = Keuangan::Where('keterangan', 'LIKE', "%$search%")
                    ->orWhere('type', 'keluar')
                    ->orWhere('jenis', 'LIKE', "%$search%")
                    ->orWhere('nominal', 'LIKE', "%$search%")
                    ->orWhere('tanggal', 'LIKE', "%$search%")
                    ->latest()
                    ->paginate(15)
                    ->withQueryString();
                return view('pages.keuangan.index', compact('data', 'search', 'type', 'total_masuk', 'total_keluar', 'total_keseluruhan'));
            }

            $data = Keuangan::where('type', 'keluar')->latest()->paginate(15)->withQueryString();

            return view('pages.keuangan.index', compact('data', 'type', 'total_masuk', 'total_keluar', 'total_keseluruhan'));
        } else {
            $search = $request->get('search');
            if ($search) {
                $data = Keuangan::Where('keterangan', 'LIKE', "%$search%")
                    ->orWhere('jenis', 'LIKE', "%$search%")
                    ->orWhere('nominal', 'LIKE', "%$search%")
                    ->orWhere('tanggal', 'LIKE', "%$search%")
                    ->latest()
                    ->paginate(15)
                    ->withQueryString();
                return view('pages.keuangan.index', compact('data', 'search', 'type', 'total_masuk', 'total_keluar', 'total_keseluruhan'));
            }

            $data = Keuangan::latest()->paginate(15)->withQueryString();

            return view('pages.keuangan.index', compact('data', 'type', 'total_masuk', 'total_keluar', 'total_keseluruhan'));
        }
    }

    public function create()
    {
        return view('pages.keuangan.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $keuangan = new Keuangan();
            $keuangan->type = $request->type;
            $keuangan->jenis = $request->jenis;
            $keuangan->nominal = $request->nominal;
            $keuangan->tanggal = $request->tanggal;
            $keuangan->keterangan = $request->keterangan ?? '';
            $keuangan->save();
            DB::commit();
            Alert::success('Success', 'Berhasil menambahkan data keuangan!');
            return redirect()->route('keuangan.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return view('pages.keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $keuangan = Keuangan::findOrFail($id);
            $keuangan->type = $request->type;
            $keuangan->jenis = $request->jenis;
            $keuangan->nominal = $request->nominal;
            $keuangan->tanggal = $request->tanggal;
            $keuangan->keterangan = $request->keterangan ?? '';
            $keuangan->save();
            DB::commit();
            Alert::success('Success', 'Berhasil mengubah data keuangan!');
            return redirect()->route('keuangan.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $keuangan = Keuangan::findOrFail($id);
            $keuangan->delete();

            DB::commit();
            Alert::success('Success', 'Data Keuangan berhasil dihapus!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function report()
    {
        $keuangan = Keuangan::all();

        $total_masuk = Keuangan::where('type', 'masuk')->sum('nominal');
        $total_keluar = Keuangan::where('type', 'keluar')->sum('nominal');
        $total_keseluruhan =  $total_masuk - $total_keluar;

        $pdf = Pdf::loadview('pages.keuangan.report', ['keuangan' => $keuangan, 'total_masuk' => $total_masuk, 'total_keluar' => $total_keluar, 'total_keseluruhan' => $total_keseluruhan])->setPaper('a4', 'landscape');
        return $pdf->stream('keuangan-report_' . now() . '.pdf');
    }
}
