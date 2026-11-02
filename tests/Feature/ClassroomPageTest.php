<?php

namespace Tests\Feature;

use App\Models\Classroom;
use Database\Seeders\ClassroomSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassroomPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_classroom_page_displays_classrooms(): void
    {
        $this->withoutVite();
        Classroom::factory()->create([
            'name' => '11 DKV 1',
            'major' => 'DKV',
        ]);

        $this->seed(ClassroomSeeder::class);

        $this->get('/admin/classroom')
            ->assertOk()
            ->assertSee('XI PPLG 1')
            ->assertSee('XI PPLG 2')
            ->assertSee('X PPLG 1')
            ->assertSee('X PPLG 2')
            ->assertDontSee('DKV')
            ->assertDontSee('ANIMASI')
            ->assertSee('PPLG');

        $this->assertDatabaseCount('classrooms', 4);
    }
}
