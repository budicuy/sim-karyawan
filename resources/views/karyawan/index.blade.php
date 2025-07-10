<!DOCTYPE html>
<html>

<head>
    <title>Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <x-admin-layout>
        <x-slot:title>Data Karyawan</x-slot:title>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Data Karyawan</h2>
                <a href="{{ route('karyawan.create') }}"
                    class="bg-blue-800 text-white px-4 py-2 rounded-md hover:bg-blue-900 transition">
                    Tambah Karyawan
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Nama</th>
                            <th class="py-3 px-4 text-left">Tujuan</th>
                            <th class="py-3 px-4 text-left">Tanggal</th>
                            <th class="py-3 px-4 text-left">Nopol</th>
                            <th class="py-3 px-4 text-left">Foto Tiket</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($karyawans as $karyawan)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{ $karyawan->user->name }}</td>
                                <td class="py-3 px-4 border-b">{{ $karyawan->tujuan }}</td>
                                <td class="py-3 px-4 border-b">{{ $karyawan->tanggal }}</td>
                                <td class="py-3 px-4 border-b">{{ $karyawan->nopol }}</td>
                                <td class="py-3 px-4 border-b">
                                    <img src="{{ asset('storage/' . $karyawan->foto_tiket) }}" class="h-10 w-auto">
                                </td>
                                <td class="py-3 px-4 border-b flex space-x-2">
                                    <a href="{{ route('karyawan.edit', $karyawan) }}"
                                        class="text-blue-500 hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('karyawan.destroy', $karyawan) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $karyawans->links() }}
            </div>
        </div>
    </x-admin-layout>
</body>

</html>
