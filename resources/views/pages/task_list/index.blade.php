@extends('layout.app')
@section('title', 'Task and Exercise List')
@section('content')
    <h3 class="h4 mb-4">Pengumpulan Tugas</h3>
    @foreach ($data as $item)
        <div class="accordion" id="accordion_pengumpulan_tugas">
            <div class="card mb-4">
                <div class="card-header alert-danger" id="heading{{ $item->id }}">
                    <h3 class="mb-0 h3">
                        <button class="btn btn-block text-left text-dark" type="button" data-toggle="collapse"
                            data-target="#collapse{{ $item->id }}" aria-expanded="true"
                            aria-controls="collapse{{ $item->id }}">
                            <b>{{ $item->judul }}</b>
                        </button>
                    </h3>
                </div>
                <div id="collapse{{ $item->id }}" class="collapse show" aria-labelledby="heading{{ $item->id }}"
                    data-parent="#accordion_pengumpulan_tugas">
                    <div class="card-body">
                        <!-- Hover added -->
                        <div class="list-group">
                            @if ($item->tipe == 'link')
                                <a target="_blank" href="{{ $item->link }}" class="p-3 ml-1 text-dark"><i
                                        class="fas fa-question-circle text-secondary mr-3"></i>Quiz
                                    {{ $item->judul }}</a>
                                <!-- Button trigger modal -->
                                <a data-toggle="modal" href="#"
                                    data-target="#modalnilai{{ $item->id }}"class="p-3 ml-1 text-dark"
                                    onclick="checkValue({{ $item->id }})"><i
                                        class="fas fa-book text-secondary mr-3"></i>
                                    Lihat Nilai
                                </a>

                                <!-- Modal -->
                                <div class="modal fade" id="modalnilai{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="text-center" id="loading">
                                                    <img class="w-25" src="{{ asset('img/loading.gif') }}"
                                                        alt="loading">
                                                </div>
                                                <div class="container-fluid text-center" id="keterangan">
                                                    <p class="m-1">Grade</p>
                                                    <h3 id="grade_value"></h3>
                                                    <br>
                                                    <p class="m-1">Notes</p>
                                                    <p id="note_value"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a target="_blank" href="{{ url('/') . '/' . $item->file }}" class="p-3 ml-1 text-dark"><i
                                        class="fas fa-file-pdf text-danger mr-3"></i>
                                    Tugas
                                    {{ $item->judul }}</a>
                                <a href="{{ route('task-list.show', Crypt::encrypt($item->id)) }}"
                                    class="p-3 ml-1 text-dark"><i class="fas fa-file-alt text-primary mr-3"></i>Pengumpulan
                                    Tugas {{ $item->judul }}</a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
@section('js')
    <script>
        function checkValue(task_id) {
            $('#keterangan').hide();
            $('#loading').show();
            $.ajax({
                type: "GET",
                url: "{{ url('/task-list/check-grading') }}" + "/" + task_id,
                dataType: "JSON",
                success: function(response) {
                    $('#loading').hide();
                    $('#keterangan').show();
                    $('#grade_value').text(response.grade);
                    $('#note_value').html(response.message);
                }
            });
        }
    </script>
@endsection
