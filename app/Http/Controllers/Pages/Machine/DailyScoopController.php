<?php

namespace App\Http\Controllers\Pages\Machine;

use App\Http\Controllers\Controller;
use App\Models\DailyScoop;
use App\Models\MachineSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class DailyScoopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['image'] = MachineSettings::where(['machine' => 'daily_scoop', 'type' => 'image'])->get();
        $desc = MachineSettings::where(['machine' => 'daily_scoop', 'type' => 'description'])->first();
        if (!empty($desc)) {
            $data['description'] = html_entity_decode($desc->value);
        } else {
            $data['description'] = '';
        }
        return view('pages.machine.daily_scoop.detail', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.machine.daily_scoop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'time' => 'required',
            'date' => 'required',
            'nama_petugas' => 'required',
        ], [
            'time.required' => 'Kolom Time/Waktu harus diisi',
            'date.required' => 'Kolom Date/Tanggal harus diisi',
            'nama_petugas.required' => 'Kolom Nama Petugas harus diisi',
        ]);

        try {
            $data = new DailyScoop();
            $data->date = $request->date;
            $data->nama_petugas = $request->nama_petugas;
            $data->time = $request->time;
            $data->save();
            if ($data) {
                Alert::success('Success', 'Berhasil menambah Log!');
                return redirect()->route('daily-scoop.detail');
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

        return view('pages.machine.daily_scoop.index');
    }

    public function datatable_daily_scoop(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search['value'];
            if (empty($search)) {
                $data = DB::select(
                    DB::raw('
                        SELECT * 
                        FROM daily_scoops a 
                        ORDER BY a.date ASC
                    ')
                );
            } else {
                $data = DB::select(
                    DB::raw('
                        SELECT * 
                        FROM daily_scoops a 
                        WHERE a.nama_petugas LIKE "%' . $search . '%" OR a.date LIKE "%' . $search . '%"
                        ORDER BY a.date ASC
                    ')
                );
            }
            $temp = [];
            $result = [];
            foreach ($data as $key => $value) {
                Carbon::setLocale('id');
                $date = $value->date;
                if (isset($temp[$date])) {
                    $temp[$date]['date'] = $value->date;
                    switch ($value->time) {
                        case '08.00':
                            $temp[$date]['time']['08.00'][] = $value->nama_petugas;
                            break;
                        case '12.00':
                            $temp[$date]['time']['12.00'][] = $value->nama_petugas;
                            break;
                        case '16.00':
                            $temp[$date]['time']['16.00'][] = $value->nama_petugas;
                            break;
                        case '20.00':
                            $temp[$date]['time']['20.00'][] = $value->nama_petugas;
                            break;

                        default:
                            break;
                    }
                } else {
                    switch ($value->time) {
                        case '08.00':
                            $time = ['08.00' => [$value->nama_petugas]];
                            break;
                        case '12.00':
                            $time = ['12.00' => [$value->nama_petugas]];
                            break;
                        case '16.00':
                            $time = ['16.00' => [$value->nama_petugas]];
                            break;
                        case '20.00':
                            $time = ['20.00' => [$value->nama_petugas]];
                            break;

                        default:
                            break;
                    }

                    $temp[$date] = [
                        'date' => $value->date,
                        'time' => $time
                    ];
                }
            }
            foreach ($temp as $value) {
                $value['time'] = (object) $value['time'];
                foreach ($value['time'] as $key => $item) {
                    $value['time']->$key = implode(', ', $item);
                }
                $result[] = (object)$value;
            }
            $json = collect($result);
            // dd($json);
            return DataTables::of($json->sortDesc())
                ->addIndexColumn()
                ->make(true);
        }
    }
}
