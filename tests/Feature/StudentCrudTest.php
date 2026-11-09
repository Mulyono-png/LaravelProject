<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_be_created_with_valid_data(): void
    {
        $response = $this->post(route('admin.student.store'), [
            'nis' => 20270001,
            'name' => 'Siswa Baru',
            'kelas' => 'X PPLG 1',
            'status' => 'Active',
        ]);

        $response->assertRedirect(route('admin.student.index'));
        $this->assertDatabaseHas('students', [
            'nis' => 20270001,
            'name' => 'Siswa Baru',
            'kelas' => 'X PPLG 1',
            'status' => 'Active',
        ]);
    }

    public function test_student_creation_rejects_missing_fields(): void
    {
        $response = $this->post(route('admin.student.store'), []);

        $response->assertSessionHasErrors(['nis', 'name', 'kelas', 'status']);
        $this->assertDatabaseCount('students', 0);
    }

    public function test_create_and_edit_forms_do_not_render_an_address_field(): void
    {
        $student = Student::factory()->create();

        $this->get(route('admin.student.create'))
            ->assertOk()
            ->assertDontSee('Alamat')
            ->assertDontSee('name="adress"', false);

        $this->get(route('admin.student.edit', $student))
            ->assertOk()
            ->assertDontSee('Alamat')
            ->assertDontSee('name="adress"', false);
    }

    public function test_student_creation_rejects_a_duplicate_nis(): void
    {
        Student::factory()->create(['nis' => 20270001]);

        $response = $this->post(route('admin.student.store'), [
            'nis' => 20270001,
            'name' => 'Siswa Duplikat',
            'kelas' => 'X PPLG 1',
            'status' => 'Active',
        ]);

        $response->assertSessionHasErrors(['nis']);
        $this->assertDatabaseCount('students', 1);
    }

    public function test_student_can_be_updated_without_changing_its_nis(): void
    {
        $student = Student::factory()->create([
            'nis' => 20270001,
            'name' => 'Nama Lama',
        ]);

        $response = $this->put(route('admin.student.update', $student), [
            'nis' => 20270001,
            'name' => 'Nama Baru',
            'kelas' => 'XI PPLG 2',
            'status' => 'Inactive',
        ]);

        $response->assertRedirect(route('admin.student.index'));
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'nis' => 20270001,
            'name' => 'Nama Baru',
            'kelas' => 'XI PPLG 2',
            'status' => 'Inactive',
        ]);
    }

    public function test_student_can_be_deleted(): void
    {
        $student = Student::factory()->create();

        $response = $this->delete(route('admin.student.destroy', $student));

        $response->assertRedirect(route('admin.student.index'));
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_student_list_searches_by_name_nis_and_class(): void
    {
        Student::factory()->create([
            'nis' => 20270001,
            'name' => 'Ayu Cendana',
            'kelas' => 'X PPLG 1',
        ]);
        Student::factory()->create([
            'nis' => 20270002,
            'name' => 'Budi Santoso',
            'kelas' => 'XI PPLG 2',
        ]);

        $this->get(route('admin.student.index', ['search' => 'Ayu']))
            ->assertOk()
            ->assertSee('Ayu Cendana')
            ->assertDontSee('Budi Santoso');

        $this->get(route('admin.student.index', ['search' => '20270002']))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertDontSee('Ayu Cendana');

        $this->get(route('admin.student.index', ['search' => 'XI PPLG 2']))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertDontSee('Ayu Cendana');
    }

    public function test_student_list_escapes_user_provided_names(): void
    {
        Student::factory()->create([
            'name' => '<script>alert(1)</script>',
        ]);

        $this->get(route('admin.student.index'))
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }
}
