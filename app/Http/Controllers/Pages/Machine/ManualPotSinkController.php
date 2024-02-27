<?php

namespace App\Http\Controllers\Pages\Machine;

use App\Http\Controllers\Controller;
use App\Models\MachineSettings;
use App\Models\ManualPotSink;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ManualPotSinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['image'] = MachineSettings::where(['machine' => 'manual_pot_sink', 'type' => 'image'])->get();
        $desc = MachineSettings::where(['machine' => 'manual_pot_sink', 'type' => 'description'])->first();
        if (!empty($desc)) {
            $data['description'] = html_entity_decode($desc->value);
        } else {
            $data['description'] = '';
        }
        return view('pages.machine.manual_pot_sink.detail', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.machine.manual_pot_sink.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = new ManualPotSink();
            $data->meal_period = $request->meal_period;
            $data->wash_temp = $request->wash_temp;
            $data->sanitizer_temp = $request->sanitizer_temp;
            $data->sanitizer_strength = $request->sanitizer_strength;
            $data->sanitizer_type = $request->sanitizer_type;
            $data->nama_petugas = $request->nama_petugas;
            $data->date = $request->date;
            $data->save();
            if ($data) {
                Alert::success('Success', 'Berhasil menambah Log!');
                return redirect()->route('manual-pot-sink.detail');
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
        //
    }

    public function detail()
    {
        return view('pages.machine.manual_pot_sink.index');
    }

    public function datatable_manual_pot_sink(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search['value'];
            if (empty($search)) {
                $data = ManualPotSink::all();
            } else {
                $data = ManualPotSink::where('nama_petugas', 'LIKE', "%$search%")
                    ->orWhere('date', 'LIKE', "%$search%")
                    ->orWhere('meal_period', 'LIKE', "%$search%")
                    ->orWhere('wash_temp', 'LIKE', "%$search%")
                    ->orWhere('sanitizer_temp', 'LIKE', "%$search%")
                    ->orWhere('sanitizer_strength', 'LIKE', "%$search%")
                    ->orWhere('sanitizer_type', 'LIKE', "%$search%")
                    ->latest()
                    ->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
