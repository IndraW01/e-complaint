<?php

namespace Database\Factories;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
        $jurusans = Jurusan::query()->pluck('id')->toArray();

        return [
            'jurusan_id' => fake()->randomElement($jurusans),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'nim' => fake()->numerify('##########'),
            'password' => 'password',
            'angkatan' => fake()->randomElement([2018, 2019, 2020, 2021, 2022])
        ];
    }
}
