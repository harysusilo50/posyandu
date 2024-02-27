<?php

namespace App\Http\Controllers\Admin\Machine;

use App\Http\Controllers\Controller;
use App\Models\MachineSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class MachineController extends Controller
{
    public function settings()
    {
        return view('admin.machine.settings');
    }

    public function manual_pot_sink()
    {
        $data['image'] = MachineSettings::where(['machine' => 'manual_pot_sink', 'type' => 'image'])->get();
        $desc = MachineSettings::where(['machine' => 'manual_pot_sink', 'type' => 'description'])->first();
        if (!empty($desc)) {
            $data['description'] = html_entity_decode($desc->value);
        } else {
            $data['description'] = '';
        }

        return view('admin.machine.manual_pot_sink', compact('data'));
    }
    public function high_temp_dish_machine()
    {
        $data['image'] = MachineSettings::where(['machine' => 'high_temp', 'type' => 'image'])->get();
        $desc = MachineSettings::where(['machine' => 'high_temp', 'type' => 'description'])->first();
        if (!empty($desc)) {
            $data['description'] = html_entity_decode($desc->value);
        } else {
            $data['description'] = '';
        }
        return view('admin.machine.hight_temp_dish_machine', compact('data'));
    }
    public function ice_machine_cleaning()
    {
        $data['image'] = MachineSettings::where(['machine' => 'ice_machine', 'type' => 'image'])->get();
        $desc = MachineSettings::where(['machine' => 'ice_machine', 'type' => 'description'])->first();
        if (!empty($desc)) {
            $data['description'] = html_entity_decode($desc->value);
        } else {
            $data['description'] = '';
        }

        return view('admin.machine.ice_machine_cleaning', compact('data'));
    }
    public function daily_scoop()
    {
        $data['image'] = MachineSettings::where(['machine' => 'daily_scoop', 'type' => 'image'])->get();
        $desc = MachineSettings::where(['machine' => 'daily_scoop', 'type' => 'description'])->first();
        if (!empty($desc)) {
            $data['description'] = html_entity_decode($desc->value);
        } else {
            $data['description'] = '';
        }

        return view('admin.machine.daily_scoop', compact('data'));
    }

    public function upload_image(Request $request)
    {
        try {
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $folderPath = storage_path('app/public/image_' . $request->machine . '/');
            $image_name =  Str::uuid() .  '_' . $request->machine . '' . '.' . $image_type;
            $file = $folderPath . '' . $image_name;

            $data = new MachineSettings();
            $data->type = 'image';
            $data->machine = $request->machine;
            $data->value = 'storage/image_' . $request->machine . '/' . $image_name;
            $data->save();
            if ($data) {
                file_put_contents($file, $image_base64);
                $response = array(
                    'status' => 'success',
                    'message' => 'Berhasil mengupload Gambar!'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal mengupload Gambar!'
                );
            }
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
    public function upload_description(Request $request)
    {
        try {
            $data = MachineSettings::updateOrCreate([
                'type' => 'description',
                'machine' => $request->machine
            ], [
                'value' => $request->value
            ]);
            if ($data) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Berhasil mengupload Deskripsi!'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal mengupload Deskripsi!'
                );
            }
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function delete_image(Request $request)
    {
        $id = $request->input('id');
        $data = MachineSettings::findOrFail($id);
        $check = explode('/', $data->value);
        $merge = array_merge([$check[1], $check[2]]);
        $file = implode('/', $merge);
        $data->delete();
        if ($data) {
            Storage::disk('public')->delete($file);
            $response = array(
                'status' => 'success',
                'message' => 'Berhasil Menghapus Gambar'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal Menghapus Gambar'
            );
        }
        return response()->json($response);
    }
}
