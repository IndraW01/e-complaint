<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(15)->create();

        User::query()->orderBy('name', 'asc')->first()->update([
            'name' => 'Indra Wijaya',
            'email' => 'indra@gmail.com',
            'role_id' => Role::query()->where('name', 'superadmin')->value('id')
        ]);

        User::query()->orderBy('name', 'desc')->first()->update([
            'name' => 'Jauhari Fadli',
            'email' => 'fadli@gmail.com',
            'role_id' => Role::query()->where('name', 'Kepala Akademik')->value('id')
        ]);
    }
}
