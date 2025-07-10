<!DOCTYPE html>
<html>

<head>
    <title>Tambah Pengguna</title>
</head>

<body>
    <h1>Tambah Pengguna</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="role">Role</label>
            <select name="role" id="role">
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="user">User</option>
            </select>
        </div>
        <button type="submit">Simpan</button>
    </form>
</body>

</html>
