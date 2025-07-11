<?php

namespace App\Observers;

use App\Models\Karyawan;
use Illuminate\Support\Facades\Cache;

class KaryawanObserver
{
    /**
     * Cache keys yang perlu dihapus
     */
    private const CACHE_KEYS = [
        'dashboard_stats',
        'recent_karyawan',
    ];

    /**
     * Clear related caches
     */
    private function clearCaches()
    {
        foreach (self::CACHE_KEYS as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Handle the Karyawan "created" event.
     */
    public function created(Karyawan $karyawan): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Karyawan "updated" event.
     */
    public function updated(Karyawan $karyawan): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Karyawan "deleted" event.
     */
    public function deleted(Karyawan $karyawan): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Karyawan "restored" event.
     */
    public function restored(Karyawan $karyawan): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Karyawan "force deleted" event.
     */
    public function forceDeleted(Karyawan $karyawan): void
    {
        $this->clearCaches();
    }
}
