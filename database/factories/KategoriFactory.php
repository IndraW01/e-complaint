<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Akademik', 'Laboratorium', 'Unit Keuangan', 'Unit Perlengkapan', 'Perpustakaan']),
            'slug' => fn (array $attributes) => Str::slug($attributes['name']),
        ];
    }
}
