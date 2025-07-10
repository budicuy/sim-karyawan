<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <x-admin-layout>
        <x-slot:title>Dashboard</x-slot:title>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Stats Card 1 -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total Karyawan</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Karyawan::count() }}</p>
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
                        <h3 class="text-gray-500 text-sm">Total User</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="bg-green-500 rounded-full h-12 w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Card 3 -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-yellow-500">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Admin</h3>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ \App\Models\User::where('role', 'admin')->count() }}
                        </p>
                    </div>
                    <div class="bg-yellow-500 rounded-full h-12 w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Card 4 -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-red-500">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Manager</h3>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ \App\Models\User::where('role', 'manager')->count() }}
                        </p>
                    </div>
                    <div class="bg-red-500 rounded-full h-12 w-12 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Data -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Data Karyawan Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Nama</th>
                            <th class="py-3 px-4 text-left">Tujuan</th>
                            <th class="py-3 px-4 text-left">Tanggal</th>
                            <th class="py-3 px-4 text-left">Nopol</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach (\App\Models\Karyawan::with('user')->latest()->take(5)->get() as $karyawan)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{ $karyawan->user->name }}</td>
                                <td class="py-3 px-4 border-b">{{ $karyawan->tujuan }}</td>
                                <td class="py-3 px-4 border-b">{{ $karyawan->tanggal }}</td>
                                <td class="py-3 px-4 border-b">{{ $karyawan->nopol }}</td>
                                <td class="py-3 px-4 border-b">
                                    <a href="{{ route('karyawan.edit', $karyawan) }}"
                                        class="text-blue-500 hover:underline mr-2">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    <a href="{{ route('karyawan.index') }}" class="text-blue-500 hover:underline flex items-center">
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

        <!-- System Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Statistics -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Statistik User</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Admin</span>
                        <span
                            class="text-blue-800 font-semibold">{{ \App\Models\User::where('role', 'admin')->count() }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-800 h-2.5 rounded-full"
                            style="width: {{ (\App\Models\User::where('role', 'admin')->count() / \App\Models\User::count()) * 100 }}%">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Manager</span>
                        <span
                            class="text-blue-800 font-semibold">{{ \App\Models\User::where('role', 'manager')->count() }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-800 h-2.5 rounded-full"
                            style="width: {{ (\App\Models\User::where('role', 'manager')->count() / \App\Models\User::count()) * 100 }}%">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">User</span>
                        <span
                            class="text-blue-800 font-semibold">{{ \App\Models\User::where('role', 'user')->count() }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-800 h-2.5 rounded-full"
                            style="width: {{ (\App\Models\User::where('role', 'user')->count() / \App\Models\User::count()) * 100 }}%">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Aksi Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('karyawan.create') }}"
                        class="block w-full bg-blue-800 text-white py-2 px-4 rounded hover:bg-blue-900 transition text-center">
                        Tambah Data Karyawan
                    </a>
                    @can('admin')
                        <a href="{{ route('users.create') }}"
                            class="block w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition text-center">
                            Tambah User Baru
                        </a>
                    @endcan
                    <a href="{{ route('karyawan.index') }}"
                        class="block w-full bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700 transition text-center">
                        Lihat Semua Data Karyawan
                    </a>
                </div>
            </div>
        </div>

    </x-admin-layout>
</body>

</html>
