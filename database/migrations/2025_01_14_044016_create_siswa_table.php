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
        Schema::create('siswa', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('kelas_id');
            $table->string('jurusan_id');
            $table->string('nama_siswa');
            $table->string('nis');
            $table->string('no_hp');
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas')->restrictOnDelete();
            $table->foreign('jurusan_id')->references('id')->on('jurusan')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
