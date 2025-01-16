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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('detail_peminjaman_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tgl_kembali');
            $table->enum('kondisi_barang_kembali', [1, 2, 3, 4]);
            $table->enum('status_pengembalian', [0, 1]);
            $table->timestamps();

            $table->foreign('detail_peminjaman_id')->references('id')->on('detail_peminjaman')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
