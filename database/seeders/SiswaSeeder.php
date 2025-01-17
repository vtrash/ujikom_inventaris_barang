<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasIds = Kelas::get()->pluck('id');

        foreach ($kelasIds as $kelasId) {
            for ($i = 0; $i < 5; $i++) {
                Siswa::create([
                    'nis' => str_pad(fake()->numberBetween(), 10, 0, STR_PAD_LEFT),
                    'kelas_id' => $kelasId,
                    'nama_siswa' => fake()->name(),
                    'no_hp' => fake()->phoneNumber(),
                ]);
            }
        }
     }
}
