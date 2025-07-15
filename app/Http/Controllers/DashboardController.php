<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penumpang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Cache keys untuk dashboard
     */
    private const DASHBOARD_STATS_CACHE_KEY = 'dashboard_stats';
    private const RECENT_PENUMPANG_CACHE_KEY = 'recent_penumpang';
    private const CACHE_TTL = 300; // 5 menit untuk dashboard

    /**
     * Get dashboard statistics from cache or database
     */
    private function getDashboardStats()
    {
        return Cache::remember(self::DASHBOARD_STATS_CACHE_KEY, self::CACHE_TTL, function () {
            $penumpangQuery = Penumpang::query();
            $userQuery = User::query();

            return [
                'total_penumpang' => $penumpangQuery->clone()->count(),
                'total_users'     => $userQuery->clone()->count(),
                'admin_count'     => $userQuery->clone()->byRole('admin')->count(),
                'manager_count'   => $userQuery->clone()->byRole('manager')->count(),
                'user_count'      => $userQuery->clone()->byRole('user')->count(),
                'open_status'     => $penumpangQuery->clone()->where('status', true)->count(),
                'close_status'    => $penumpangQuery->clone()->where('status', false)->count(),
            ];
        });
    }

    /**
     * Display the dashboard with optimized queries
     */
    public function index()
    {
        // Get dashboard statistics
        $stats = $this->getDashboardStats();

        // Cache recent penumpang data
        $recentPenumpang = Cache::remember(self::RECENT_PENUMPANG_CACHE_KEY, self::CACHE_TTL, function () {
            $query = Penumpang::select(['id', 'nama_penumpang', 'tujuan', 'tanggal', 'nopol', 'jenis_kendaraan', 'status', 'created_at'])
                ->latest();

            return $query->take(5)->get();
        });

        // Calculate percentages for progress bars
        $totalUsers = $stats['total_users'];
        $percentages = [
            'admin' => $totalUsers > 0 ? round(($stats['admin_count'] / $totalUsers) * 100, 1) : 0,
            'manager' => $totalUsers > 0 ? round(($stats['manager_count'] / $totalUsers) * 100, 1) : 0,
            'user' => $totalUsers > 0 ? round(($stats['user_count'] / $totalUsers) * 100, 1) : 0,
        ];

        return view('dashboard', compact('stats', 'recentPenumpang', 'percentages'));
    }

    /**
     * Clear dashboard cache
     */
    public function clearCache()
    {
        Cache::forget(self::DASHBOARD_STATS_CACHE_KEY);
        Cache::forget(self::RECENT_PENUMPANG_CACHE_KEY);

        return response()->json(['message' => 'Dashboard cache cleared successfully']);
    }

    /**
     * Get dashboard stats as JSON (for AJAX)
     */
    public function stats()
    {
        $stats = $this->getDashboardStats();

        return response()->json($stats);
    }
}
