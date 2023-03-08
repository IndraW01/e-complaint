<?php

namespace Database\Seeders;

use App\Models\FotoPengaduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FotoPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FotoPengaduan::factory()->count(15)->create();
    }
}
