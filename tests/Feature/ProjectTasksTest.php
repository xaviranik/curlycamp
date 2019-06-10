<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_add_tasks_to_a_project()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')
            ->assertRedirect('/login');
    }

    /** @test */
    public function only_the_owner_of_the_project_may_add_tasks_to_the_project()
    {
        $this->signIn();
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test Task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test Task']);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $this->post($project->path() . '/tasks', ['body' => 'Test Task']);
        $this->get($project->path())
            ->assertSee('Test Task');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());
        $attributes = factory('App\Task')->make(['body' => null]);
        $this->post($project->path() . '/tasks', $attributes->toArray())
            ->assertSessionHasErrors('body');
    }
}
