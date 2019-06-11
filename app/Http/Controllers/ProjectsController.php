<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        //Validate the request
        $attributes = $this->validateRequest($request);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return void
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     * @return Response
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        //Validate the request
        $attributes = $this->validateRequest($request);

        $project->update($attributes);

        return redirect($project->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return Response
     */
    public function destroy(Project $project)
    {
        //
    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function validateRequest(Request $request): array
    {
        $attributes = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);
        return $attributes;
    }
}
