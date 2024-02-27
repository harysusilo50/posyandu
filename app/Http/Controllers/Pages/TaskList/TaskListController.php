<?php

namespace App\Http\Controllers\Pages\TaskList;

use App\Http\Controllers\Controller;
use App\Models\ListTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class TaskListController extends Controller
{

    public function index()
    {
        $data = Task::latest()->paginate(8);
        return view('pages.task_list.index', compact('data'));
    }

    public function check_grade_link($task_id)
    {
        $check = ListTask::where(['user_id' => Auth::id(), 'task_id' => $task_id])->first();
        if (empty($check)) {
            return response()->json([
                'grade' => '-',
                'message' => 'Not Grading'
            ]);
        }
        return response()->json([
            'grade' => $check->grading,
            'message' => $check->notes_lecturer
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'submission' => 'required|mimes:pdf|max:2048',
        ], [
            'submission.required' => 'Kolom File Tugas harus diisi',
            'submission.mimes' => 'Format salah! Hanya PDF yang diizinkan.',
            'submission.max' => 'Ukuran file tidak boleh melebihi 2 MB.'
        ]);

        try {
            $task_id = Crypt::decrypt($request->input('task_id'));
            $user_id = Crypt::decrypt($request->input('user_id'));
            $submission = $request->file('submission');
            $folderPath = storage_path('app/public/tugas_mahasiswa/');
            $filename = uniqid() . '_' . $submission->getClientOriginalName();

            $check_deadline = Task::where('id', $task_id)->first();
            $now = time();
            $deadline = strtotime($check_deadline->deadline_tugas);
            $time_format = $deadline - $now;
            $status = 'review';
            if ($time_format < 0) {
                $status = 'late';
            }
            $data = ListTask::updateOrCreate([
                'user_id' => $user_id,
                'task_id' => $task_id
            ], [
                'status' => $status,
                'submission' => 'storage/tugas_mahasiswa/' . $filename,
                'description' => $request->description
            ]);

            if ($data) {
                $submission->move($folderPath, $filename);
                Alert::success('Success', 'Berhasil menambah Tugas!');
                return redirect()->back();
            } else {
                Alert::error('Failed', 'Gagal menambah Tugas!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            Alert::error('Failed', $th->getMessage());
            return redirect()->back();
        }
    }


    public function show($id)
    {
        $task = Task::findOrFail(Crypt::decrypt($id));
        $taskList = ListTask::where(['user_id' => Auth::id(), 'task_id' => Crypt::decrypt($id)])->first();
        return view('pages.task_list.show', compact('task', 'taskList'));
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
}
