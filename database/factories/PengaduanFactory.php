<?php

namespace Database\Factories;

use App\Models\Tiket;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengaduan>
 */
class PengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tikets = Tiket::query()->pluck('id')->toArray();

        return [
            'tiket_id' => fake()->unique()->randomElement($tikets),
            'title' => fake()->sentence(mt_rand(3, 5)),
            'slug' => fn (array $attributes) => Str::slug($attributes['title']),
            'deskripsi' => collect(fake()->paragraphs(mt_rand(3, 5)))->map(fn ($deskrip) => "<p>" . $deskrip . "</p>")->implode(' '),
            'status' => fake()->randomElement(['success', 'process', 'failed', 'pending']),
            'rating' => fake()->randomElement([1, 2, 3, 4, 5]),
        ];
    }
}
