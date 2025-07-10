<!DOCTYPE html>
<html>

<head>
    <title>Edit Karyawan</title>
</head>

<body>
    <h1>Edit Data Karyawan</h1>
    <form action="{{ route('karyawan.update', $karyawan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="tujuan">Tujuan</label>
            <input type="text" name="tujuan" id="tujuan" value="{{ $karyawan->tujuan }}" required>
        </div>
        <div>
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ $karyawan->tanggal }}" required>
        </div>
        <div>
            <label for="nopol">Nopol</label>
            <input type="text" name="nopol" id="nopol" value="{{ $karyawan->nopol }}" required>
        </div>
        <div>
            <label for="foto_tiket">Foto Tiket</label>
            <input type="file" name="foto_tiket" id="foto_tiket">
            <img src="{{ asset('storage/' . $karyawan->foto_tiket) }}" width="100">
        </div>
        <button type="submit">Update</button>
    </form>
</body>

</html>
