<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_may_not_manage_project()
    {
        $project = factory('App\Project')->make();

        $this->get('/projects')->assertRedirect('login');

        $this->post('/projects', $project->toArray())->assertRedirect('login');

        $this->get('/projects/create')->assertRedirect('login');

        $this->get('/projects/edit')->assertRedirect('login');

        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')
            ->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes'
        ];
        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }
    
    /** @test */
    public function a_user_can_see_all_projects_they_have_been_invited_to_their_dashboard()
    {
        $user = $this->signIn();

        $project = tap(ProjectFactory::create())->invite($user);

        $this->get('/projects')->assertSee($project->title);
    }

    /** @test */
    public function unauthorized_user_can_not_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $attributes =  [
            'title' => 'Changed Title',
            'description' => 'Changed Description',
            'notes' => 'Changed Notes'
        ];

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

        $attributes =  [
            'notes' => 'Changed Notes'
        ];

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes);

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title);
    }

    /** @test */
    public function an_authenticated_user_can_not_view_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();
        $this->get($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_not_update_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();
        $this->patch($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory('App\Project')->make(['title' => null]);
        $this->post('/projects', $attributes->toArray())
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory('App\Project')->make(['description' => null]);
        $this->post('/projects', $attributes->toArray())
            ->assertSessionHasErrors('description');
    }
}
