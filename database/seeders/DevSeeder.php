<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\Mahasiswa;
use App\Models\RoleKategori;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleSuperAdmin = Role::create([
            'name' => 'superadmin',
            'slug' => 'superadmin'
        ]);

        $roleAdmin = Role::create([
            'name' => 'admin',
            'slug' => 'admin'
        ]);

        User::create([
            'role_id' => $roleSuperAdmin->id,
            'name' => 'Indra',
            'email' => 'indra@gmail.com',
            'password' => 'password',
            'jenis_kelamin' => 'laki'
        ]);

        User::create([
            'role_id' => $roleAdmin->id,
            'name' => 'alpit',
            'email' => 'alpit@gmail.com',
            'password' => 'password',
            'jenis_kelamin' => 'laki'
        ]);

        $kategoris = ['Akademik', 'Laboratorium', 'Unit Keuangan', 'Unit Perlengkapan', 'Perpustakaan'];
        foreach ($kategoris as $kategori) {
            $kategoriPengaduan = Kategori::create([
                'name' => $kategori,
                'slug' => Str::slug($kategori),
            ]);

            $roleKategori = Role::create([
                'name' => "Kepala $kategoriPengaduan->name",
                'slug' => Str::slug("Kepala $kategoriPengaduan->name"),
            ]);

            RoleKategori::create([
                'kategori_id' => $kategoriPengaduan->id,
                'role_id' => $roleKategori->id
            ]);

            User::create([
                'role_id' => $roleKategori->id,
                'name' => 'Admin ' . $roleKategori->name,
                'email' => "admin$roleKategori->slug@gmail.com",
                'password' => 'password',
                'jenis_kelamin' => 'laki'
            ]);
        }

        $jurusans = ['Sistem Informasi', 'Informatika', 'Teknik Sipil', 'Teknik Industri', 'Teknik Lingkungan', 'Teknik Kimia', 'Teknik Geologi', 'Teknik Elektro', 'Teknik Mesin'];
        foreach ($jurusans as $jurusan) {
            $jurusanMahasiswa = Jurusan::create([
                'name' => $jurusan,
                'slug' => Str::slug($jurusan),
                'kaprodi' => "Kaprodi $jurusan"
            ]);

            Mahasiswa::create([
                'jurusan_id' => $jurusanMahasiswa->id,
                'name' => "Mhs $jurusanMahasiswa->name",
                'nim' => fake()->unique()->numerify('191503####'),
                'email' => $jurusanMahasiswa->slug . '@gmail.com',
                'angkatan' => 2019,
                'password' => 'password',
            ]);
        }
    }
}
