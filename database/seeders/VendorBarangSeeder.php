<?php

namespace Database\Seeders;

use App\Models\VendorBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = ['Pemerintah', 'PT. A', 'PT. B'];

        foreach ($vendors as $vendor) {
            VendorBarang::create([
                'nama_vendor' => $vendor
            ]);
        }
    }
}
