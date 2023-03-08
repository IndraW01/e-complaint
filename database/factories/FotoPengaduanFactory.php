<?php

namespace Database\Factories;

use App\Models\Pengaduan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FotoPengaduan>
 */
class FotoPengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pengaduans = Pengaduan::query()->pluck('id')->toArray();

        return [
            'pengaduan_id' => fake()->randomElement($pengaduans),
            'name' => fake()->imageUrl(640, 480, 'animals', true)
        ];
    }
}
