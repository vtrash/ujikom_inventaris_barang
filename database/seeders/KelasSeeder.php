<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $konsentrasis = [
            'PPLG' => [
                '10' => [
                    '1', '2'
                ],
                '11' => [
                    'RPL 1', 'GIM 1'
                ],
                '12' => [
                    'RPL 1', 'GIM 1'
                ],
            ],
        ];

        foreach ($konsentrasis as $konsentrasi => $konsentrasiPerKelas) {
            $jurusanId = Jurusan::where('jurusan', $konsentrasi)->first()->id;

            foreach ($konsentrasiPerKelas as $tingkatan => $noKonsentrasis) {
                foreach ($noKonsentrasis as $noKonsentrasi) {
                    Kelas::create([
                        'jurusan_id' => $jurusanId,
                        'no_konsentrasi' => $noKonsentrasi,
                        'tingkatan' => $tingkatan,
                    ]);
                }
            }
        }
    }
}
