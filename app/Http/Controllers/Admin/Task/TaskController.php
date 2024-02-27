<?php

namespace App\Http\Controllers\Admin\Task;

use App\Exports\GradeExport;
use App\Http\Controllers\Controller;
use App\Models\ListTask;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{

    public function index()
    {

        return view('admin.task.index');
    }


    public function create()
    {
        return view('admin.task.create');
    }


    public function store(Request $request)
    {
        if ($request->tipe == 'tugas') {
            $request->validate([
                'file' => 'required|max:2048|mimetypes:application/pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation|mimes:pdf,pptx,ppt',
            ], [
                'file.required' => 'Kolom Deskripsi Tugas harus diisi',
                'file.mimetypes' => 'Format salah! Hanya PPT,PPTX, atau PDF yang diizinkan.',
                'file.mimes' => 'Format salah! Hanya PPT,PPTX, atau PDF yang diizinkan.',
                'file.max' => 'Ukuran file tidak boleh melebihi 2 MB.'
            ]);
        }

        try {
            $data = new Task();
            $data->judul = $request->judul;
            $data->deadline_tugas = Carbon::createFromFormat('Y-m-d H:i', $request->deadline_date . ' ' . $request->deadline_time);
            $data->tipe = $request->tipe;

            if ($request->tipe == 'tugas') {
                $pptFile = $request->file('file');
                $folderPath = storage_path('app/public/deskripsi_tugas/');
                $filename = uniqid() . '_' . $pptFile->getClientOriginalName();
                $pptFile->move($folderPath, $filename);

                $data->file = 'storage/deskripsi_tugas/' . $filename;
            } else {
                $data->link = $request->link;
            }

            $data->save();
            if ($data) {
                Alert::success('Success', 'Berhasil menambah Tugas!');
                return redirect()->route('task.index');
            } else {
                Alert::error('Failed', 'Gagal menambah Tugas!');
                return redirect()->route('task.create');
            }
        } catch (\Throwable $th) {

            Alert::error('Failed', $th->getMessage());
            return redirect()->route('task.create');
        }
    }


    public function show($id)
    {
        $task = Task::where('id', $id)->first();
        $data = ListTask::where('task_id', $id)->with('user', 'task')->paginate(10);
        return view('admin.task.show', compact('data', 'task'));
    }

    public function show_link($id)
    {
        $task = Task::where('id', $id)->first();
        $users = User::where('role', 'user')->paginate(10);
        $data = $users->map(function ($value) use ($task) {
            $grading = ListTask::where(['task_id' => $task->id, 'user_id' => $value->id])->first();
            $value->grading = $grading ? $grading->grading : null;
            return $value;
        });
        return view('admin.task.show-link', compact('users', 'task'));
    }


    public function edit($id)
    {
        $data = Task::findOrFail($id);
        return view('admin.task.edit', compact('data'));
    }


    public function update(Request $request, $id)
    {
        if ($request->tipe == 'tugas') {
            $request->validate([
                'file' => 'mimetypes:application/pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation|mimes:pdf,pptx,ppt',
            ], [
                'file.mimetypes' => 'Format salah! Hanya PPT,PPTX, atau PDF yang diizinkan.',
                'file.mimes' => 'Format salah! Hanya PPT,PPTX, atau PDF yang diizinkan.',
            ]);
        }

        try {
            $data = Task::findOrFail($id);
            $data->judul = $request->judul;
            $data->deadline_tugas = Carbon::createFromFormat('Y-m-d H:i', $request->deadline_date . ' ' . $request->deadline_time);
            $data->tipe = $request->tipe;

            if ($request->tipe == 'tugas') {
                $pptFile = $request->file('file');
                $folderPath = storage_path('app/public/deskripsi_tugas/');
                $filename = uniqid() . '_' . $pptFile->getClientOriginalName();
                $pptFile->move($folderPath, $filename);

                $data->file = 'storage/deskripsi_tugas/' . $filename;
                $data->link = NULL;
            } else {

                $data->link = $request->link;
                $data->tugas = NULL;
            }

            $data->save();
            if ($data) {
                Alert::success('Success', 'Berhasil mengubah Tugas!');
                return redirect()->route('task.index');
            } else {
                Alert::error('Failed', 'Gagal mengubah Tugas!');
                return redirect()->route('task.edit', $id);
            }
        } catch (\Throwable $th) {
            dd($th);
            // Alert::error('Failed', $th->getMessage());
            // return redirect()->route('task.edit', $id);
        }
    }


    public function destroy($id)
    {
        $data = Task::findOrFail($id);
        if ($data->tipe == "tugas") {
            $check = explode('/', $data->file);
            $merge = array_merge([$check[1], $check[2]]);
            $file = implode('/', $merge);
        }
        $data->delete();
        $delete_tasks_list = ListTask::where('task_id', $id)->delete();

        if ($data && $delete_tasks_list) {
            if ($data->tipe == "tugas") {
                Storage::disk('public')->delete($file);
            }
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

    public function datatable_task()
    {
        $data = Task::all();
        return DataTables::of($data)->make(true);
    }

    public function correction_submition(Request $request)
    {
        $user_id = $request->user_id;
        $task_id = $request->task_id;
        try {
            if ($request->status == 'reject') {
                $data = ListTask::where(['task_id' => $task_id, 'user_id' => $user_id])->update([
                    'status' => $request->status,
                    'notes_lecturer' => $request->notes_lecturer
                ]);
                if ($data) {
                    Alert::success('Success', 'Berhasil memberikan Catatan!');
                    return redirect()->back();
                } else {
                    Alert::error('Failed', 'Gagal memberikan Catatan!');
                    return redirect()->back();
                }
            } else {
                $data = ListTask::where(['task_id' => $task_id, 'user_id' => $user_id])->update([
                    'status' => $request->status,
                    'grading' => $request->grading,
                    'notes_lecturer' => $request->notes_lecturer
                ]);
                if ($data) {
                    Alert::success('Success', 'Berhasil memberikan Nilai!');
                    return redirect()->back();
                } else {
                    Alert::error('Failed', 'Gagal memberikan Nilai!');
                    return redirect()->back();
                }
            }
        } catch (\Throwable $th) {

            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function add_grading_link(Request $request)
    {
        $user_id = $request->user_id;
        $task_id = $request->task_id;
        try {
            $check = ListTask::where(['user_id' => $user_id, 'task_id' => $task_id])->first();
            if (empty($check)) {
                $data = new ListTask();
                $data->user_id = $user_id;
                $data->task_id = $task_id;
                $data->submission = 'link';
                $data->grading = $request->grading;
                $data->notes_lecturer = $request->notes_lecturer;
                $data->save();

                if ($data) {
                    Alert::success('Success', 'Berhasil memberikan Nilai!');
                    return redirect()->back();
                } else {
                    Alert::error('Failed', 'Gagal memberikan Nilai!');
                    return redirect()->back();
                }
            }
            $check->grading = $request->grading;
            $check->notes_lecturer = $request->notes_lecturer;
            $check->save();
            if ($check) {
                Alert::success('Success', 'Berhasil memberikan Nilai!');
                return redirect()->back();
            } else {
                Alert::error('Failed', 'Gagal memberikan Nilai!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function export_grade_excel($task_id)
    {
        $data = Task::findOrFail($task_id);
        $fileName = 'Nilai Tugas ' . $data->judul . '.xlsx';
        return Excel::download(new GradeExport($task_id), $fileName);
    }
}
