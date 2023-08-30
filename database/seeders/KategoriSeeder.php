<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Role;
use App\Models\RoleKategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = Kategori::factory()->count(5)->create();
        foreach ($kategoris as $kategori) {
            $role = Role::create(['name' => 'Kepala ' . $kategori->name]);
            $role->RoleKategori()->create(['kategori_id' => $kategori->id]);
        }
    }
}
