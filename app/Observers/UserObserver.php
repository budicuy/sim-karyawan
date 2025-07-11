<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Cache keys yang perlu dihapus
     */
    private const CACHE_KEYS = [
        'dashboard_stats',
        'user_stats',
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
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        $this->clearCaches();
    }
}
