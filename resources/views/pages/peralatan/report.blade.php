<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Peralatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Laporan Data Peralatan</h4>
        </h5>
    </center>

    <table class='table table-bordered' width="100%" style="table-layout:fixed;">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Nama Peralatan</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Status</th>
                <th class="text-center">Tgl Pembelian</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($peralatan as $item)
                <tr>
                    <td class="text-center" style="width:5%">{{ $i++ }}</td>
                    <td>
                        {{ $item->nama_peralatan }}
                    </td>
                    <td>{{ $item->jumlah . '/' . $item->satuan }}</td>
                    <td class="text-center" style="width: 10%">
                        @switch($item->status)
                            @case('bagus')
                                <span class="badge badge-pill badge-primary">Bagus</span>
                            @break

                            @case('rusak')
                                <span class="badge badge-pill badge-danger">Rusak</span>
                            @break

                            @case('rusak_sebagian')
                                <span class="badge badge-pill badge-warning">Rusak Sebagian</span>
                            @break

                            @case('hilang')
                                <span class="badge badge-pill badge-dark">Hilang</span>
                            @break

                            @case('hilang_sebagian')
                                <span class="badge badge-pill badge-secondary">Hilang Sebagian</span>
                            @break

                            @default
                                <span class="badge rounded-pill text-bg-danger">{{ $item->status }}</span>
                            @break
                        @endswitch
                    </td>
                    <td class="text-center">
                        {{ $item->format_tgl_pembelian }}
                    </td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
