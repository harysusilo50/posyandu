<?php

namespace App\Http\Controllers\Pages\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventorySettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;

class InventoryController extends Controller
{
    public function inventoryWareList(Request $request)
    {
        $type = $request->input('type');
        $slides = InventorySettings::where('type', 'ware')->first();
        if (empty($type) || $type == 'all') {
            $data = Inventory::select('id', 'image', 'pattern', 'item_name', 'qty', 'category', 'type')->where('category', 'ware')->latest()->paginate(8);
            return view('pages.inventory.inventory_ware_list', compact('data', 'type', 'slides'));
        }
        $data = Inventory::select('id', 'image', 'pattern', 'item_name', 'qty', 'category', 'type')->where(['category' => 'ware', 'type' => $type])->latest()->paginate(8);
        return view('pages.inventory.inventory_ware_list', compact('data', 'type', 'slides'));
    }
    public function inventoryChemicalList()
    {
        $slides = InventorySettings::where('type', 'chemical')->first();
        $data = Inventory::select('id', 'image', 'pattern', 'item_name', 'qty', 'category')->where('category', 'chemical')->latest()->paginate(8);
        return view('pages.inventory.inventory_chemical_list', compact('data', 'slides'));
    }
    public function createInventory()
    {
        return view('pages.inventory.input');
    }

    public function editInventory($id)
    {
        $data = Inventory::findOrFail($id);
        return view('pages.inventory.edit', compact('data'));
    }

    public function storeInventory(Request $request)
    {
        try {
            $data = new Inventory();
            $data->pattern = $request->pattern;
            $data->item_name = $request->item_name;
            $data->qty = $request->qty;
            $data->desc = $request->desc;
            $data->category = $request->category;
            $data->type = $request->type;

            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $folderPath = storage_path('app/public/image_inventory/');
            $image_name =  date('YmdHi') .  '_' . $request->item_name . '_' . $request->category . '.' . $image_type;
            $file = $folderPath . '' . $image_name;
            file_put_contents($file, $image_base64);

            $data->image = 'storage/image_inventory/' . $image_name;
            $data->save();
            if ($data) {
                Alert::success('Success', 'Berhasil menambah Data Inventory!');
                return redirect()->back();
            } else {
                Alert::error('Failed', 'Gagal menambah Data Inventory!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {

            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function updateInventory(Request $request, $id)
    {
        try {
            $data = Inventory::findOrFail($id);
            $data->pattern = $request->pattern;
            $data->item_name = $request->item_name;
            $data->qty = $request->qty;
            $data->desc = $request->desc;
            $data->category = $request->category ?? $data->category;
            $data->type = $request->type ?? $data->type;

            if ($request->image) {
                $filenamePhotos = explode('/', $data->image);
                Storage::disk('public')->delete('image_inventory/' . $filenamePhotos[2]);

                $image_parts = explode(";base64,", $request->image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);

                $folderPath = storage_path('app/public/image_inventory/');
                $image_name =  date('YmdHi') .  '_' . $request->item_name . '_' . $data->category . '.' . $image_type;
                $file = $folderPath . '' . $image_name;
                file_put_contents($file, $image_base64);
                $data->image = 'storage/image_inventory/' . $image_name;
            }
            $data->save();
            if ($data) {
                Alert::success('Success', 'Berhasil mengubah Data Inventory!');
                return redirect()->back();
            } else {
                Alert::error('Failed', 'Gagal mengubah Data Inventory!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {

            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function showInventory(Request $request)
    {
        $data = Inventory::findOrFail(decrypt($request->id));
        return view('pages.inventory.show', compact('data'));
    }
}
