<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_user_may_not_invite()
    {
        $project = ProjectFactory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post($project->path() . '/invitation')
            ->assertStatus(403);
    }
    
    /** @test */
    public function a_project_owner_can_invite_an_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitation', [
                'email' => $userToInvite->email
            ])->assertRedirect($project->path());
        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function the_invitation_email_address_must_be_associated_with_valid_curlycamp_account()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->post($project->path() . '/invitation', [
            'email' => 'notauser@example.com'
        ])->assertSessionHasErrors(['email' => 'The user you are inviting must have a CurlyCamp account']);
    }

    /** @test */
    public function invited_user_may_update_project_detail()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->signIn($newUser);

        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'fooTask']);
        $this->assertDatabaseHas('tasks', $task);
    }
}
