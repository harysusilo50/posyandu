@extends('layout.app')
@section('title', 'Settings Manual Pot Sink')
@section('content')
    <div class="container mb-3">
        <a href="{{ route('admin.machine.settings') }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"
                aria-hidden="true"></i> Back </a>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-cogs mr-1"></i> Settings Machine Manual Pot Sink</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <textarea id="image-dropify-send" class="d-none" name="image" required></textarea>
            <!-- Button trigger modal -->
            <div class="form-group col-12 mb-5">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelId">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Image
                </button>
            </div>
            <div class="mb-3">
                <section class="splide mb-3 bg-light m-md-5 rounded" aria-label="Basic Structure Example">
                    <div class="splide__track">
                        <ul class="splide__list text-center">
                            @foreach ($data['image'] as $item)
                                <li class="splide__slide position-relative">
                                    <button onclick="hapus_gambar({{ $item->id }})"
                                        class="btn btn-lg btn-danger shadow-lg position-absolute">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                    <img src="{{ asset('/' . $item->value) }}" class="img-fluid w-50 ">

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            </div>
            <div class="form-group col-12">
                <label for="desc" class="col-form-label" style="font-weight: 500">Deskripsi</label>
                <textarea id="desc" class="form-control" name="desc" rows="5" required></textarea>
            </div>
            <div class="form-group col-12 mb-5">
                <button type="button" class="btn btn-primary" id="kirimDeskripsi">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Simpan Deskripsi
                </button>
            </div>
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Gambar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('components.upload_image.html')
                            <textarea id="image-dropify-send" class="d-none" name="image" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="kirimGambar" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <textarea class="d-none" id="output">{!! $data['description'] !!}</textarea>
@endsection
@section('js')
    <script>
        CKEDITOR.replace('desc');
        var test = $('textarea#output').val();
        $(document).ready(function() {
            CKEDITOR.instances['desc'].setData(test)
        });
    </script>
    @include('components.upload_image.js')
    <script>
        var splide = new Splide('.splide', {
            type: 'loop',
            focus: 'center',
            perMove: 1,
        });

        splide.mount();
    </script>

    <script>
        $('#kirimGambar').click(function(e) {
            e.preventDefault();
            Swal.showLoading()
            var croppedImage = $('#image-dropify-send').val();
            var _token = "{{ csrf_token() }}";
            var url = "{{ route('admin.machine.upload_image') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: _token,
                    image: croppedImage,
                    machine: "manual_pot_sink"
                },
                dataType: 'JSON',
                success: function(data) {
                    Swal.hideLoading()
                    if (data.status == 'success') {
                        Swal.fire(
                            'Done!',
                            data.message,
                            'success'
                        )
                        location.reload();
                    } else {
                        Swal.fire(
                            'Failed!',
                            data.message,
                            'error'
                        )
                    }
                    console.log(data)
                },
                error: function(ajaxContext) {
                    Swal.hideLoading()
                    Swal.fire(
                        'Oops...',
                        'Terjadi kesalahan',
                        'error',
                    )
                }
            });
        });
        $('#kirimDeskripsi').click(function(e) {
            e.preventDefault();
            Swal.showLoading()
            var desc = CKEDITOR.instances['desc'].getData();;
            var _token = "{{ csrf_token() }}";
            var url = "{{ route('admin.machine.upload_description') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: _token,
                    value: desc,
                    machine: "manual_pot_sink"
                },
                dataType: 'JSON',
                success: function(data) {
                    Swal.hideLoading()
                    if (data.status == 'success') {
                        Swal.fire(
                            'Done!',
                            data.message,
                            'success'
                        )
                        location.reload();
                    } else {
                        Swal.fire(
                            'Failed!',
                            data.message,
                            'error'
                        )
                    }
                    console.log(data)
                },
                error: function(ajaxContext) {
                    Swal.hideLoading()
                    Swal.fire(
                        'Oops...',
                        'Terjadi kesalahan',
                        'error',
                    )
                }
            });
        });

        function hapus_gambar(id) {
            var text = "Gambar akan dihapus dan tidak bisa dikembalikan"
            var url = "{{ route('admin.machine.delete_image') }}";
            var _token = "{{ csrf_token() }}";
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading()
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: _token,
                            id: id
                        },
                        dataType: 'JSON',
                        success: function(data) {
                            Swal.hideLoading()
                            if (data.status == 'success') {
                                Swal.hideLoading()
                                Swal.fire(
                                    'Terhapus!',
                                    data.message,
                                    'success'
                                )
                                location.reload();
                            } else {
                                Swal.hideLoading()
                                Swal.fire(
                                    'Gagal!',
                                    data.message,
                                    'error'
                                )
                            }
                            console.log(data)
                        },
                        error: function(ajaxContext) {
                            Swal.hideLoading()
                            Swal.fire(
                                'Oops...',
                                'Terjadi kesalahan',
                                'error',
                            )
                        }
                    });
                }
            })
        };
    </script>
@endsection
