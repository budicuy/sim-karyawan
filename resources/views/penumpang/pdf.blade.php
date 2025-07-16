<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Manifes Penumpang</title>
    {{-- Load Tailwind CSS from CDN for Spatie PDF --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Additional custom styles can go here if needed */
    </style>
</head>

<body class="font-sans">
    <div class="p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold inline-block pb-2 border-b-2 border-gray-800">
                MANIFES PENUMPANG
            </h1>
        </div>

        <div class="text-right mb-6 text-sm">
            <strong>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</strong>
        </div>

        <div class="mb-6">
            @if ($penumpangs->count() > 0)
                <table class="w-full border-collapse border border-gray-400">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2 border border-gray-400 text-center w-[5%]">No</th>
                            <th class="p-2 border border-gray-400 text-left">Nama Penumpang</th>
                            <th class="p-2 border border-gray-400 text-center">Usia</th>
                            <th class="p-2 border border-gray-400 text-center">JK</th>
                            <th class="p-2 border border-gray-400 text-left">Tujuan</th>
                            <th class="p-2 border border-gray-400 text-center">Tanggal</th>
                            <th class="p-2 border border-gray-400 text-center">Jam</th>
                            <th class="p-2 border border-gray-400 text-center">Nopol</th>
                            <th class="p-2 border border-gray-400 text-left">Jenis Kendaraan</th>
                            <th class="p-2 border border-gray-400 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penumpangs as $index => $penumpang)
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 border border-gray-400 text-center">{{ $index + 1 }}</td>
                                <td class="p-2 border border-gray-400">{{ $penumpang->nama_penumpang }}</td>
                                <td class="p-2 border border-gray-400 text-center">{{ $penumpang->usia }}</td>
                                <td class="p-2 border border-gray-400 text-center">{{ $penumpang->jenis_kelamin }}</td>
                                <td class="p-2 border border-gray-400">{{ $penumpang->tujuan }}</td>
                                <td class="p-2 border border-gray-400 text-center">
                                    {{ $penumpang->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="p-2 border border-gray-400 text-center">
                                    {{ $penumpang->tanggal->format('H:i') }}
                                </td>
                                <td class="p-2 border border-gray-400 text-center">{{ $penumpang->nopol }}</td>
                                <td class="p-2 border border-gray-400">{{ $penumpang->jenis_kendaraan }}</td>
                                <td
                                    class="p-2 border border-gray-400 text-center {{ $penumpang->status ? 'bg-green-100' : 'bg-red-100' }}">
                                    {{ $penumpang->status_label }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center italic p-6">
                    <em>Tidak ada data penumpang yang diterapkan.</em>
                </div>
            @endif
        </div>

        <div class="mt-16">
            <table class="w-full">
                <tr>
                    <td class="text-center w-1/2">
                        <h3 class="text-lg font-bold mb-16">Petugas</h3>
                        <div class="inline-block w-48 border-t border-gray-800"></div>
                    </td>
                    <td class="text-center w-1/2">
                        <h3 class="text-lg font-bold mb-16">Kapten</h3>
                        <div class="inline-block w-48 border-t border-gray-800"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
