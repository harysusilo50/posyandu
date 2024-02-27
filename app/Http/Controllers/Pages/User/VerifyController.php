<?php

namespace App\Http\Controllers\Pages\User;

use App\Http\Controllers\Controller;
use App\Models\VerificationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VerifyController extends Controller
{

    public function not_verified()
    {
        if (!empty(Auth::user()->email_verified_at)) {
            return redirect()->route('home');
        }
        $data = VerificationUser::where('user_id', Auth::id())->first();
        return view('errors.not_verified', compact('data'));
    }

    public function user_send_verify(Request $request)
    {
        try {
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $folderPath = storage_path('app/public/image_tanda_pengenal/');
            $image_name =  Str::uuid() .  '_' . Auth::user()->nim . '' . '.' . $image_type;
            $file = $folderPath . '' . $image_name;

            $check = VerificationUser::where('user_id', Auth::id())->first();
            if (!empty($check)) {
                $check->tanda_pengenal = 'storage/image_tanda_pengenal/' . $image_name;
                $check->status = 'pending';
                $check->save();

                if ($check) {
                    file_put_contents($file, $image_base64);
                    $response = array(
                        'status' => 'success',
                        'message' => 'Berhasil mengubah Gambar!'
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Gagal mengubah Gambar!'
                    );
                }
                return response()->json($response);
            }
            $data = new VerificationUser();
            $data->user_id = Auth::id();
            $data->tanda_pengenal = 'storage/image_tanda_pengenal/' . $image_name;
            $data->status = 'pending';
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
}
