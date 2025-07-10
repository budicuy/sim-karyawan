<!DOCTYPE html>
<html>

<head>
    <title>Tambah Karyawan</title>
</head>

<body>
    <h1>Tambah Data Karyawan</h1>
    <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="tujuan">Tujuan</label>
            <input type="text" name="tujuan" id="tujuan" required>
        </div>
        <div>
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" required>
        </div>
        <div>
            <label for="nopol">Nopol</label>
            <input type="text" name="nopol" id="nopol" required>
        </div>
        <div>
            <label for="foto_tiket">Foto Tiket</label>
            <input type="file" name="foto_tiket" id="foto_tiket" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
</body>

</html>
