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
        Schema::create('barang_inventaris', function (Blueprint $table) {
            $table->string('kode_barang')->primary();
            $table->string('kode_jenis_barang');
            $table->unsignedBigInteger('user_id');
            $table->string('vendor_id');
            $table->string('nama_barang');
            $table->datetime('tgl_diterima');
            $table->datetime('tgl_entry');
            $table->enum('kondisi_barang', [1, 2, 3]);
            $table->enum('status_dipinjam', [0, 1]);
            $table->integer('no_entry');
            $table->timestamps();

            $table->foreign('kode_jenis_barang')->references('kode_jenis_barang')->on('jenis_barang')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendor_barang')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_inventaris');
    }
};
