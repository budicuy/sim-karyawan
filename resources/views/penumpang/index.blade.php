<!DOCTYPE html>
<html>

<head>
    <title>Data Penumpang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                    <a href="{{ route('penumpang.export', ['format' => 'csv']) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-center text-sm">
                        Export CSV
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
                            placeholder="Cari nama, tujuan, nopol, nomor tiket..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Filter Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
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

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            @canany(['admin', 'manager'])
                                <th class="py-3 px-4 text-left">
                                    <input type="checkbox" @click="toggleAll()"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                            @endcanany
                            <th class="py-3 px-4 text-left">Nama</th>
                            <th class="py-3 px-4 text-left">Usia</th>
                            <th class="py-3 px-4 text-left">Jenis Kelamin</th>
                            <th class="py-3 px-4 text-left">Tujuan</th>
                            <th class="py-3 px-4 text-left">Tanggal</th>
                            <th class="py-3 px-4 text-left">Nopol</th>
                            <th class="py-3 px-4 text-left">Jenis Kendaraan</th>
                            <th class="py-3 px-4 text-left">Nomor Tiket</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($penumpangs as $penumpang)
                            <tr class="hover:bg-gray-50">
                                @canany(['admin', 'manager'])
                                    <td class="py-3 px-4 border-b">
                                        <input type="checkbox" value="{{ $penumpang->id }}"
                                            @change="toggleItem({{ $penumpang->id }})"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                @endcanany
                                <td class="py-3 px-4 border-b">{{ $penumpang->user->name }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->usia }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->jenis_kelamin_label }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->tujuan }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->tanggal->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->nopol }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->jenis_kendaraan }}</td>
                                <td class="py-3 px-4 border-b">{{ $penumpang->nomor_tiket }}</td>
                                <td class="py-3 px-4 border-b">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $penumpang->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $penumpang->status_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border-b">
                                    <div class="flex space-x-3">
                                        <button>
                                            <a href="{{ route('penumpang.show', $penumpang) }}"
                                                class="text-blue-500 hover:underline text-sm">Lihat</a>
                                        </button>
                                        @can('update', $penumpang)
                                            <button>
                                                <a href="{{ route('penumpang.edit', $penumpang) }}"
                                                    class="text-yellow-500 hover:underline text-sm">Edit</a>
                                            </button>
                                        @endcan
                                        @can('delete', $penumpang)
                                            <form method="POST" action="{{ route('penumpang.destroy', $penumpang) }}"
                                                class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:underline text-sm">Hapus</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile/Tablet Card View -->
            <div class="lg:hidden space-y-4">
                @foreach ($penumpangs as $penumpang)
                    <div class="bg-white border rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center space-x-3">
                                @canany(['admin', 'manager'])
                                    <input type="checkbox" value="{{ $penumpang->id }}"
                                        @change="toggleItem({{ $penumpang->id }})"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                @endcanany
                                <h3 class="font-semibold text-gray-800">{{ $penumpang->user->name }}</h3>
                            </div>
                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $penumpang->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $penumpang->status_label }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm text-gray-600 mb-4">
                            <div>
                                <span class="font-medium">Usia:</span>
                                <span class="text-gray-800">{{ $penumpang->usia }} tahun</span>
                            </div>
                            <div>
                                <span class="font-medium">Jenis Kelamin:</span>
                                <span class="text-gray-800">{{ $penumpang->jenis_kelamin_label }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Tujuan:</span>
                                <span class="text-gray-800">{{ $penumpang->tujuan }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Tanggal:</span>
                                <span class="text-gray-800">{{ $penumpang->tanggal->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Nopol:</span>
                                <span class="text-gray-800">{{ $penumpang->nopol }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Kendaraan:</span>
                                <span class="text-gray-800">{{ $penumpang->jenis_kendaraan }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="font-medium">Nomor Tiket:</span>
                                <span class="text-gray-800">{{ $penumpang->nomor_tiket }}</span>
                            </div>
                        </div>

                        <div class="flex flex-nowrap items-center  gap-4 pt-3 border-t">
                            <button>
                                <a href="{{ route('penumpang.show', $penumpang) }}"
                                    class="text-blue-500 hover:underline text-sm">Lihat</a>
                            </button>
                            @can('update', $penumpang)
                                <button>
                                    <a href="{{ route('penumpang.edit', $penumpang) }}"
                                        class="text-yellow-500 hover:underline text-sm">Edit</a>
                                </button>
                            @endcan
                            @can('delete', $penumpang)
                                <form method="POST" action="{{ route('penumpang.destroy', $penumpang) }}"
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-sm">Hapus</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $penumpangs->links() }}
            </div>
        </div>

        <script>
            function toggleAll() {
                const checkboxes = document.querySelectorAll('input[type="checkbox"][value]');
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);

                checkboxes.forEach(cb => {
                    cb.checked = !allChecked;
                });

                updateSelectedItems();
            }

            function toggleItem(id) {
                updateSelectedItems();
            }

            function updateSelectedItems() {
                const checkboxes = document.querySelectorAll('input[type="checkbox"][value]:checked');
                const selectedItems = Array.from(checkboxes).map(cb => parseInt(cb.value));

                // Update Alpine.js data
                document.dispatchEvent(new CustomEvent('update-selected', {
                    detail: {
                        selectedItems
                    }
                }));
            }

            function bulkUpdateStatus(status) {
                const checkboxes = document.querySelectorAll('input[type="checkbox"][value]:checked');
                const selectedIds = Array.from(checkboxes).map(cb => cb.value);

                if (selectedIds.length === 0) {
                    alert('Pilih minimal satu item');
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('penumpang.bulk-update-status') }}';

                // CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Method
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                form.appendChild(methodField);

                // Status
                const statusField = document.createElement('input');
                statusField.type = 'hidden';
                statusField.name = 'status';
                statusField.value = status;
                form.appendChild(statusField);

                // Selected IDs
                selectedIds.forEach(id => {
                    const idField = document.createElement('input');
                    idField.type = 'hidden';
                    idField.name = 'penumpang_ids[]';
                    idField.value = id;
                    form.appendChild(idField);
                });

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    </x-admin-layout>
</body>

</html>
