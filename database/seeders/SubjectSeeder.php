<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Matematika',
            'Pendidikan Pancasila',
            'Pendidikan Jasmani',
            'Sejarah',
            'Informatika',
            'Produk Kreatif dan Kewirausahaan',
        ];

        foreach ($subjects as $name) {
            Subject::query()->firstOrCreate(['name' => $name]);
        }
    }
}
