@extends('layout.app')
@section('title', 'List Verification User')
@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-muted"><i class="fas fa-user mr-1"></i> List User Verification</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive">
                <!--Table-->
                <table class="table table-striped" id="dataTable" cellspacing="0">

                    <!--Table head-->
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanda Pengenal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->user->nim }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->user->email }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'pending')
                                        <span class="badge badge-pill badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">Reject</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                        data-target="#tanda_pengenal{{ $item->id }}">
                                        Lihat
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="tanda_pengenal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tanda Pengenal {{ $item->user->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center text-center mx-auto">
                                                        <img src="{{ asset($item->tanda_pengenal) }}"
                                                            class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <!-- Button Terima Verifikasi -->
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#modal_accept_{{ $item->id }}">
                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    </button>

                                    <!-- Button Tolak Verifikasi -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#modal_reject_{{ $item->id }}">
                                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal Terima Verifikasi-->
                            <div class="modal fade" id="modal_accept_{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Verifikasi User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('user.verify_user') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="container-fluid">
                                                    Verifikasi {{ $item->user->name }} {{ $item->user->nim }}
                                                    <br>Apakah anda yakin?
                                                </div>
                                            </div>
                                            <input type="text" class="d-none" name="user_id"
                                                value="{{ $item->user->id }}">
                                            <input type="text" class="d-none" name="id"
                                                value="{{ $item->id }}">
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Verifikasi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Tolak Verifikasi-->
                            <div class="modal fade" id="modal_reject_{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Tolak Verifikasi User</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('user.reject_user') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="container-fluid">
                                                    Tolak Verifikasi {{ $item->user->name }} {{ $item->user->nim }}
                                                    <br>
                                                    <br>
                                                    <p><b>Alasan Penolakan : </b></p>

                                                    <div class="form-group" id="description">
                                                        <textarea class="ckeditor" name="description" id="description" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="text" class="d-none" name="user_id"
                                                value="{{ $item->user->id }}">
                                            <input type="text" class="d-none" name="id"
                                                value="{{ $item->id }}">
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <!--Table-->
                <div class="d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
@endsection
