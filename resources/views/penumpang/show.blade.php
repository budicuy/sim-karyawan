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
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <p class="text-gray-900">{{ $penumpang->user->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="text-gray-900">{{ $penumpang->user->email }}</p>
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
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Tiket</h3>

                        <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Tiket</label>
                                <p class="text-gray-900 font-mono">{{ $penumpang->nomor_tiket }}</p>
                            </div>

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

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Foto Tiket</h3>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if ($penumpang->url_image_tiket)
                                <img src="{{ asset('storage/' . $penumpang->url_image_tiket) }}"
                                    alt="Foto Tiket {{ $penumpang->nomor_tiket }}"
                                    class="w-full max-w-sm mx-auto rounded-lg shadow-md cursor-pointer"
                                    onclick="openImageModal(this.src)">
                                <p class="text-sm text-gray-600 text-center mt-2">Klik untuk memperbesar</p>
                            @else
                                <p class="text-gray-500 text-center">Tidak ada foto tiket</p>
                            @endif
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

        <!-- Modal untuk memperbesar gambar -->
        <div id="imageModal"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
            <div class="relative max-w-4xl max-h-full">
                <img id="modalImage" src="" alt="Foto Tiket" class="max-w-full max-h-full rounded-lg">
                <button onclick="closeImageModal()"
                    class="absolute top-2 right-2 bg-white text-black rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-200">
                    ×
                </button>
            </div>
        </div>

        <script>
            function openImageModal(src) {
                document.getElementById('modalImage').src = src;
                document.getElementById('imageModal').classList.remove('hidden');
            }

            function closeImageModal() {
                document.getElementById('imageModal').classList.add('hidden');
            }

            // Close modal when clicking outside the image
            document.getElementById('imageModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeImageModal();
                }
            });
        </script>
    </x-admin-layout>
</body>

</html>
