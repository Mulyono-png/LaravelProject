<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $classrooms = [
            ['name' => 'XI PPLG 1', 'major' => 'PPLG'],
            ['name' => 'XI PPLG 2', 'major' => 'PPLG'],
            ['name' => 'XI PPLG 3', 'major' => 'PPLG'],
            ['name' => 'X PPLG 1', 'major' => 'PPLG'],
            ['name' => 'X PPLG 2', 'major' => 'PPLG'],
            ['name' => 'X PPLG 3', 'major' => 'PPLG'],
        ];

        Classroom::query()
            ->whereNotIn('name', array_column($classrooms, 'name'))
            ->delete();

        foreach ($classrooms as $classroom) {
            Classroom::updateOrCreate(
                ['name' => $classroom['name']],
                ['major' => $classroom['major']],
            );
        }
    }
}
