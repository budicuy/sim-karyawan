<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Cache keys untuk dashboard
     */
    private const DASHBOARD_STATS_CACHE_KEY = 'dashboard_stats';
    private const RECENT_KARYAWAN_CACHE_KEY = 'recent_karyawan';
    private const CACHE_TTL = 300; // 5 menit untuk dashboard

    /**
     * Display the dashboard with optimized queries
     */
    public function index()
    {
        // Cache dashboard statistics
        $stats = Cache::remember(self::DASHBOARD_STATS_CACHE_KEY, self::CACHE_TTL, function () {
            return [
                'total_karyawan' => Karyawan::count(),
                'total_users' => User::count(),
                'admin_count' => User::byRole('admin')->count(),
                'manager_count' => User::byRole('manager')->count(),
                'user_count' => User::byRole('user')->count(),
            ];
        });

        // Cache recent karyawan data
        $recentKaryawan = Cache::remember(self::RECENT_KARYAWAN_CACHE_KEY, self::CACHE_TTL, function () {
            return Karyawan::with('user:id,name')
                ->select(['id', 'user_id', 'tujuan', 'tanggal', 'nopol', 'created_at'])
                ->latest()
                ->take(5)
                ->get();
        });

        // Calculate percentages for progress bars
        $totalUsers = $stats['total_users'];
        $percentages = [
            'admin' => $totalUsers > 0 ? round(($stats['admin_count'] / $totalUsers) * 100, 1) : 0,
            'manager' => $totalUsers > 0 ? round(($stats['manager_count'] / $totalUsers) * 100, 1) : 0,
            'user' => $totalUsers > 0 ? round(($stats['user_count'] / $totalUsers) * 100, 1) : 0,
        ];

        return view('dashboard', compact('stats', 'recentKaryawan', 'percentages'));
    }

    /**
     * Clear dashboard cache
     */
    public function clearCache()
    {
        Cache::forget(self::DASHBOARD_STATS_CACHE_KEY);
        Cache::forget(self::RECENT_KARYAWAN_CACHE_KEY);

        return response()->json(['message' => 'Dashboard cache cleared successfully']);
    }

    /**
     * Get dashboard stats as JSON (for AJAX)
     */
    public function stats()
    {
        $stats = Cache::remember(self::DASHBOARD_STATS_CACHE_KEY, self::CACHE_TTL, function () {
            return [
                'total_karyawan' => Karyawan::count(),
                'total_users' => User::count(),
                'admin_count' => User::byRole('admin')->count(),
                'manager_count' => User::byRole('manager')->count(),
                'user_count' => User::byRole('user')->count(),
            ];
        });

        return response()->json($stats);
    }
}
