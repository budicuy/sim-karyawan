<!DOCTYPE html>
<html>

<head>
    <title>Detail Penumpang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <x-admin-layout>
        <x-slot:title>Detail Penumpang</x-slot:title>

        <div class="bg-white rounded-lg shadow p-6 max-w-3xl mx-auto mt-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Detail Data Penumpang</h2>
                <div class="flex space-x-2">
                    @can('update', $penumpang)
                        <a href="{{ route('penumpang.edit', $penumpang) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition">
                            Edit
                        </a>
                    @endcan
                    <a href="{{ route('penumpang.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Penumpang</h3>

                        <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Penumpang</label>
                                <p class="text-gray-900">{{ $penumpang->nama_penumpang }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Usia</label>
                                <p class="text-gray-900">{{ $penumpang->usia }} tahun</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <p class="text-gray-900">{{ $penumpang->jenis_kelamin_label }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Perjalanan</h3>

                        <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tujuan</label>
                                <p class="text-gray-900">{{ $penumpang->tujuan }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <p class="text-gray-900">{{ $penumpang->tanggal->format('d F Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Polisi</label>
                                <p class="text-gray-900">{{ $penumpang->nopol }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
                                <p class="text-gray-900">{{ $penumpang->jenis_kendaraan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Status</h3>

                        <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span
                                    class="px-3 py-1 text-sm rounded-full {{ $penumpang->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $penumpang->status_label }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                                <p class="text-gray-900">{{ $penumpang->created_at->format('d F Y H:i') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Diupdate</label>
                                <p class="text-gray-900">{{ $penumpang->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @can('delete', $penumpang)
                <div class="mt-6 pt-6 border-t">
                    <form method="POST" action="{{ route('penumpang.destroy', $penumpang) }}" class="inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penumpang ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                            Hapus Data
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </x-admin-layout>
</body>

</html>
