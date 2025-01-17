<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            JenisBarangSeeder::class,
            VendorBarangSeeder::class,
            BatchBarangSeeder::class,
            BarangInventarisSeeder::class,
            JurusanSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            PeminjamanSeeder::class,
            DetailPeminjamanSeeder::class,
            PengembalianSeeder::class,
        ]);
    }
}
