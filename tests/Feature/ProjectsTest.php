<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_may_not_create_a_project()
    {
        $attributes = factory('App\Project')->make(['owner_id' => null]);

        $this->post('/projects', $attributes->toArray())
            ->assertRedirect('login');
    }

    /** @test */
    public function guests_may_not_view_projects()
    {
        $this->get('/projects')
            ->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->post('/projects', $attributes)
            ->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')
            ->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $this->get('/projects/' . $project->id)
            ->assertSee($project->title);
    }

    /** @test */
    public function an_authenticated_user_can_not_view_projects_of_others()
    {
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create();
        $this->get('/projects/' . $project->id)
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->make(['title' => null]);
        $this->post('/projects', $attributes->toArray())
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->make(['description' => null]);
        $this->post('/projects', $attributes->toArray())
            ->assertSessionHasErrors('description');
    }
}
