<?php

namespace App\Http\Controllers\Pages\Machine;

use App\Http\Controllers\Controller;
use App\Models\IceMachine;
use App\Models\MachineSettings;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class IceMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['image'] = MachineSettings::where(['machine' => 'ice_machine', 'type' => 'image'])->get();
        $desc = MachineSettings::where(['machine' => 'ice_machine', 'type' => 'description'])->first();
        if (!empty($desc)) {
            $data['description'] = html_entity_decode($desc->value);
        } else {
            $data['description'] = '';
        }
        return view('pages.machine.ice_machine_cleaning.detail', compact('data'));
    }

    public function create()
    {
        return view('pages.machine.ice_machine_cleaning.create');
    }


    public function store(Request $request)
    {
        $request->validate([

            'date' => 'required',
            'nama_petugas' => 'required',
            'meal_period' => 'required',
            'signature' => 'required'
        ], [
            'date.required' => 'Kolom Date/Tanggal harus diisi',
            'meal_period.required' => 'Kolom Meal Period harus diisi',
            'nama_petugas.required' => 'Kolom Nama Petugas harus diisi',
            'signature.required' => 'Kolom tanda tangan harus diisi',
        ]);

        $image_parts = explode(";base64,", $request->signature);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $folderPath = storage_path('app/public/');
        $name_image = 'signature/' . uniqid() . '_' . $request->nama_petugas . '.' . $image_type;
        $file = $folderPath . '' . $name_image;

        try {
            $data = new IceMachine();
            $data->date = $request->date;
            $data->nama_petugas = $request->nama_petugas;
            $data->meal_period = $request->meal_period;
            $data->spv_initial = $name_image;
            $data->save();
            if ($data) {
                file_put_contents($file, $image_base64);
                Alert::success('Success', 'Berhasil menambah Log!');
                return redirect()->route('ice-machine-cleaning.detail');
            } else {
                Alert::error('Failed', 'Gagal menambah Log!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $image_path = "signature/" . $data->signature;
        // Storage::disk('public')->delete($image_path);
    }

    public function detail()
    {

        return view('pages.machine.ice_machine_cleaning.index');
    }

    public function datatable_ice_machine(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search['value'];
            if (empty($search)) {
                $data = IceMachine::all();
            } else {
                $data = IceMachine::select('nama_petugas', 'date', 'spv_initial', 'created_at', 'updated_at')->where('nama_petugas', 'LIKE', "%$search%")->orWhere('date', 'LIKE', "%$search%")->orderBy('date', 'asc')->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
