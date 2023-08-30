<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Pengaduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaduanNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengaduans = Pengaduan::query()->latest()->limit(5)->get();

        $pengaduans->each(function (Pengaduan $pengaduan, int $key) {
            $pengaduan->PengaduanNotification()->create([
                'mahasiswa_id' => Mahasiswa::query()->firstWhere('name', 'Azza')->id,
            ]);
        });
    }
}
