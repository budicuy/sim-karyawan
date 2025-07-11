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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('usia');
            $table->enum('jenis_kelamin', ['L', 'P'])->comment('L = Laki-laki, P = Perempuan');
            $table->string('tujuan');
            $table->date('tanggal');
            $table->string('nopol');
            $table->string('jenis_kendaraan');
            $table->string('nomor_tiket')->unique();
            $table->string('url_image_tiket')->nullable();
            $table->boolean('status')->default(true)->comment('true = Open, false = Close');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['user_id']);
            $table->index(['tanggal']);
            $table->index(['status']);
            $table->index(['created_at']);
            $table->index(['nomor_tiket']);
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
