@extends('layout.app')
@section('title', 'Task & Exercise')
@section('content')
    <div class="container mb-3">
        <a href="{{ route('task.index') }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
            Back </a>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-book mr-1"></i> Tugas {{ $task->judul }} </h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="mb-2">
                <a class="btn btn-success btn-sm" href="{{ route('export.excel', $task->id) }}" role="button">Excel
                    <i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
            <div class="table-responsive">
                <!--Table-->
                <table class="table table-striped" cellspacing="0">

                    <!--Table head-->
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th class="text-center">Nilai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">{{ $item->grading ?? '-' }}</td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#modal_execute{{ $item->id }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <!-- Modal Deskripsi -->
                            <div class="modal fade" id="modal_execute{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modelTitle{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-header text-white bg-success">
                                            <h5 class="modal-title">{{ $task->judul }} - {{ $item->name }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('task.add_grading_link') }}" method="POST">
                                            @csrf
                                            <input type="number" class="d-none" name="user_id"
                                                value="{{ $item->id }}">
                                            <input type="number" class="d-none" name="task_id"
                                                value="{{ $task->id }}">
                                            <div class="modal-body">
                                                <div class="form-group" id="input_nilai">
                                                    <label class="font-weight-bold" for="grading">Nilai</label>
                                                    <input type="number" class="form-control col-8" name="grading"
                                                        id="grading" placeholder="Masukan Nilai">
                                                </div>
                                                <div class="form-group" id="input_catatan">
                                                    <label class="font-weight-bold" for="notes_lecturer">Catatan</label>
                                                    <textarea class="ckeditor" name="notes_lecturer" id="notes_lecturer" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
                <!--Table-->
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
@endsection
