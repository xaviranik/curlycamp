<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
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
    public function only_the_owner_of_the_project_may_update_a_task()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'Changed Task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed Task']);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Test Task']);
        $this->get($project->path())
            ->assertSee('Test Task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'Changed Task'
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed Task'
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'Changed Task',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed Task',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'Changed Task',
                'completed' => true
            ]);

        $this->patch($project->tasks->first()->path(), [
                'body' => 'Changed Task',
                'completed' => false
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed Task',
            'completed' => false
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = ProjectFactory::create();
        $attributes = factory('App\Task')->make(['body' => null]);
        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes->toArray())
            ->assertSessionHasErrors('body');
    }
}
