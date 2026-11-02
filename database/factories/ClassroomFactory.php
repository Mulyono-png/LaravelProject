<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;

    public function definition(): array
    {
        return fake()->randomElement([
            ['name' => 'XI PPLG 1', 'major' => 'PPLG'],
            ['name' => 'XI PPLG 2', 'major' => 'PPLG'],
            ['name' => 'X PPLG 1', 'major' => 'PPLG'],
            ['name' => 'X PPLG 2', 'major' => 'PPLG'],
        ]);
    }
}
