<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body class="bg-gray-100">
    <x-admin-layout>
        <x-slot:title>Dashboard</x-slot:title>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Stats Card 1 -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total Penumpang</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_penumpang'] }}</p>
                    </div>
                    <div class="bg-blue-500 rounded-full h-12 w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Card 2 -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Status Open</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['open_status'] }}</p>
                    </div>
                    <div class="bg-green-500 rounded-full h-12 w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Card 3 -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-red-500">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Status Close</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['close_status'] }}</p>
                    </div>
                    <div class="bg-red-500 rounded-full h-12 w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Card 4 -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-purple-500">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total User</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="bg-purple-500 rounded-full h-12 w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>


        <!-- Recent Data hanya admin dam manager -->
        @canany('admin', 'manager')
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Data Penumpang Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">Nama</th>
                                <th class="py-3 px-4 text-left">Tujuan</th>
                                <th class="py-3 px-4 text-left">Tanggal</th>
                                <th class="py-3 px-4 text-left">Nopol</th>
                                <th class="py-3 px-4 text-left">Jenis Kendaraan</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($recentPenumpang as $penumpang)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ $penumpang->user->name }}</td>
                                    <td class="py-3 px-4 border-b">{{ $penumpang->tujuan }}</td>
                                    <td class="py-3 px-4 border-b">{{ $penumpang->tanggal->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 border-b">{{ $penumpang->nopol }}</td>
                                    <td class="py-3 px-4 border-b">{{ $penumpang->jenis_kendaraan }}</td>
                                    <td class="py-3 px-4 border-b">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $penumpang->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $penumpang->status_label }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border-b">
                                        <a href="{{ route('penumpang.edit', $penumpang) }}"
                                            class="text-blue-500 hover:underline mr-2">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <a href="{{ route('penumpang.index') }}" class="text-blue-500 hover:underline flex items-center">
                            Lihat Semua
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endcanany

        <!-- System Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Statistics -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Statistik User</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Admin</span>
                        <span class="text-blue-800 font-semibold">{{ $stats['admin_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-800 h-2.5 rounded-full" style="width: {{ $percentages['admin'] }}%"></div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Manager</span>
                        <span class="text-blue-800 font-semibold">{{ $stats['manager_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-800 h-2.5 rounded-full" style="width: {{ $percentages['manager'] }}%">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">User</span>
                        <span class="text-blue-800 font-semibold">{{ $stats['user_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-800 h-2.5 rounded-full" style="width: {{ $percentages['user'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Aksi Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('penumpang.create') }}"
                        class="block w-full bg-blue-800 text-white py-2 px-4 rounded hover:bg-blue-900 transition text-center">
                        Tambah Data Penumpang
                    </a>
                    @can('admin')
                        <a href="{{ route('users.create') }}"
                            class="block w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition text-center">
                            Tambah User Baru
                        </a>
                    @endcan
                    <a href="{{ route('penumpang.index') }}"
                        class="block w-full bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700 transition text-center">
                        Lihat Semua Data Penumpang
                    </a>
                </div>
            </div>
        </div>

    </x-admin-layout>
</body>

</html>
