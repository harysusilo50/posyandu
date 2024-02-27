<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index()
    {
        return view('admin.user.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        $data = User::findOrFail($id);
        $data->delete();
        if ($data) {
            $response = array(
                'status' => 'success',
                'message' => 'Berhasil Menghapus Data Tugas'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Gagal Menghapus Data Tugas'
            );
        }
        return response()->json($response);
    }

    public function datatable_user()
    {
        $data = User::where('id', '!=', Auth::id())->whereNotNull('email_verified_at')->get();
        return DataTables::of($data)->make(true);
    }

    public function list_verify()
    {
        $data = VerificationUser::whereIn('status', ['pending', 'reject'])->with('user')->paginate(10);
        return view('admin.user.list-verify', compact('data'));
    }

    public function all()
    {
        return view('admin.user.user-all');
    }

    public function datatable_user_all()
    {
        $data = User::where('id', '!=', Auth::id())->get();
        return DataTables::of($data)->make(true);
    }

    public function verify_user(Request $request)
    {
        $id = $request->id;
        $user_id = $request->user_id;
        try {
            $verif = VerificationUser::findOrFail($id);
            $verif->status = 'accept';
            $verif->save();

            $user = User::findOrFail($user_id);
            $user->email_verified_at = now();
            $user->save();

            if ($user && $verif) {
                Alert::success('Success', 'Berhasil Verifikasi User!');
                return redirect()->back();
            } else {
                Alert::error('Failed', 'Berhasil Verifikasi User!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }
    public function reject_user(Request $request)
    {
        $id = $request->id;
        try {
            $verif = VerificationUser::findOrFail($id);
            $verif->status = 'reject';
            $verif->description = $request->description;
            $verif->save();

            if ($verif) {
                Alert::success('Success', 'Berhasil Reject Verifikasi User!');
                return redirect()->back();
            } else {
                Alert::error('Failed', 'Berhasil Reject Verifikasi User!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
