<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisImunisasi;
use App\Models\JenisVitamin;
use App\Models\Pelayanan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PelayananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $auth = Auth::user()->role ?? 'user';
        if ($search) {
            $data = Pelayanan::with('user')->where('nama', 'LIKE', "%$search%")
                ->orWhere('jenis_imunisasi', 'LIKE', "%$search%")
                ->orWhere('jenis_vitamin', 'LIKE', "%$search%")
                ->when($auth == 'user', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('pages.pelayanan.index', compact('data', 'search'));
        }

        $data = Pelayanan::with('user')->when($auth == 'user', function ($query) {
            $query->where('user_id', Auth::id());
        })->latest()->paginate(15)->withQueryString();

        return view('pages.pelayanan.index', compact('data'));
    }

    public function create()
    {
        $user = User::all();
        $jenis_imunisasi = JenisImunisasi::all();
        $jenis_vitamin = JenisVitamin::all();
        return view('pages.pelayanan.create', compact('jenis_imunisasi', 'jenis_vitamin', 'user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'tinggi_badan' => 'required',
            'berat_badan' => 'required',
            'jenis_imunisasi' => 'required',
            'jenis_vitamin' => 'required',
            'lingkar_kepala' => 'required',
            'tanggal_pelayanan' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $pelayanan = new Pelayanan();
            $pelayanan->user_id = $request->user_id;
            $pelayanan->tinggi_badan = $request->tinggi_badan;
            $pelayanan->berat_badan = $request->berat_badan;
            $pelayanan->jenis_imunisasi = $request->jenis_imunisasi;
            $pelayanan->jenis_vitamin = $request->jenis_vitamin;
            $pelayanan->lingkar_kepala = $request->lingkar_kepala;
            $pelayanan->tanggal_pelayanan = $request->tanggal_pelayanan;
            $pelayanan->save();
            DB::commit();
            Alert::success('Success', 'Berhasil menambahkan data pelayanan!');
            return redirect()->route('pelayanan.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pelayanan = Pelayanan::findOrFail($id);
        $user = User::all();
        $jenis_imunisasi = JenisImunisasi::all();
        $jenis_vitamin = JenisVitamin::all();
        return view('pages.pelayanan.edit', compact('jenis_imunisasi', 'jenis_vitamin', 'user', 'pelayanan'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'tinggi_badan' => 'required',
            'berat_badan' => 'required',
            'jenis_imunisasi' => 'required',
            'jenis_vitamin' => 'required',
            'lingkar_kepala' => 'required',
            'tanggal_pelayanan' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $pelayanan = Pelayanan::findOrFail($id);
            $pelayanan->user_id = $request->user_id;
            $pelayanan->tinggi_badan = $request->tinggi_badan;
            $pelayanan->berat_badan = $request->berat_badan;
            $pelayanan->jenis_imunisasi = $request->jenis_imunisasi;
            $pelayanan->jenis_vitamin = $request->jenis_vitamin;
            $pelayanan->lingkar_kepala = $request->lingkar_kepala;
            $pelayanan->tanggal_pelayanan = $request->tanggal_pelayanan;
            $pelayanan->save();
            DB::commit();
            Alert::success('Success', 'Berhasil mengubah data pelayanan!');
            return redirect()->route('pelayanan.index');
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
            $pelayanan = Pelayanan::findOrFail($id);
            $pelayanan->delete();

            DB::commit();
            Alert::success('Success', 'Pelayanan berhasil dihapus!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function add_jenis_imunisasi(Request $request)
    {
        $this->validate($request, [
            'add_jenis_imunisasi' => 'required|string',
        ]);
        try {
            $data = new JenisImunisasi();
            $data->nama = $request->add_jenis_imunisasi;
            $data->save();
            Alert::success('Success', 'Berhasil menambahkan data jenis imunisasi!');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function add_jenis_vitamin(Request $request)
    {
        $this->validate($request, [
            'add_jenis_vitamin' => 'required|string',
        ]);
        try {
            $data = new JenisVitamin();
            $data->nama = $request->add_jenis_vitamin;
            $data->save();
            Alert::success('Success', 'Berhasil menambahkan data jenis vitamin!');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function export_pdf()
    {
        $pelayanan = Pelayanan::with('user')->get();

        $pdf = Pdf::loadview('pages.pelayanan.report', ['pelayanan' => $pelayanan])->setPaper('a4', 'landscape');
        return $pdf->stream('pelayanan-report_' . now() . '.pdf');
    }
}
