<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengaduans = Pengaduan::query()->get();
        foreach ($pengaduans as $pengaduan) {
            $pengaduan->kategoris()->sync(Kategori::limit(fake()->unique(true)->randomElement([1, 2, 3]))->get(['id'])->map(fn ($value) => $value->id)->toArray());
        }
    }
}
