<!DOCTYPE html>
<html>

<head>
    <title>Karyawan</title>
</head>

<body>
    <h1>Data Karyawan</h1>
    <a href="{{ route('karyawan.create') }}">Tambah Karyawan</a>
    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Nopol</th>
                <th>Foto Tiket</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $karyawan)
                <tr>
                    <td>{{ $karyawan->user->name }}</td>
                    <td>{{ $karyawan->tujuan }}</td>
                    <td>{{ $karyawan->tanggal }}</td>
                    <td>{{ $karyawan->nopol }}</td>
                    <td><img src="{{ asset('storage/' . $karyawan->foto_tiket) }}" width="100"></td>
                    <td>
                        <a href="{{ route('karyawan.edit', $karyawan) }}">Edit</a>
                        <form action="{{ route('karyawan.destroy', $karyawan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
