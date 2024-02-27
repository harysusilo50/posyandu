<?php

namespace App\Http\Controllers\Pages\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\WeeklyBreakage;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class WeeklyBreakageController extends Controller
{

    public function index()
    {
        return view('pages.inventory.weekly_breakage_list');
    }

    public function create()
    {
        $data = Inventory::get(['id', 'item_name', 'qty']);
        return view('pages.inventory.weekly_breakage_input', compact('data'));
    }


    public function store(Request $request)
    {
        try {
            $inventory = Inventory::findOrFail($request->inventory_id);
            $quantity_check = $inventory->qty - $request->total;
            if ($quantity_check < 0) {
                Alert::error('Failed', 'Total Breakage tidak sesuai dengan Inventory yang ada!');
                return redirect()->back();
            }
            $data = new WeeklyBreakage();
            $data->inventory_id = $request->inventory_id;
            $data->breakage_by = $request->breakage_by;
            $data->date = $request->date;
            $data->remarks = $request->remarks;
            $data->action_plan = $request->action_plan;
            $data->total = $request->total;
            $data->save();

            $inventory->qty = $quantity_check;
            $inventory->save();

            if ($data && $inventory) {
                Alert::success('Success', 'Berhasil menambah Data Weekly Breakage!');
                return redirect()->route('weekly-breakage.index');
            } else {
                Alert::error('Failed', 'Gagal menambah Data Weekly Breakage!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {

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
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function datatable_weekly_breakage()
    {
        $data = WeeklyBreakage::with('inventory:id,item_name')->get();

        return DataTables::of($data)->make(true);
    }
}
