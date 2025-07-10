<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <h1>Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}!</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <br>

    @can('admin')
        <a href="{{ route('users.index') }}">Manage Users</a>
    @endcan

    @if (in_array(Auth::user()->role, ['admin', 'manager']))
        <a href="{{ route('karyawan.index') }}">Manage All Karyawan</a>
    @else
        <a href="{{ route('karyawan.index') }}">Manage My Karyawan</a>
    @endif

</body>

</html>
