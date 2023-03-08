<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\Tiket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tikets = Tiket::query()->get()->count();

        Pengaduan::factory()->count(5)->create();
    }
}
