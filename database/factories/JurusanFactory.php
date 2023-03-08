<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jurusan>
 */
class JurusanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Teknik Industri', 'Informatika', 'Sistem Informasi', 'Teknik Elektro', 'Teknik Geologi']),
            'slug' => fn (array $attributes) => Str::slug($attributes['name']),
            'kaprodi' => fake()->name(),
        ];
    }
}
