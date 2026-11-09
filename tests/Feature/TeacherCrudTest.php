<?php

namespace Tests\Feature;

use App\Models\Subject;
use App\Models\Teacher;
use Database\Seeders\TeacherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_be_created_with_multiple_subjects_and_lesson_hours(): void
    {
        $math = Subject::factory()->create(['name' => 'Matematika']);
        $science = Subject::factory()->create(['name' => 'IPA']);

        $response = $this->post(route('admin.teacher.store'), [
            'name' => 'Budi Santoso',
            'niy' => '19901234',
            'subjects' => [
                ['subject_id' => $math->id, 'lesson_hours' => 6],
                ['subject_id' => $science->id, 'lesson_hours' => 4],
            ],
        ]);

        $response->assertRedirect(route('admin.teacher.index'));
        $this->assertDatabaseHas('teachers', [
            'name' => 'Budi Santoso',
            'niy' => '19901234',
        ]);
        $this->assertDatabaseHas('subject_teacher', [
            'teacher_id' => Teacher::query()->where('niy', '19901234')->value('id'),
            'subject_id' => $math->id,
            'lesson_hours' => 6,
        ]);
        $this->assertDatabaseHas('subject_teacher', [
            'teacher_id' => Teacher::query()->where('niy', '19901234')->value('id'),
            'subject_id' => $science->id,
            'lesson_hours' => 4,
        ]);
    }

    public function test_teacher_creation_rejects_missing_details_and_assignments(): void
    {
        $response = $this->post(route('admin.teacher.store'), []);

        $response->assertSessionHasErrors(['name', 'niy', 'subjects']);
        $this->assertDatabaseCount('teachers', 0);
    }

    public function test_teacher_requires_positive_lesson_hours_for_each_subject(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->post(route('admin.teacher.store'), [
            'name' => 'Budi Santoso',
            'niy' => '19901234',
            'subjects' => [
                ['subject_id' => $subject->id, 'lesson_hours' => 0],
            ],
        ]);

        $response->assertSessionHasErrors(['subjects.0.lesson_hours']);
        $this->assertDatabaseCount('teachers', 0);
        $this->assertDatabaseCount('subject_teacher', 0);
    }

    public function test_teacher_creation_rejects_niy_outside_the_1990_plus_four_digits_format(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->post(route('admin.teacher.store'), [
            'name' => 'Budi Santoso',
            'niy' => '1990123',
            'subjects' => [
                ['subject_id' => $subject->id, 'lesson_hours' => 6],
            ],
        ]);

        $response->assertSessionHasErrors(['niy']);
        $this->assertDatabaseCount('teachers', 0);
    }

    public function test_teacher_form_renders_after_subject_assignments_fail_array_validation(): void
    {
        $this->from(route('admin.teacher.create'))
            ->post(route('admin.teacher.store'), [
                'name' => 'Budi Santoso',
                'niy' => '19901234',
                'subjects' => 'not-an-array',
            ])
            ->assertSessionHasErrors(['subjects']);

        $this->get(route('admin.teacher.create'))
            ->assertOk()
            ->assertSee('Nama Guru')
            ->assertSee('Mata Pelajaran dan Jam Pelajaran');
    }

    public function test_teacher_can_be_updated_and_subject_assignments_are_replaced(): void
    {
        $math = Subject::factory()->create(['name' => 'Matematika']);
        $science = Subject::factory()->create(['name' => 'IPA']);
        $teacher = Teacher::factory()->create(['niy' => '19901234']);
        $teacher->subjects()->attach($math, ['lesson_hours' => 3]);

        $response = $this->put(route('admin.teacher.update', $teacher), [
            'name' => 'Budi Santoso Updated',
            'niy' => '19901234',
            'subjects' => [
                ['subject_id' => $science->id, 'lesson_hours' => 5],
            ],
        ]);

        $response->assertRedirect(route('admin.teacher.index'));
        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'name' => 'Budi Santoso Updated',
            'niy' => '19901234',
        ]);
        $this->assertDatabaseMissing('subject_teacher', [
            'teacher_id' => $teacher->id,
            'subject_id' => $math->id,
        ]);
        $this->assertDatabaseHas('subject_teacher', [
            'teacher_id' => $teacher->id,
            'subject_id' => $science->id,
            'lesson_hours' => 5,
        ]);
    }

    public function test_teacher_index_displays_each_subject_and_its_lesson_hours(): void
    {
        $subject = Subject::factory()->create(['name' => 'Matematika']);
        $teacher = Teacher::factory()->create([
            'name' => 'Budi Santoso',
            'niy' => '19901234',
        ]);
        $teacher->subjects()->attach($subject, ['lesson_hours' => 6]);

        $this->get(route('admin.teacher.index'))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee('19901234')
            ->assertSee('Matematika')
            ->assertSee('6 JP');
    }

    public function test_teacher_forms_display_subject_assignment_fields(): void
    {
        $subject = Subject::factory()->create(['name' => 'Matematika']);
        $teacher = Teacher::factory()->create();
        $teacher->subjects()->attach($subject, ['lesson_hours' => 6]);

        $this->get(route('admin.teacher.create'))
            ->assertOk()
            ->assertSee('NIY')
            ->assertSee('Matematika')
            ->assertSee('Tambah Mapel');

        $this->get(route('admin.teacher.edit', $teacher))
            ->assertOk()
            ->assertSee('NIY')
            ->assertSee('Matematika')
            ->assertSee('value="6"', false);
    }

    public function test_teacher_can_be_deleted(): void
    {
        $subject = Subject::factory()->create();
        $teacher = Teacher::factory()->create();
        $teacher->subjects()->attach($subject, ['lesson_hours' => 6]);

        $response = $this->delete(route('admin.teacher.destroy', $teacher));

        $response->assertRedirect(route('admin.teacher.index'));
        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
        $this->assertDatabaseMissing('subject_teacher', ['teacher_id' => $teacher->id]);
    }

    public function test_teacher_seeder_adds_at_least_ten_demo_teachers_and_eight_subjects_idempotently(): void
    {
        $this->seed(TeacherSeeder::class);

        $this->assertDatabaseCount('teachers', 10);
        $this->assertDatabaseCount('subjects', 8);
        $this->assertDatabaseCount('subject_teacher', 15);

        $this->seed(TeacherSeeder::class);

        $this->assertDatabaseCount('teachers', 10);
        $this->assertDatabaseCount('subjects', 8);
        $this->assertDatabaseCount('subject_teacher', 15);
    }

    public function test_teacher_seeder_converts_legacy_demo_niys_to_the_new_format(): void
    {
        $subject = Subject::factory()->create(['name' => 'Bahasa Indonesia']);
        $teacher = Teacher::factory()->create([
            'name' => 'Ahmad Fauzi',
            'niy' => 'DEMO-NIY-001',
        ]);
        $teacher->subjects()->attach($subject, ['lesson_hours' => 6]);

        $this->seed(TeacherSeeder::class);

        $this->assertDatabaseMissing('teachers', ['niy' => 'DEMO-NIY-001']);
        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'niy' => '19904821',
        ]);
    }
}
