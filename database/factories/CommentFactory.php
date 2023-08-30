<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pengaduans = Pengaduan::query()->pluck('id')->toArray();

        $classType = function (array $attributes) {
            return Mahasiswa::query()->where('id', $attributes['commentable_id'])->exists() ? Mahasiswa::class : User::class;
        };

        $user = User::query()->whereHas('Role', function ($query) {
            $query->whereIn('name', ['superadmin', 'admin']);
        })->first()->id;

        $mahasiswa = Mahasiswa::query()->whereHas('Tiket.Pengaduan', function ($query) use ($pengaduans) {
            $query->where('pengaduans.id', fake()->randomElement($pengaduans));
        })->first()->id;

        return [
            'commentable_type' => $classType,
            'commentable_id' => fake()->randomElement([$mahasiswa, $user]),
            'pengaduan_id' => fake()->randomElement($pengaduans),
            'pesan' => fake()->paragraph()
        ];
    }
}
