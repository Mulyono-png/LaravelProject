<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SubjectSeeder::class);

        $teachers = [
            ['name' => 'Ahmad Fauzi', 'legacy_niy' => 'DEMO-NIY-001', 'niy' => '19904821', 'subjects' => ['Bahasa Indonesia' => 6, 'Sejarah' => 2]],
            ['name' => 'Siti Rahmawati', 'legacy_niy' => 'DEMO-NIY-002', 'niy' => '19907394', 'subjects' => ['Bahasa Inggris' => 6]],
            ['name' => 'Budi Santoso', 'legacy_niy' => 'DEMO-NIY-003', 'niy' => '19901058', 'subjects' => ['Matematika' => 8, 'Informatika' => 2]],
            ['name' => 'Dewi Anggraini', 'legacy_niy' => 'DEMO-NIY-004', 'niy' => '19908263', 'subjects' => ['Pendidikan Pancasila' => 4]],
            ['name' => 'Rudi Hermawan', 'legacy_niy' => 'DEMO-NIY-005', 'niy' => '19905917', 'subjects' => ['Pendidikan Jasmani' => 6]],
            ['name' => 'Nur Aisyah', 'legacy_niy' => 'DEMO-NIY-006', 'niy' => '19902740', 'subjects' => ['Sejarah' => 4, 'Pendidikan Pancasila' => 2]],
            ['name' => 'Agus Setiawan', 'legacy_niy' => 'DEMO-NIY-007', 'niy' => '19909635', 'subjects' => ['Informatika' => 6]],
            ['name' => 'Maya Permata', 'legacy_niy' => 'DEMO-NIY-008', 'niy' => '19904182', 'subjects' => ['Produk Kreatif dan Kewirausahaan' => 6]],
            ['name' => 'Dedi Kurniawan', 'legacy_niy' => 'DEMO-NIY-009', 'niy' => '19906509', 'subjects' => ['Matematika' => 4, 'Bahasa Inggris' => 2]],
            ['name' => 'Lina Marlina', 'legacy_niy' => 'DEMO-NIY-010', 'niy' => '19903076', 'subjects' => ['Bahasa Indonesia' => 4, 'Produk Kreatif dan Kewirausahaan' => 2]],
        ];

        foreach ($teachers as $teacherData) {
            Teacher::query()
                ->where('niy', $teacherData['legacy_niy'])
                ->update(['niy' => $teacherData['niy']]);

            $teacher = Teacher::query()->updateOrCreate(
                ['niy' => $teacherData['niy']],
                ['name' => $teacherData['name']],
            );

            $assignments = [];

            foreach ($teacherData['subjects'] as $subjectName => $lessonHours) {
                $subject = Subject::query()->where('name', $subjectName)->firstOrFail();
                $assignments[$subject->id] = ['lesson_hours' => $lessonHours];
            }

            $teacher->subjects()->syncWithoutDetaching($assignments);
        }
    }
}
