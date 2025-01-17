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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('nis_siswa');
            $table->datetime('tgl_peminjaman')->useCurrent();
            $table->datetime('tgl_pengembalian');
            $table->enum('status_pengembalian', [0, 1])->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('nis_siswa')->references('nis')->on('siswa')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
