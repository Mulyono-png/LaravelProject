<?php

namespace Tests\Feature;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_subject_can_be_created(): void
    {
        $response = $this->post(route('admin.subject.store'), [
            'name' => 'Matematika',
        ]);

        $response->assertRedirect(route('admin.subject.index'));
        $this->assertDatabaseHas('subjects', ['name' => 'Matematika']);
    }

    public function test_subject_creation_rejects_missing_and_duplicate_names(): void
    {
        Subject::factory()->create(['name' => 'Matematika']);

        $this->post(route('admin.subject.store'), [])
            ->assertSessionHasErrors(['name']);

        $this->post(route('admin.subject.store'), ['name' => 'Matematika'])
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('subjects', 1);
    }

    public function test_subject_can_be_renamed_without_breaking_teacher_assignments(): void
    {
        $subject = Subject::factory()->create(['name' => 'Matematika']);
        $teacher = Teacher::factory()->create();
        $teacher->subjects()->attach($subject, ['lesson_hours' => 5]);

        $response = $this->put(route('admin.subject.update', $subject), [
            'name' => 'Matematika Lanjutan',
        ]);

        $response->assertRedirect(route('admin.subject.index'));
        $this->assertDatabaseHas('subjects', [
            'id' => $subject->id,
            'name' => 'Matematika Lanjutan',
        ]);
        $this->assertDatabaseHas('subject_teacher', [
            'teacher_id' => $teacher->id,
            'subject_id' => $subject->id,
            'lesson_hours' => 5,
        ]);
    }

    public function test_deleting_subject_removes_assignments_but_keeps_teacher(): void
    {
        $subject = Subject::factory()->create();
        $teacher = Teacher::factory()->create();
        $teacher->subjects()->attach($subject, ['lesson_hours' => 5]);

        $response = $this->delete(route('admin.subject.destroy', $subject));

        $response->assertRedirect(route('admin.subject.index'));
        $this->assertDatabaseMissing('subjects', ['id' => $subject->id]);
        $this->assertDatabaseMissing('subject_teacher', [
            'teacher_id' => $teacher->id,
            'subject_id' => $subject->id,
        ]);
        $this->assertDatabaseHas('teachers', ['id' => $teacher->id]);
    }

    public function test_subject_index_displays_saved_subjects(): void
    {
        Subject::factory()->create(['name' => 'Matematika']);

        $this->get(route('admin.subject.index'))
            ->assertOk()
            ->assertSee('Matematika');
    }
}
