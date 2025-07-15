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
        Schema::create('penumpang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penumpang');
            $table->integer('usia');
            $table->enum('jenis_kelamin', ['L', 'P'])->comment('L = Laki-laki, P = Perempuan');
            $table->string('tujuan');
            $table->dateTime('tanggal');
            $table->string('nopol');
            $table->string('jenis_kendaraan');
            $table->boolean('status')->default(true)->comment('true = Open, false = Close');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['tanggal']);
            $table->index(['status']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penumpang');
    }
};
