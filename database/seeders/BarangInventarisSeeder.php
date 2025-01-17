<?php

namespace Database\Seeders;

use App\Models\BarangInventaris;
use App\Models\BatchBarang;
use App\Models\JenisBarang;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangInventarisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisBarangIds = JenisBarang::get()->pluck('kode_jenis_barang');

        $batchBarangIds = BatchBarang::get()->pluck('id');

        $userId = User::where('name', 'user')->first()->id;

        foreach ($batchBarangIds as $batchBarangId) {
            for ($i = 0; $i < 5; $i++) {
                BarangInventaris::create([
                    'kode_barang' => BarangInventaris::generateId(),
                    'kode_jenis_barang' => $jenisBarangIds->random(),
                    'batch_barang_id' => $batchBarangId,
                    'user_id' => $userId,
                    'nama_barang' => fake()->realText(20),
                    'tgl_entry' => now(),
                    'kondisi_barang' => '1',
                    'status_dipinjam' => '0',
                ]);
            }
        }
    }
}
