@extends('layout.app')
@section('title', 'Pengumpulan Tugas ' . $task->judul)
@section('content')
    <h3 class="h4 mb-4">Pengumpulan Tugas</h3>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-book mr-1"></i> {{ $task->judul }} </h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="mb-2">{{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>

                </div>
            @endif
            @php
                if (isset($taskList) && isset($taskList->submission)) {
                    $submission = '<a target="_blank" class="btn btn-success" href="' . url('/') . '/' . $taskList->submission . '"><i class="fas fa-file-alt mr-1"> Lihat Submission</i></a>';
                } else {
                    $submission = '-';
                }
                
                if (isset($taskList) && isset($taskList->status)) {
                    switch ($taskList->status) {
                        case 'pass':
                            $status = '<span class="badge badge-success">Pass</span>';
                            break;
                        case 'review':
                            $status = '<span class="badge badge-secondary">Review</span>';
                            break;
                        case 'late':
                            $status = '<span class="badge badge-warning">Late</span>';
                            break;
                        case 'reject':
                            $status = '<span class="badge badge-danger">Reject</span>';
                            break;
                
                        default:
                            $status = '<span class="text-danger">Tidak ada <i class="fas fa-exclamation-triangle text-danger"></i></span>';
                            break;
                    }
                } else {
                    $status = '<span class="text-danger">Tidak ada <i class="fas fa-exclamation-triangle text-danger"></i></span>';
                }
            @endphp
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr style="width: 100%">
                        <td style="width: 25%"><b>Submission</b></td>
                        <td>{!! $submission !!}
                        </td>
                    </tr>
                    <tr style="width: 100%">
                        <td style="width: 25%"><b>Submission status</b></td>
                        <td>{!! $status !!}</td>
                    </tr>
                    <tr style="width: 100%">
                        <td style="width: 25%"><b>Grading</b></td>
                        <td>{{ $taskList->grading ?? '-' }}</td>
                    </tr>
                    <tr style="width: 100%">
                        <td style="width: 25%"><b>Due date</b></td>
                        <td>{{ $task->deadlineTugasFormat }}</td>
                    </tr>
                    <tr style="width: 100%">
                        <td style="width: 25%"><b>Time remaining</b></td>
                        <td>{{ $task->sisaWaktuTugas }}</td>
                    </tr>
                    <tr style="width: 100%">
                        <td style="width: 25%"><b>Notes Lecturer</b></td>
                        <td>{!! $taskList->notes_lecturer ?? '-' !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">

        <button class="btn btn-primary" data-toggle="modal" data-target="#assignment_modal">
            Input Assignment
        </button>
    </div>
    <div class="modal fade" id="assignment_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('task-list.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input class="d-none" type="text" name="user_id" value="{{ Crypt::encrypt(Auth::id()) }}">
                            <input class="d-none" type="text" name="task_id" value="{{ Crypt::encrypt($task->id) }}">
                            <div class="form-group">
                                <label for="submission">Masukan File Tugas</label>
                                <input type="file" class="form-control-file form-control" name="submission"
                                    id="submission" aria-describedby="fileHelpId" required>
                                <small id="fileHelpId" class="form-text text-danger">*Max 2MB</small>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
