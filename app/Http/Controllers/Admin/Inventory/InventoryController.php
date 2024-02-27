<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventorySettings;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventoryController extends Controller
{
    public function settings(Request $request)
    {
        $search = $request->get('search');
        $link_ware = InventorySettings::where('type', 'ware')->first();
        $link_chemical = InventorySettings::where('type', 'chemical')->first();
        if ($search) {
            $data = Inventory::where('item_name', 'LIKE', "%$search%")
                ->orWhere('pattern', 'LIKE', "%$search%")
                ->latest()
                ->paginate(10)
                ->withQueryString();
            return view('admin.inventory.settings', compact('data', 'search', 'link_ware', 'link_chemical'));
        }
        $data = Inventory::paginate(10)->withQueryString();
        return view('admin.inventory.settings', compact('data', 'link_ware', 'link_chemical'));
    }

    public function update_slide_link(Request $request)
    {
        $request->validate([
            'link' => 'required',
        ], [
            'link.required' => 'Link harus diisi!',
        ]);
        try {
            $data = InventorySettings::where('type', $request->type)->first();
            if (empty($data)) {
                $data = new InventorySettings();
            }
            $data->type = $request->type;
            $data->link = $request->link;
            $data->save();

            if ($data) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Berhasil mengupdate link ' . $request->type . ' list !',
                    'link' => $data->link
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal mengupdate link!'
                );
            }
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = Inventory::findOrFail($id);
            $data->delete();
            if ($data) {
                Alert::success('Success', 'Berhasil Menghapus Data!');
                return redirect()->back();
            } else {
                Alert::success('Error', 'Gagal Menghapus Data!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
