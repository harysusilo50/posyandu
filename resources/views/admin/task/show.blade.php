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
            <div class="table-responsive">
                <!--Table-->
                <table class="table table-striped" cellspacing="0">
                    <div class="mb-2">
                        <a class="btn btn-success btn-sm" href="{{ route('export.excel', $task->id) }}" role="button">Excel
                            <i class="fa fa-download" aria-hidden="true"></i></a>
                    </div>
                    <!--Table head-->
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Tanggal Pengumpulan</th>
                            <th>Status</th>
                            <th class="text-center">Nilai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            @php
                                switch ($item->status) {
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
                            @endphp
                            <tr>
                                <td class="text-center">{{ $data->firstItem() + $loop->index }}</td>
                                <td>{{ $item->user->nim }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->format_updated_at }}</td>
                                <td>{!! $status !!}</td>
                                <td class="text-center">{{ $item->grading ?? '-' }}</td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#modal_execute{{ $item->id }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#modal_detail{{ $item->id }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <!-- Modal Deskripsi -->
                            <div class="modal fade" id="modal_detail{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modelTitle{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $item->task->judul }} - {{ $item->user->name }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <p class="font-weight-bold mb-1">Tugas : </p>
                                                <p class="mb-2">{{ $item->task->judul }}</p>
                                                <p class="font-weight-bold mb-1">Deadline Tugas : </p>
                                                <p class="mb-2">{{ $item->task->DeadlineTugasFormat }}</p>
                                                <p class="font-weight-bold mb-1">File Tugas : </p>
                                                <a target="_blank" class="btn btn-success mb-2"
                                                    href="{{ url('/') . '/' . $item->submission }}">
                                                    <i class="fas fa-file-alt mr-1"> Lihat Submission</i></a>
                                            </div>
                                            <div class="container">
                                                <p class="mb-1 font-weight-bold"> Detail Mahasiswa : </p>
                                                <div class="row">
                                                    <div class="col-4 border">
                                                        Nilai
                                                    </div>
                                                    <div class="col-8 border">
                                                        {{ $item->grading ?? '-' }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 border">
                                                        Nama
                                                    </div>
                                                    <div class="col-8 border">
                                                        {{ $item->user->name }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 border">
                                                        NIM
                                                    </div>
                                                    <div class="col-8 border">
                                                        {{ $item->user->nim }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 border">
                                                        Tanggal Pengumpulan
                                                    </div>
                                                    <div class="col-8 border">
                                                        {{ $item->format_updated_at }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 border">
                                                        Status Pengumpulan
                                                    </div>
                                                    <div class="col-8 border">
                                                        {!! $status !!}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 border">
                                                        Deskripsi
                                                    </div>
                                                    <div class="col-8 border">
                                                        {!! $item->description !!}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="modal-footer d-flex justify-content-center">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Deskripsi -->
                            <div class="modal fade" id="modal_execute{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modelTitle{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-header text-white bg-success">
                                            <h5 class="modal-title">{{ $item->task->judul }} - {{ $item->user->name }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('task.correction') }}" method="POST">
                                            @csrf
                                            <input type="number" class="d-none" name="user_id"
                                                value="{{ $item->user->id }}">
                                            <input type="number" class="d-none" name="task_id"
                                                value="{{ $item->task->id }}">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <p class="font-weight-bold mb-1">Status :</p>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="status"
                                                                id="pass" value="pass"
                                                                {{ $item->status == 'pass' ? 'checked' : '' }}>
                                                            Beri Nilai
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="status"
                                                                id="reject" value="reject"
                                                                {{ $item->status == 'reject' ? 'checked' : '' }}>
                                                            Tolak
                                                        </label>
                                                    </div>
                                                </div>
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
                    {{ $data->links() }}
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
    <script>
        $(document).ready(function() {
            $('#input_nilai').hide();
            $('#input_catatan').hide();
            $('input[type="radio"]').change(function() {
                var selected = $(this).val();
                switch (selected) {
                    case "pass":
                        $('#input_nilai').show();
                        $('#input_catatan').show();
                        $('#grading').val('');
                        $('#notes_lecturer').val('');
                        break;
                    case "reject":
                        $('#input_nilai').hide();
                        $('#input_catatan').show();
                        $('#grading').val('');
                        $('#notes_lecturer').val('');
                        break;

                    default:
                        $('#grading').val('');
                        $('#notes_lecturer').val('');
                        $('#input_nilai').hide();
                        $('#input_catatan').hide();
                        break;
                }

            });
        });
    </script>
@endsection
