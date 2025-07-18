<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body class="bg-gray-100">
    <x-admin-layout>
        <x-slot:title>Dashboard</x-slot:title>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
            <!-- Stats Card 1 -->
            <div class="bg-white rounded-lg shadow p-4 md:p-5 border-l-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total Penumpang</h3>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_penumpang'] }}</p>
                    </div>
                    <div
                        class="bg-blue-500 rounded-full h-10 w-10 md:h-12 md:w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Card 2 -->
            <div class="bg-white rounded-lg shadow p-4 md:p-5 border-l-4 border-green-500">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm">Status Open</h3>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['open_status'] }}</p>
                    </div>
                    <div
                        class="bg-green-500 rounded-full h-10 w-10 md:h-12 md:w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Card 3 -->
            <div class="bg-white rounded-lg shadow p-4 md:p-5 border-l-4 border-red-500">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm">Status Close</h3>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['close_status'] }}</p>
                    </div>
                    <div
                        class="bg-red-500 rounded-full h-10 w-10 md:h-12 md:w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Card 4 -->
            <div class="bg-white rounded-lg shadow p-4 md:p-5 border-l-4 border-purple-500">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total User</h3>
                        <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                    </div>
                    <div
                        class="bg-purple-500 rounded-full h-10 w-10 md:h-12 md:w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
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

                <!-- Desktop View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">Nama</th>
                                <th class="py-3 px-4 text-left">Tujuan</th>
                                <th class="py-3 px-4 text-left">Tanggal</th>
                                <th class="py-3 px-4 text-left">Jam</th>
                                <th class="py-3 px-4 text-left">Nopol</th>
                                <th class="py-3 px-4 text-left">Jenis Kendaraan</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($recentPenumpang as $penumpang)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ $penumpang->nama_penumpang }}</td>
                                    <td class="py-3 px-4 border-b">{{ $penumpang->tujuan }}</td>
                                    <td class="py-3 px-4 border-b">{{ $penumpang->tanggal->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 border-b">{{ $penumpang->tanggal->format('H:i') }}</td>
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
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        Tidak ada data penumpang terbaru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View -->
                <div class="md:hidden space-y-4">
                    @forelse ($recentPenumpang as $penumpang)
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-800">{{ $penumpang->nama_penumpang }}</h3>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $penumpang->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $penumpang->status_label }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-3">
                                <div>
                                    <span class="font-medium">Tujuan:</span>
                                    <span class="text-gray-800">{{ $penumpang->tujuan }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Tanggal:</span>
                                    <span class="text-gray-800">{{ $penumpang->tanggal->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Jam:</span>
                                    <span class="text-gray-800">{{ $penumpang->tanggal->format('H:i') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Nopol:</span>
                                    <span class="text-gray-800">{{ $penumpang->nopol }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Kendaraan:</span>
                                    <span class="text-gray-800">{{ $penumpang->jenis_kendaraan }}</span>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <a href="{{ route('penumpang.edit', $penumpang) }}"
                                    class="text-blue-500 hover:underline text-sm">Edit</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            Tidak ada data penumpang terbaru.
                        </div>
                    @endforelse
                </div>
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
        @endcanany

        <!-- System Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- User Statistics -->
            <div class="bg-white rounded-lg shadow p-4 md:p-6">
                <h2 class="text-lg md:text-xl font-bold mb-4 text-gray-800">Statistik User</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm md:text-base text-gray-600">Admin</span>
                        <span class="text-blue-800 font-semibold">{{ $stats['admin_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-blue-800 h-2.5 rounded-full" style="width: {{ $percentages['admin'] }}%">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm md:text-base text-gray-600">Manager</span>
                        <span class="text-green-600 font-semibold">{{ $stats['manager_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentages['manager'] }}%">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm md:text-base text-gray-600">User</span>
                        <span class="text-yellow-500 font-semibold">{{ $stats['user_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-yellow-500 h-2.5 rounded-full" style="width: {{ $percentages['user'] }}%">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4 md:p-6">
                <h2 class="text-lg md:text-xl font-bold mb-4 text-gray-800">Informasi Sistem</h2>
                <div class="text-center text-gray-500 mt-10">
                    <p>Versi Aplikasi: 1.0.0</p>
                    <p>Lingkungan: {{ app()->environment() }}</p>
                    <p>Status Cache: <span class="text-green-500 font-semibold">Aktif</span></p>
                </div>
            </div>
        </div>

    </x-admin-layout>
</body>

</html>
