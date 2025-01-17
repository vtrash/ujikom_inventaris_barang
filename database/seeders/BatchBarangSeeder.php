<?php

namespace Database\Seeders;

use App\Models\BatchBarang;
use App\Models\VendorBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorBarangIds = VendorBarang::get()->pluck('id');

        foreach ($vendorBarangIds as $vendorBarangId) {
            for ($i = 0; $i < 2; $i++) {
                BatchBarang::create([
                    'vendor_id' => $vendorBarangId,
                    'tgl_diterima' => now(),
                    'keterangan' => fake()->sentence(),
                ]);
            }
        }

        BatchBarang::create([
            'tgl_diterima' => now(),
            'keterangan' => fake()->sentence(),
        ]);
    }
}
