<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Manifes Penumpang</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
            white-space: nowrap;
        }

        th {
            text-align: center;
            font-weight: bold;
            background-color: #d4ff00;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic;
        }

        .signature-container {
            margin-top: 40px;
            width: 100%;
        }

        .signature-table {
            width: 100%;
            border: none;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            border: none;
            padding: 0;
        }

        .signature-space {
            padding-top: 70px;
            border-top: 1px solid black;
            display: inline-block;
            width: 200px;
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-bottom: 20px;">
        <h1
            style="font-size: 1.5rem; font-weight: 800; margin: 0; padding-bottom: 4px; border-bottom: 2px solid black; display: inline-block;">
            MANIFES PENUMPANG
        </h1>
    </div>

    <div style="text-align: right; margin-bottom: 16px; font-size: 14px;">
        <strong>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</strong>
    </div>

    <div style="margin-bottom: 16px;">
        @if ($penumpangs->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Penumpang</th>
                        <th>Usia</th>
                        <th>JK</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Nopol</th>
                        <th>Jenis Kendaraan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penumpangs as $index => $penumpang)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $penumpang->nama_penumpang }}</td>
                            <td class="text-center">{{ $penumpang->usia }}</td>
                            <td class="text-center">{{ $penumpang->jenis_kelamin }}</td>
                            <td>{{ $penumpang->tujuan }}</td>
                            <td class="text-center">
                                {{ $penumpang->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                {{ $penumpang->tanggal->format('H:i') }}</td>
                            <td class="text-center">{{ $penumpang->nopol }}</td>
                            <td>{{ $penumpang->jenis_kendaraan }}</td>
                            <td class="text-center"
                                style="background-color: {{ $penumpang->status == 1 ? '#a7f3d0' : '#fca5a5' }};">
                                {{ $penumpang->status_label }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center italic" style="padding: 20px;">
                <em>Tidak ada data penumpang yang diterapkan.</em>
            </div>
        @endif
    </div>

    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td>
                    <h3 style="font-size: 1.1rem; font-weight: bold; margin-bottom: 100px;">Petugas</h3>
                    <div class="signature-space"></div>
                </td>
                <td>
                    <h3 style="font-size: 1.1rem; font-weight: bold; margin-bottom: 100px;">Kapten</h3>
                    <div class="signature-space"></div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
