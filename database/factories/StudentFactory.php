<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => fake()->unique()->numberBetween(20260001, 20999999),
            'name' => fake()->name(),
            'kelas' => fake()->randomElement(['XI PPLG 1', 'XI PPLG 2', 'XI PPLG 3', 'X PPLG 1', 'X PPLG 2', 'X PPLG 3']),
            'status' => fake()->randomElement(['Active', 'Inactive']),
        ];
    }
}
