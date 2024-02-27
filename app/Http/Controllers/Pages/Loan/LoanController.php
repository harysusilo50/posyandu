<?php

namespace App\Http\Controllers\Pages\Loan;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    public function index()
    {
        return view('pages.loan.index');
    }

    public function borrowing_form()
    {
        $data = Inventory::get(['id', 'item_name', 'qty']);
        return view('pages.loan.borrowing_form', compact('data'));
    }

    public function borrowing_store(Request $request)
    {
        $request->validate([
            'borrowing_date' => 'required|date',
            'return_date' => 'required|date|after:borrowing_date',
            'inventory_id' => 'required'
        ], [
            'return_date.after' => 'Waktu Pengembalian tidak sesuai!',
            'inventory_id.required' => 'Kolom Item harus diisi'
        ]);
        try {
            $inventory = Inventory::findOrFail($request->inventory_id);
            $quantity_check = $inventory->qty - $request->qty;
            if ($quantity_check < 0) {
                Alert::error('Failed', 'Total Barang dipinjam tidak sesuai dengan Inventory yang ada!');
                return redirect()->back();
            }
            $image_parts = explode(";base64,", $request->signature);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $folderPath = storage_path('app/public/');
            $name_image = 'signature/' . uniqid() . '_' . $request->borrowing_name . '.' . $image_type;
            $file = $folderPath . '' . $name_image;

            $no_order = 'BR-' . $inventory->pattern . '-' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $data = new Loan();
            $data->inventory_id = $request->inventory_id;
            $data->no_order = $no_order;
            $data->borrowing_date = $request->borrowing_date;
            $data->return_date = $request->return_date;
            $data->status = $request->status;
            $data->borrowing_name = $request->borrowing_name;
            $data->status = 'borrowed';
            $data->qty = $request->qty;
            $data->departmen = $request->departmen;
            $data->signature_borrowing = $name_image;
            $data->save();

            $inventory->qty = $quantity_check;
            $inventory->save();

            if ($data && $inventory) {
                file_put_contents($file, $image_base64);
                Alert::success('Success', 'Berhasil menambah Data Peminjaman!');
                return redirect()->route('loan.index');
            } else {
                Alert::error('Failed', 'Gagal menambah Data Peminjaman!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function returning_store(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ], [
            'id.required' => 'Kolom Order Code harus diisi'
        ]);
        try {
            $loan = Loan::findOrFail($request->id);

            $inventory = Inventory::findOrFail($loan->inventory_id);
            $qty_return = empty($loan->qty_return) ? 0 : $loan->qty_return;
            $qty_return = $qty_return + $request->qty_return;
            $quantity_check = $loan->qty - $qty_return;
            $status = 'returned';

            if ($quantity_check > 0) {
                $status = 'minus_return';
            }
            if (!empty($loan->signature_return)) {
                $image_path = $loan->signature_return;
                Storage::disk('public')->delete($image_path);
            }
            $image_parts = explode(";base64,", $request->signature);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $folderPath = storage_path('app/public/');
            $name_image = 'signature/' . uniqid() . '_' . $request->return_name . '.' . $image_type;
            $file = $folderPath . '' . $name_image;

            $loan->return_name = $request->return_name;
            $loan->qty_return = $qty_return;
            $loan->status = $status;
            $loan->signature_return = $name_image;
            $loan->save();

            $inventory->qty = $inventory->qty + $request->qty_return;
            $inventory->save();

            if ($loan && $inventory) {
                file_put_contents($file, $image_base64);
                Alert::success('Success', 'Berhasil menambah Data Pengembalian!');
                return redirect()->route('loan.index');
            } else {
                Alert::error('Failed', 'Gagal menambah Data Pengembalian!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function returning_form()
    {
        $loan = Loan::with('inventory')->get();
        return view('pages.loan.returning_form', compact('loan'));
    }
    public function datatable_loan(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search['value'];
            if (empty($search)) {
                $data = Loan::with('inventory')
                    ->latest()
                    ->get();
            } else {
                $data = Loan::with('inventory')
                    ->where('no_order', 'LIKE', "%$search%")
                    ->orWhere('borrowing_date', 'LIKE', "%$search%")
                    ->orWhere('return_date', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%")
                    ->orWhere('borrowing_name', 'LIKE', "%$search%")
                    ->orWhere('return_name', 'LIKE', "%$search%")
                    ->orWhere('departmen', 'LIKE', "%$search%")
                    ->latest()
                    ->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
