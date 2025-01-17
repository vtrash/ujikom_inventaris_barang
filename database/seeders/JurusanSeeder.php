<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = ['PPLG', 'MPLB', 'TJKT', 'AKKUL', 'PS'];

        foreach ($jurusans as $jurusan) {
            Jurusan::create([
                'jurusan' => $jurusan
            ]);
        }
    }
}
