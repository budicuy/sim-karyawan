<!DOCTYPE html>
<html>

<head>
    <title>Data Penumpang</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100">
    <x-admin-layout>
        <x-slot:title>Data Manifes Penumpang</x-slot:title>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-4 md:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800">Data Manifes Penumpang</h2>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                    <a href="{{ route('penumpang.export', array_merge(request()->query(), ['format' => 'csv'])) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-center text-sm">
                        Export CSV
                    </a>
                    <a href="{{ route('penumpang.export', array_merge(request()->query(), ['format' => 'pdf'])) }}"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition text-center text-sm">
                        Export PDF
                    </a>
                    <a href="{{ route('penumpang.create') }}"
                        class="bg-blue-800 text-white px-4 py-2 rounded-md hover:bg-blue-900 transition text-center text-sm">
                        Tambah Penumpang
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50 p-3 md:p-4 rounded-lg mb-6">
                <form method="GET" action="{{ route('penumpang.index') }}" class="space-y-4">
                    <!-- Search Field -->
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, tujuan, nopol..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Filter Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Open</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Close</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Jam</label>
                            <input type="time" name="time_from" value="{{ request('time_from') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Jam</label>
                            <input type="time" name="time_to" value="{{ request('time_to') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-end">
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm">
                                    Filter
                                </button>
                                <a href="{{ route('penumpang.index') }}"
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition text-center text-sm">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            @canany(['admin', 'manager'])
                <div x-data="{ showBulkActions: false, selectedItems: [] }" class="mb-4">
                    <div x-show="selectedItems.length > 0" class="bg-blue-50 p-3 md:p-4 rounded-lg">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <span class="text-sm text-gray-700">
                                <span x-text="selectedItems.length"></span> item dipilih
                            </span>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                                <button @click="bulkUpdateStatus(true)"
                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 text-center">
                                    Set Open
                                </button>
                                <button @click="bulkUpdateStatus(false)"
                                    class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 text-center">
                                    Set Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endcanany

            @php
                $userCanManage = Gate::allows('admin') || Gate::allows('manager');
            @endphp

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            @if ($userCanManage)
                                <th class="py-3 px-4 text-left">
                                    <input type="checkbox" @click="toggleAll()"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                            @endif
                            <th class="py-3 px-4 text-left">Nama Penumpang</th>
                            <th class="py-3 px-4 text-left">Usia</th>
                            <th class="py-3 px-4 text-left">Jenis Kelamin</th>
                            <th class="py-3 px-4 text-left">Tujuan</th>
                            <th class="py-3 px-4 text-left">Tanggal</th>
                            <th class="py-3 px-4 text-left">Jam</th>
                            <th class="py-3 px-4 text-left">Nopol</th>
                            <th class="py-3 px-4 text-left">Jenis Kendaraan</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($penumpangs as $penumpang)
                            <tr class="hover:bg-gray-50">
                                @if ($userCanManage)
                                    <td class="py-3 px-4 border-b">
                                        <input type="checkbox" name="ids[]" value="{{ $penumpang->id }}"
                                            x-model="selectedItems"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                @endif
                                <td class="py-3 px-4 border-b">{{ $penumpang->nama_penumpang }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->usia }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->jenis_kelamin_label }}</td>
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
                                    <div class="flex justify-center space-x-3">
                                        <a href="{{ route('penumpang.show', $penumpang) }}"
                                            class="text-blue-500 hover:underline text-sm">Lihat</a>
                                        @if ($userCanManage)
                                            <a href="{{ route('penumpang.edit', $penumpang) }}"
                                                class="text-yellow-500 hover:underline text-sm">Edit</a>
                                            <form method="POST"
                                                action="{{ route('penumpang.destroy', $penumpang) }}" class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:underline text-sm">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $userCanManage ? 11 : 10 }}"
                                    class="py-3 px-4 text-center text-gray-500">
                                    Tidak ada data penumpang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden">
                @forelse ($penumpangs as $penumpang)
                    <div class="bg-white rounded-lg shadow mb-4 p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-lg">{{ $penumpang->nama_penumpang }}</h3>
                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $penumpang->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $penumpang->status_label }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 mt-2">
                            <p><strong>Usia:</strong> {{ $penumpang->usia }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ $penumpang->jenis_kelamin_label }}</p>
                            <p><strong>Tujuan:</strong> {{ $penumpang->tujuan }}</p>
                            <p><strong>Tanggal:</strong> {{ $penumpang->tanggal->format('d/m/Y') }}</p>
                            <p><strong>Jam:</strong> {{ $penumpang->tanggal->format('H:i') }}</p>
                            <p><strong>Nopol:</strong> {{ $penumpang->nopol }}</p>
                            <p><strong>Jenis Kendaraan:</strong> {{ $penumpang->jenis_kendaraan }}</p>
                        </div>
                        <div class="flex justify-end space-x-3 mt-4">
                            <a href="{{ route('penumpang.show', $penumpang) }}"
                                class="text-blue-500 hover:underline text-sm">Lihat</a>
                            @if ($userCanManage)
                                <a href="{{ route('penumpang.edit', $penumpang) }}"
                                    class="text-yellow-500 hover:underline text-sm">Edit</a>
                                <form method="POST" action="{{ route('penumpang.destroy', $penumpang) }}"
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-4">
                        Tidak ada data penumpang.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $penumpangs->links() }}
            </div>
        </div>

        <script>
            function bulkUpdateStatus(status) {
                const selectedIds = Array.from(document.querySelectorAll('input[name="ids[]"]:checked')).map(el => el.value);
                if (selectedIds.length === 0) {
                    alert('Pilih setidaknya satu item.');
                    return;
                }

                fetch('{{ route('penumpang.bulk-update-status') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: selectedIds,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Gagal memperbarui status.');
                        }
                    });
            }

            function toggleAll() {
                const checkboxes = document.querySelectorAll('input[name="ids[]"]');
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                checkboxes.forEach(checkbox => checkbox.checked = !allChecked);

                // Update Alpine.js state
                const alpineComponent = document.querySelector('[x-data]');
                const selectedItems = Array.from(document.querySelectorAll('input[name="ids[]"]:checked')).map(el => el.value);
                alpineComponent.__x.$data.selectedItems = selectedItems;
            }

            // Sync checkboxes with Alpine state
            document.addEventListener('alpine:init', () => {
                Alpine.data('bulkActions', () => ({
                    selectedItems: [],
                    init() {
                        this.$watch('selectedItems', (value) => {
                            const checkboxes = document.querySelectorAll('input[name="ids[]"]');
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = value.includes(checkbox.value);
                            });
                        });
                    }
                }));
            });
        </script>

    </x-admin-layout>
</body>

</html>
