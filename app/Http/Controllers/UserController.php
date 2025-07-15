<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Cache key untuk statistik user
     */
    private const USER_STATS_CACHE_KEY = 'user_stats';
    private const CACHE_TTL = 3600; // 1 jam


    /**
     * Clear user statistics cache
     */
    private function clearUserStatsCache()
    {
        Cache::forget(self::USER_STATS_CACHE_KEY);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Build query dengan optimasi
        $query = User::select(['id', 'name', 'email', 'role', 'created_at']);

        // Filter berdasarkan role jika ada
        if ($request->filled('role')) {
            $query->byRole($request->role);
        }

        // Pencarian jika ada
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Cache count untuk pagination yang lebih efisien
        $users = $query->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:admin,manager,user'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Menggunakan route model binding yang sudah ada, tidak perlu query tambahan
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:admin,manager,user'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Hanya hash password jika diisi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Cek apakah user yang akan dihapus bukan user yang sedang login
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Optimasi: gunakan single query untuk cek admin dan count sekaligus
        if ($user->role === 'admin') {
            $adminCount = User::byRole('admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('users.index')
                    ->with('error', 'Tidak dapat menghapus admin terakhir.');
            }
        }
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Bulk delete users with optimized queries
     */
    public function bulkDestroy(Request $request)
    {
        $userIds = $request->input('user_ids', []);

        if (empty($userIds)) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak ada pengguna yang dipilih.');
        }

        // Validasi: pastikan user tidak menghapus diri sendiri
        if (in_array(Auth::id(), $userIds)) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Optimasi: single query untuk cek admin dan count
        $usersToDelete = User::whereIn('id', $userIds)->get(['id', 'role']);
        $adminIds = $usersToDelete->where('role', 'admin')->pluck('id');

        if ($adminIds->isNotEmpty()) {
            $totalAdmins = User::byRole('admin')->count();
            if ($totalAdmins <= $adminIds->count()) {
                return redirect()->route('users.index')
                    ->with('error', 'Tidak dapat menghapus semua admin.');
            }
        }

        // Bulk delete dengan single query
        User::whereIn('id', $userIds)->delete();

        // Clear cache setelah operasi yang mengubah data
        $this->clearUserStatsCache();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus sebanyak ' . count($userIds) . ' data.');
    }

    /**
     * Bulk update user roles
     */
    public function bulkUpdateRole(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['integer', 'exists:users,id'],
            'role' => ['required', 'string', 'in:admin,manager,user'],
        ]);

        $userIds = $validated['user_ids'];
        $newRole = $validated['role'];

        // Validasi: pastikan tidak mengubah role admin terakhir
        if ($newRole !== 'admin') {
            $usersToUpdate = User::whereIn('id', $userIds)->get(['id', 'role']);
            $adminIds = $usersToUpdate->where('role', 'admin')->pluck('id');

            if ($adminIds->isNotEmpty()) {
                $totalAdmins = User::byRole('admin')->count();
                if ($totalAdmins <= $adminIds->count()) {
                    return redirect()->route('users.index')
                        ->with('error', 'Tidak dapat mengubah role admin terakhir.');
                }
            }
        }

        // Bulk update dengan single query
        User::whereIn('id', $userIds)->update(['role' => $newRole]);

        // Clear cache setelah operasi bulk
        $this->clearUserStatsCache();

        return redirect()->route('users.index')
            ->with('success', 'Role pengguna berhasil diperbarui sebanyak ' . count($userIds) . ' data.');
    }
}
