<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Penumpang extends Model
{
    use HasFactory;

    protected $table = 'penumpang';

    protected $fillable = [
        'nama_penumpang',
        'usia',
        'jenis_kelamin',
        'tujuan',
        'tanggal',
        'nopol',
        'jenis_kendaraan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus(Builder $query, bool $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeByDateRange(Builder $query, $startDate, $endDate): Builder
    {
        // Cast to date to ignore time part for date range filtering
        return $query->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate);
    }

    /**
     * Scope for filtering by time range
     */
    public function scopeByTimeRange(Builder $query, $startTime, $endTime): Builder
    {
        return $query->whereTime('tanggal', '>=', $startTime)
            ->whereTime('tanggal', '<=', $endTime);
    }

    /**
     * Scope for searching
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_penumpang', 'like', "%{$search}%")
                ->orWhere('tujuan', 'like', "%{$search}%")
                ->orWhere('nopol', 'like', "%{$search}%")
                ->orWhere('jenis_kendaraan', 'like', "%{$search}%");
        });
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Open' : 'Close';
    }

    /**
     * Get gender label
     */
    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
