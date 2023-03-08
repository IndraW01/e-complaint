<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Tiket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = Mahasiswa::query()->get()->count();
        Tiket::factory()->count($mahasiswas)->create();
    }
}
