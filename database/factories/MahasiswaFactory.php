<?php

namespace Database\Factories;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()->withWhereHas('Role', function (Builder $query) {
            $query->whereName('mahasiswa');
        })->pluck('id')->toArray();

        $jurusans = Jurusan::query()->pluck('id')->toArray();

        return [
            'user_id' => fake()->unique()->randomElement($users),
            'jurusan_id' => fake()->randomElement($jurusans),
            'nim' => fake()->numerify('##########'),
        ];
    }
}
