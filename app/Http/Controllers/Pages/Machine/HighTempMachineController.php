<?php

namespace App\Http\Controllers\Pages\Machine;

use App\Http\Controllers\Controller;
use App\Models\HighTempMachine;
use App\Models\MachineSettings;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class HighTempMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['image'] = MachineSettings::where(['machine' => 'high_temp', 'type' => 'image'])->get();
        $desc = MachineSettings::where(['machine' => 'high_temp', 'type' => 'description'])->first();
        if (!empty($desc)) {
            $data['description'] = html_entity_decode($desc->value);
        } else {
            $data['description'] = '';
        }
        return view('pages.machine.high_temp_dish_machine.detail', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.machine.high_temp_dish_machine.create');
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
            $data = new HighTempMachine();
            $data->meal_period = $request->meal_period;
            $data->final_temp_rinse = $request->final_temp_rinse;
            $data->temp_from_dishwasher = $request->temp_from_dishwasher;
            $data->corrective_action = $request->corrective_action;
            $data->nama_petugas = $request->nama_petugas;
            $data->date = $request->date;
            $data->save();
            if ($data) {
                Alert::success('Success', 'Berhasil menambah Log!');
                return redirect()->route('high-temp-dish-machine.detail');
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
        //
    }

    public function detail()
    {

        return view('pages.machine.high_temp_dish_machine.index');
    }

    public function datatable_high_temp(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search['value'];
            if (empty($search)) {
                $data = HighTempMachine::all();
            } else {
                $data = HighTempMachine::where('nama_petugas', 'LIKE', "%$search%")
                    ->orWhere('date', 'LIKE', "%$search%")
                    ->orWhere('meal_period', 'LIKE', "%$search%")
                    ->orWhere('final_temp_rinse', 'LIKE', "%$search%")
                    ->orWhere('temp_from_dishwasher', 'LIKE', "%$search%")
                    ->latest()
                    ->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
