<?php


namespace Tests\Setup;


use App\Project;
use App\Task;
use App\User;

class ProjectFactory
{
    protected $taskCount = 0;
    protected $user;

    public function withTasks($count)
    {
        $this->taskCount = $count;
        return $this;
    }

    public function OwnedBy($user)
    {
        $this->user = $user;
        return $this;
    }

    public function create()
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?? factory(User::class)
        ]);

        factory(Task::class, $this->taskCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}