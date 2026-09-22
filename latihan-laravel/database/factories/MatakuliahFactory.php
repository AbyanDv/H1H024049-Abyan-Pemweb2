<?php

namespace Database\Factories;

use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Matakuliah>
 */
class MatakuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->bothify('MK###'),
            'nama' => fake()->words(3, true),
            'sks' => fake()->numberBetween(2, 4),
            'semester' => fake()->numberBetween(1, 8),
        ];
    }
}
