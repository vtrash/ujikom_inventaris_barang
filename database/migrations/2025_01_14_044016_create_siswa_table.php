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
        Schema::create('siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('nis')->primary();
            $table->unsignedBigInteger('kelas_id');
            $table->string('nama_siswa');
            $table->string('no_hp');
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas')->restrictOnDelete();
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
