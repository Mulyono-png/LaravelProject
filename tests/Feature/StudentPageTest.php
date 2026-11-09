<?php

namespace Tests\Feature;

use Database\Seeders\StudentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_page_displays_seeded_students(): void
    {
        $this->withoutVite();

        $this->seed(StudentSeeder::class);

        $this->get('/admin/student')
            ->assertOk()
            ->assertSee('Ahmad Fauzan')
            ->assertSee('Muhammad Rizky')
            ->assertSee('Gita Gutawa')
            ->assertSee('Teacher')
            ->assertSee('Subject')
            ->assertSee('Active');

        $this->assertDatabaseCount('students', 10);
    }
}
