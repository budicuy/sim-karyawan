<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Manifes Penumpang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12px;
            line-height: 1.5;
        }

        /* TailwindCSS will be used for styling the body content */
        /* Page-specific rules like size and margin remain here */
    </style>
</head>

<body class="font-serif text-xs">
    <div class="text-center mb-5">
        <h1 class="text-xl font-extrabold m-0 pb-1 border-b-2 border-black">MANIFES PENUMPANG</h1>
    </div>

    <div class="text-right mb-4 text-sm">
        <strong>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</strong>
    </div>

    <div class="mb-4">
        @if ($penumpangs->count() > 0)
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-400">
                        <th class="border border-black text-center font-bold w-[5%]">No</th>
                        <th class="border border-black text-center font-bold">Nama Penumpang</th>
                        <th class="border border-black text-center font-bold">Usia</th>
                        <th class="border border-black text-center font-bold">JK</th>
                        <th class="border border-black text-center font-bold">Tujuan</th>
                        <th class="border border-black text-center font-bold">Tanggal</th>
                        <th class="border border-black text-center font-bold">Jam</th>
                        <th class="border border-black text-center font-bold">Nopol</th>
                        <th class="border border-black text-center font-bold">Jenis Kendaraan</th>
                        <th class="border border-black text-center font-bold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penumpangs as $index => $penumpang)
                        <tr>
                            <td class="border border-black align-top text-center">{{ $index + 1 }}</td>
                            <td class="border border-black align-top">{{ $penumpang->nama_penumpang }}</td>
                            <td class="border border-black align-top text-center">{{ $penumpang->usia }}</td>
                            <td class="border border-black align-top text-center">{{ $penumpang->jenis_kelamin }}</td>
                            <td class="border border-black align-top">{{ $penumpang->tujuan }}</td>
                            <td class="border border-black align-top text-center">
                                {{ $penumpang->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="border border-black align-top text-center">
                                {{ $penumpang->tanggal->format('H:i') }}</td>
                            <td class="border border-black align-top text-center">{{ $penumpang->nopol }}</td>
                            <td class="border border-black align-top">{{ $penumpang->jenis_kendaraan }}</td>
                            <td class="border border-black align-top text-center">{{ $penumpang->status_label }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center p-5 italic">
                <em>Tidak ada data penumpang yang diterapkan.</em>
            </div>
        @endif
    </div>

    {{-- buatkan ttd untuk kapten dan petugas --}}
    <div class="mt-10 w-full">
        <div class="text-center w-[30%] inline-block mx-[2%] float-center">
            <h3 class="text-base font-bold mb-16">Petugas</h3>
            <div class="border-t border-black mt-1"></div>
        </div>
        <div class="text-center w-[30%] inline-block mx-[2%] float-right">
            <h3 class="text-base font-bold mb-16">Kapten</h3>
            <div class="border-t border-black mt-1 rounded-full"></div>
        </div>
    </div>
</body>

<script>
    // jika status penumpang adalah 1, maka tampilkan warna hijau, jika 0 maka tampilkan warna merah
    document.querySelectorAll('td').forEach(td => {
        if (td.textContent.trim() === 'Open') {
            td.classList.add('bg-green-300');
        } else if (td.textContent.trim() === 'Close') {
            td.classList.add('bg-red-500');
        }
    });
</script>

</html>
