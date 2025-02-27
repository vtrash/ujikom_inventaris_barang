<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('peminjaman_id');
            $table->string('kode_barang');
            $table->timestamps();

            $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->restrictOnDelete();
            $table->foreign('kode_barang')->references('kode_barang')->on('barang_inventaris')->restrictOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
