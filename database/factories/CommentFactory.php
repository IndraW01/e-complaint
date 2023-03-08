<?php

namespace Database\Factories;

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
        $users = User::query()->pluck('id')->toArray();
        $pengaduans = Pengaduan::query()->pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($users),
            'pengaduan_id' => fake()->randomElement($pengaduans),
            'pesan' => collect(fake()->paragraphs(mt_rand(2, 4)))->map(fn ($deskrip) => "<p>" . $deskrip . "</p>")->implode(' ')
        ];
    }
}
