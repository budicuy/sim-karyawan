<?php

namespace App\Observers;

use App\Models\Penumpang;
use Illuminate\Support\Facades\Cache;

class PenumpangObserver
{
    /**
     * Cache keys yang perlu dihapus
     */
    private const CACHE_KEYS = [
        'dashboard_stats',
        'penumpang_stats',
        'recent_penumpang',
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
     * Handle the Penumpang "created" event.
     */
    public function created(Penumpang $penumpang): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Penumpang "updated" event.
     */
    public function updated(Penumpang $penumpang): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Penumpang "deleted" event.
     */
    public function deleted(Penumpang $penumpang): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Penumpang "restored" event.
     */
    public function restored(Penumpang $penumpang): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Penumpang "force deleted" event.
     */
    public function forceDeleted(Penumpang $penumpang): void
    {
        $this->clearCaches();
    }
}
