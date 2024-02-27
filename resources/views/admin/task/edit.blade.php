@extends('layout.app')
@section('title', 'Edit Tugas' . $data->judul)
@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-book mr-1"></i> Edit {{ $data->judul }}</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>

                </div>
            @endif
            <form method="POST" action="{{ route('task.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group col-12 col-lg-10">
                    <label for="judul" class="col-form-label" style="font-weight: 500">Judul Tugas</label>
                    <input id="judul" type="text" class="form-control" placeholder="Masukan judul tugas"
                        name="judul" required value="{{ $data->judul }}">
                </div>
                <div class="form-group d-lg-flex">
                    @php
                        $dateTime = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->deadline_tugas);
                        $dateOnly = $dateTime->format('Y-m-d');
                        $timeOnly = $dateTime->format('H:i:s');
                    @endphp
                    <div class="col-12 col-lg-4">
                        <label for="deadline_date" class="col-form-label" style="font-weight: 500">Tenggat Waktu
                            Tugas</label>
                        <input id="deadline_date" type="date" class="form-control" name="deadline_date" required
                            value="{{ date('Y-m-d', strtotime($data->deadline_tugas)) }}">
                    </div>
                    <div class="col-12 col-lg-4">
                        <label for="deadline_time" class="col-form-label" style="font-weight: 500">Pukul</label>
                        <input id="deadline_time" type="time" class="form-control" name="deadline_time" required
                            value="{{ date('H:i', strtotime($data->deadline_tugas)) }}">
                    </div>
                </div>
                <div class="form-group col-12 col-lg-6" id="tipe">
                    <label for="" class="col-form-label" style="font-weight: 500">Tipe</label>
                    <div class="col-12 btn-group check_tipe" data-toggle="buttons">
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="tipe" id="tugas" autocomplete="off" value="tugas"
                                {{ $data->tipe == 'tugas' ? 'checked' : '' }}>
                            Tugas
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="tipe" id="link" autocomplete="off" value="link"
                                {{ $data->tipe == 'link' ? 'checked' : '' }}>
                            Link
                        </label>
                    </div>
                </div>
                <div class="form-group col-12 col-lg-10" style="{{ $data->tipe == 'tugas' ? '' : 'display:none' }}"
                    id="file_form">
                    <div class="row justify-content-center mb-3 {{ $data->tipe == 'tugas' ? '' : 'd-none' }}">
                        <iframe src="{{ asset('/' . $data->file) }}" width="50%" height="600">
                            This browser does not support PDFs. Please download the PDF to view it: <a
                                href="{{ asset('/' . $data->file) }}">Download PDF</a>
                        </iframe>
                    </div>

                    <label for="file" class="col-form-label" style="font-weight: 500">Upload File (PDF)</label>
                    <input id="file" type="file" class="form-control" name="file">

                </div>

                <div class="form-group col-12 col-lg-10" style="{{ $data->tipe == 'link' ? '' : 'display:none' }}"
                    id="link_form">
                    <label for="link" class="col-form-label" style="font-weight: 500">Link</label>
                    <input id="link" type="url" class="form-control" name="link" value="{{ $data->link }}">


                </div>

                <div class="form-group col-12 text-center">
                    <a href="{{ route('task.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $('.check_tipe').change(function(e) {
            e.preventDefault();
            if ($('#tugas').is(':checked')) {
                $('#file_form').show();
                $('#link_form').hide();
            } else {
                $('#file_form').hide();
                $('#link_form').show();
            }
        });
    </script>
@endsection
