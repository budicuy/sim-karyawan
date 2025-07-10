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
        Schema::table('users', function (Blueprint $table) {
            $table->index(['email']);
            $table->index(['role']);
            $table->index(['created_at']);
        });

        Schema::table('karyawan', function (Blueprint $table) {
            $table->index(['user_id']);
            $table->index(['tanggal']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['role']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['created_at']);
        });
    }
};
