<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            KategoriSeeder::class,
            UserSeeder::class,
            JurusanSeeder::class,
            MahasiswaSeeder::class,
            TiketSeeder::class,
            PengaduanSeeder::class,
            FotoPengaduanSeeder::class,
            CommentSeeder::class,
            KategoriPengaduanSeeder::class,
            PengaduanNotificationSeeder::class,
        ]);
    }
}
