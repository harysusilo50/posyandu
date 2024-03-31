<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peralatan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PeralatanController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data = Peralatan::Where('nama_peralatan', 'LIKE', "%$search%")
                ->orWhere('status', 'LIKE', "%$search%")
                ->latest()
                ->paginate(15)
                ->withQueryString();
            return view('pages.peralatan.index', compact('data', 'search'));
        }

        $data = Peralatan::latest()->paginate(15)->withQueryString();

        return view('pages.peralatan.index', compact('data'));
    }

    public function create()
    {
        return view('pages.peralatan.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_peralatan' => 'required|string',
            'jumlah' => 'required|numeric',
            'satuan' => 'required',
            'tgl_pembelian' => 'required',
            'status' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $peralatan = new Peralatan();
            $peralatan->nama_peralatan = $request->nama_peralatan;
            $peralatan->jumlah = $request->jumlah;
            $peralatan->satuan = $request->satuan;
            $peralatan->tgl_pembelian = $request->tgl_pembelian;
            $peralatan->status = $request->status;
            $peralatan->keterangan = $request->keterangan ?? '';
            $peralatan->save();
            DB::commit();
            Alert::success('Success', 'Berhasil menambahkan data peralatan!');
            return redirect()->route('peralatan.index');
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
        $peralatan = Peralatan::findOrFail($id);
        return view('pages.peralatan.edit', compact('peralatan'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_peralatan' => 'required|string',
            'jumlah' => 'required|numeric',
            'satuan' => 'required',
            'tgl_pembelian' => 'required',
            'status' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $peralatan = Peralatan::findOrFail($id);
            $peralatan->nama_peralatan = $request->nama_peralatan;
            $peralatan->jumlah = $request->jumlah;
            $peralatan->satuan = $request->satuan;
            $peralatan->tgl_pembelian = $request->tgl_pembelian;
            $peralatan->status = $request->status;
            $peralatan->keterangan = $request->keterangan ?? '';
            $peralatan->save();
            DB::commit();
            Alert::success('Success', 'Berhasil mengubah data peralatan!');
            return redirect()->route('peralatan.index');
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
            $peralatan = Peralatan::findOrFail($id);
            $peralatan->delete();

            DB::commit();
            Alert::success('Success', 'Peralatan berhasil dihapus!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function export_pdf()
    {
        $peralatan = Peralatan::all();

        $pdf = Pdf::loadview('pages.peralatan.report', ['peralatan' => $peralatan])->setPaper('a4', 'landscape');
        return $pdf->stream('peralatan-report_' . now() . '.pdf');
    }
}
