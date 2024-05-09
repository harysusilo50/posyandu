<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Laporan Keuangan</title>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>

</head>

<body>
    <center><h3 class="text-center mb-4 fw-bold " style="font-weight: 700">Laporan Keuangan</h3></center>

    <table class='table' width="100%" style="table-layout:fixed;">
        <tr class="m-0">
            <td width="15%" style="border: 0">
                <p class="m-0 fw-bold">Pemasukan</p>
            </td>
            <td style="border: 0">
                <p class="m-0">: Rp{{ number_format($total_masuk, 0, ',', '.') }}</p>
            </td>
        </tr>
        <tr class="m-0">
            <td width="15%" style="border: 0">
                <p class="m-0 fw-bold">Pengeluaran</p>
            </td>
            <td style="border: 0">
                <p class="m-0 ">: Rp{{ number_format($total_keluar, 0, ',', '.') }}</p>
            </td>
        </tr>
        <tr class="m-0">
            <td width="15%" style="border: 0">
                <p class="m-0 fw-bold">Total Kas</p>
            </td>
            <td style="border: 0">
                <p class="m-0 ">: Rp{{ number_format($total_keseluruhan, 0, ',', '.') }}</p>
            </td>
        </tr>
    </table>
    <p class=" mb-2 fw-bold ">Detail Transaksi: </p>
    <table class='table table-bordered border-black' width="100%" style="table-layout:fixed;">
        <thead style="background-color: #ebb5b5">
            <tr class="text-center">
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keuangan as $item)
                <tr style="  {{ $item->type != 'in' ? '' : 'background-color:#dc35468f;' }}">
                    <td class="text-center" style="width:5%">
                        {{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ $item->format_tanggal }}
                    </td>
                    <td class="text-center">
                        @if ($item->type != 'keluar')
                            MASUK
                        @else
                            KELUAR
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $item->jenis }}
                    </td>
                    <td class="{{ $item->type != 'keluar' ? 'text-start' : 'text-end' }} px-1">
                        Rp {{ $item->format_nominal }}
                    </td>
                    <td class="px-1" style="width:45%">
                        {{ $item->keterangan }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
