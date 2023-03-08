<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersCount = User::query()->whereHas('Role', function (Builder $query) {
            $query->whereName('mahasiswa');
        })->get()->count();

        Mahasiswa::factory()->count($usersCount)->create();
    }
}
