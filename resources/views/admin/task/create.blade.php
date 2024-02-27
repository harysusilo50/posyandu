@extends('layout.app')
@section('title', 'Input Tugas')
@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-book mr-1"></i> Create New Exercise</h6>
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
            <form method="POST" action="{{ route('task.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-12 col-lg-10">
                    <label for="judul" class="col-form-label" style="font-weight: 500">Judul Tugas</label>
                    <input id="judul" type="text" class="form-control" placeholder="Masukan judul tugas"
                        name="judul" required>
                </div>
                <div class="form-group d-lg-flex">
                    <div class="col-12 col-lg-4">
                        <label for="deadline_date" class="col-form-label" style="font-weight: 500">Tenggat Waktu
                            Tugas</label>
                        <input id="deadline_date" type="date" class="form-control" name="deadline_date" required>
                    </div>
                    <div class="col-12 col-lg-4">
                        <label for="deadline_time" class="col-form-label" style="font-weight: 500">Pukul</label>
                        <input id="deadline_time" type="time" class="form-control" name="deadline_time" required>
                    </div>
                </div>
                <div class="form-group col-12 col-lg-6" id="tipe">
                    <label for="" class="col-form-label" style="font-weight: 500">Tipe</label>
                    <div class="col-12 btn-group check_tipe" data-toggle="buttons">
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="tipe" id="tugas" autocomplete="off" value="tugas">
                            Tugas
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input type="radio" name="tipe" id="link" autocomplete="off" value="link">
                            Link
                        </label>
                    </div>
                </div>
                <div class="form-group col-12 col-lg-10" id="file_form">
                    <label for="file" class="col-form-label" style="font-weight: 500">Upload File (PDF)</label>
                    <input id="file" type="file" class="form-control" name="file">
                </div>

                <div class="form-group col-12 col-lg-10" id="link_form">
                    <label for="link" class="col-form-label" style="font-weight: 500">Link</label>
                    <input id="link" type="url" class="form-control" name="link">
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
        $(document).ready(function() {
            $('#file_form').hide();
            $('#link_form').hide();

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
        });
    </script>
@endsection
