<!DOCTYPE html>
<html>

<head>
    <title>Edit Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <x-admin-layout>
        <x-slot:title>Edit Karyawan</x-slot:title>

        <div class="bg-white rounded-lg shadow p-6 max-w-3xl mx-auto mt-10">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Edit Data Karyawan</h2>

            <form action="{{ route('karyawan.update', $karyawan) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-1">Tujuan</label>
                    <input type="text" name="tujuan" id="tujuan" value="{{ $karyawan->tujuan }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    @error('tujuan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $karyawan->tanggal }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    @error('tanggal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nopol" class="block text-sm font-medium text-gray-700 mb-1">Nomor Polisi</label>
                    <input type="text" name="nopol" id="nopol" value="{{ $karyawan->nopol }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    @error('nopol')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="foto_tiket" class="block text-sm font-medium text-gray-700 mb-1">Foto Tiket</label>
                    <div class="flex items-start space-x-4">
                        <input type="file" name="foto_tiket" id="foto_tiket"
                            class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100">
                        @if ($karyawan->foto_tiket)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                                <img src="{{ asset('storage/' . $karyawan->foto_tiket) }}" class="h-20 w-auto border">
                            </div>
                        @endif
                    </div>
                    @error('foto_tiket')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-3 pt-3">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-800 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update
                    </button>
                    <a href="{{ route('karyawan.index') }}"
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </x-admin-layout>
</body>

</html>
