<?php

namespace App\Http\Controllers;

use App\Models\Penumpang;
use App\Http\Requests\StorePenumpangRequest;
use App\Http\Requests\UpdatePenumpangRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PenumpangController extends Controller
{
    use AuthorizesRequests;

    /**
     * Cache keys untuk penumpang
     */
    private const PENUMPANG_STATS_CACHE_KEY = 'penumpang_stats';
    private const RECENT_PENUMPANG_CACHE_KEY = 'recent_penumpang';
    private const CACHE_TTL = 300; // 5 menit

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penumpang::select(['id', 'nama_penumpang', 'usia', 'jenis_kelamin', 'tujuan', 'tanggal', 'nopol', 'jenis_kendaraan', 'status', 'created_at'])
            ->latest('created_at');

        // Apply filters
        if ($request->filled('status')) {
            $query->byStatus($request->boolean('status'));
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->byDateRange($request->date_from, $request->date_to);
        }

        if ($request->filled('time_from') && $request->filled('time_to')) {
            $query->byTimeRange($request->time_from, $request->time_to);
        }

        $penumpangs = $query->paginate(10)->withQueryString();

        return view('penumpang.index', compact('penumpangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penumpang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenumpangRequest $request)
    {
        $data = $request->validated();

        Penumpang::create($data);

        $this->clearCaches();

        return redirect()->route('penumpang.index')
            ->with('success', 'Data penumpang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penumpang $penumpang)
    {
        return view('penumpang.show', compact('penumpang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penumpang $penumpang)
    {
        return view('penumpang.edit', compact('penumpang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenumpangRequest $request, Penumpang $penumpang)
    {
        $data = $request->validated();

        $penumpang->update($data);

        $this->clearCaches();

        return redirect()->route('penumpang.index')
            ->with('success', 'Data penumpang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penumpang $penumpang)
    {
        $penumpang->delete();

        $this->clearCaches();

        return redirect()->route('penumpang.index')
            ->with('success', 'Data penumpang berhasil dihapus.');
    }

    /**
     * Update status penumpang
     */
    public function updateStatus(Request $request, Penumpang $penumpang)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        $penumpang->update(['status' => $request->status]);

        $this->clearCaches();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui',
            'status' => $penumpang->status_label
        ]);
    }

    /**
     * Get statistics for dashboard
     */
    public function stats()
    {
        $stats = Cache::remember(self::PENUMPANG_STATS_CACHE_KEY, self::CACHE_TTL, function () {
            $query = Penumpang::query();

            return [
                'total_penumpang' => $query->count(),
                'open_status' => $query->byStatus(true)->count(),
                'close_status' => $query->byStatus(false)->count(),
                'today_penumpang' => $query->whereDate('tanggal', today())->count(),
                'male_count' => $query->where('jenis_kelamin', 'L')->count(),
                'female_count' => $query->where('jenis_kelamin', 'P')->count(),
            ];
        });

        return response()->json($stats);
    }

    /**
     * Get recent penumpang data
     */
    public function recent()
    {
        $recentPenumpang = Cache::remember(self::RECENT_PENUMPANG_CACHE_KEY, self::CACHE_TTL, function () {
            $query = Penumpang::select(['id', 'nama_penumpang', 'tujuan', 'tanggal', 'nopol', 'status', 'created_at'])
                ->latest();

            return $query->take(5)->get();
        });

        return response()->json($recentPenumpang);
    }

    /**
     * Bulk operations
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:penumpang,id',
            'status' => 'required|boolean'
        ]);

        $penumpangIds = $request->ids;
        $query = Penumpang::whereIn('id', $penumpangIds);

        $query->update(['status' => $request->status]);

        $this->clearCaches();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui untuk ' . count($penumpangIds) . ' item.']);
    }

    /**
     * Export data
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'csv');

        $query = Penumpang::select(['id', 'nama_penumpang', 'usia', 'jenis_kelamin', 'tujuan', 'tanggal', 'nopol', 'jenis_kendaraan', 'status', 'created_at']);

        // Apply filters
        if ($request->filled('status')) {
            $query->byStatus($request->boolean('status'));
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->byDateRange($request->date_from, $request->date_to);
        }

        if ($request->filled('time_from') && $request->filled('time_to')) {
            $query->byTimeRange($request->time_from, $request->time_to);
        }

        $penumpangs = $query->get();

        if ($format === 'json') {
            return response()->json($penumpangs);
        }

        // CSV export
        $filename = 'penumpang_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($penumpangs) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, ['Nama', 'Usia', 'Jenis Kelamin', 'Tujuan', 'Tanggal', 'Jam', 'Nopol', 'Jenis Kendaraan', 'Status']);

            // Data rows
            foreach ($penumpangs as $penumpang) {
                fputcsv($file, [
                    $penumpang->nama_penumpang,
                    $penumpang->usia,
                    $penumpang->jenis_kelamin_label,
                    $penumpang->tujuan,
                    $penumpang->tanggal->format('Y-m-d'),
                    $penumpang->tanggal->format('H:i'),
                    $penumpang->nopol,
                    $penumpang->jenis_kendaraan,
                    $penumpang->status_label,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Clear related caches
     */
    private function clearCaches()
    {
        Cache::forget(self::PENUMPANG_STATS_CACHE_KEY);
        Cache::forget(self::RECENT_PENUMPANG_CACHE_KEY);
        Cache::forget('dashboard_stats');
    }
}
