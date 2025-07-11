<!DOCTYPE html>
<html>

<head>
    <title>Tambah Penumpang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <x-admin-layout>
        <x-slot:title>Tambah Penumpang</x-slot:title>

        <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto mt-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Tambah Data Penumpang</h2>
                <a href="{{ route('penumpang.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penumpang.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="usia" class="block text-sm font-medium text-gray-700 mb-1">Usia</label>
                        <input type="number" name="usia" id="usia" value="{{ old('usia') }}" min="1"
                            max="120"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('usia') border-red-500 @enderror"
                            required>
                        @error('usia')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                            Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-1">Tujuan</label>
                    <input type="text" name="tujuan" id="tujuan" value="{{ old('tujuan') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tujuan') border-red-500 @enderror"
                        required>
                    @error('tujuan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal') border-red-500 @enderror"
                            required>
                        @error('tanggal')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nopol" class="block text-sm font-medium text-gray-700 mb-1">Nomor Polisi</label>
                        <input type="text" name="nopol" id="nopol" value="{{ old('nopol') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nopol') border-red-500 @enderror"
                            required>
                        @error('nopol')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_kendaraan" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                            Kendaraan</label>
                        <input type="text" name="jenis_kendaraan" id="jenis_kendaraan"
                            value="{{ old('jenis_kendaraan') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_kendaraan') border-red-500 @enderror"
                            required>
                        @error('jenis_kendaraan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_tiket" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                            Tiket</label>
                        <input type="text" name="nomor_tiket" id="nomor_tiket" value="{{ old('nomor_tiket') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nomor_tiket') border-red-500 @enderror"
                            required>
                        @error('nomor_tiket')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="url_image_tiket" class="block text-sm font-medium text-gray-700 mb-1">Foto Tiket</label>
                    <input type="file" name="url_image_tiket" id="url_image_tiket" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('url_image_tiket') border-red-500 @enderror"
                        required>
                    @error('url_image_tiket')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Format: JPEG, PNG, JPG. Maksimal 2MB</p>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Close</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-3 pt-3">
                    <button type="submit"
                        class="bg-blue-800 text-white px-6 py-2 rounded-md hover:bg-blue-900 transition">
                        Simpan
                    </button>
                    <a href="{{ route('penumpang.index') }}"
                        class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </x-admin-layout>
</body>

</html>
