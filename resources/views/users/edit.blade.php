<!DOCTYPE html>
<html>

<head>
    <title>Edit Pengguna</title>
</head>

<body>
    <h1>Edit Pengguna</h1>
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" required>
        </div>
        <div>
            <label for="password">Password (kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="role">Role</label>
            <select name="role" id="role">
                <option value="admin" @if ($user->role == 'admin') selected @endif>Admin</option>
                <option value="manager" @if ($user->role == 'manager') selected @endif>Manager</option>
                <option value="user" @if ($user->role == 'user') selected @endif>User</option>
            </select>
        </div>
        <button type="submit">Update</button>
    </form>
</body>

</html>
