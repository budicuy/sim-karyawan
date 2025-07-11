<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Penumpang table already has indexes in its migration
        // This migration is just for documentation purposes

        // Additional indexes for better performance
        Schema::table('penumpang', function (Blueprint $table) {
            $table->index(['jenis_kelamin']);
            $table->index(['tujuan']);
            $table->index(['jenis_kendaraan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penumpang', function (Blueprint $table) {
            $table->dropIndex(['jenis_kelamin']);
            $table->dropIndex(['tujuan']);
            $table->dropIndex(['jenis_kendaraan']);
        });
    }
};
