<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tiket>
 */
class TiketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mahasiswas = Mahasiswa::query()->pluck('id')->toArray();

        return [
            'mahasiswa_id' => fake()->unique()->randomElement($mahasiswas),
            'token' => fake()->unique()->uuid()
        ];
    }
}
