@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey font-normal text-sm">
                <a class="text-green font-normal text-sm no-underline" href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
            </p>
            <div class="flex items-center">
                @forelse($project->members as $member)
                    <img src="{{ gravater_url($member->email) }}"
                         alt="{{ $member->name }}"
                         class="rounded-full w-8 mr-2">
                @empty
                    No members
                @endforelse
                    <img src="{{ gravater_url($project->owner->email) }}"
                         alt="{{ $project->owner->name }}"
                         class="rounded-full w-8 mr-2">
                    <a class="button ml-4" href="{{ $project->path() . '/edit' }}">Edit Project</a>
            </div>
        </div>
    </header>

    <main class="mb-6">
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-grey font-normal text-lg mb-3">Tasks</h2>
                    {{--Tasks--}}
                    @forelse ($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}" autocomplete="off">
                                @method('PATCH')
                                @csrf
                                <div class="flex justify-between items-center">
                                    <input class="w-full {{ $task->completed ? 'text-grey' : '' }}" type="text"
                                           name="body" value="{{ $task->body }}">
                                    <input type="checkbox" name="completed"
                                           onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @empty

                    @endforelse
                    <div class="card mb-3">
                        <form method="POST" action="{{ $project->path() . '/tasks' }}">
                            @csrf
                            <input name="body" class="w-full" type="text" placeholder="Add a new task...">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>
                    {{--General Notes--}}
                    <form method="POST" action="{{ $project->path() }}">
                        @method('PATCH')
                        @csrf
                        <textarea name="notes" class="card w-full mb-3" style="min-height: 200px"
                                  placeholder="Anything you want to make note of?">{{ $project->notes }}</textarea>
                        <button class="button" type="submit">Save</button>
                    </form>

                    @include('errors')
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
                @include('projects.activity.card')

                @can('manage', $project)
                    @include('projects.invite')
                @endcan
            </div>
        </div>
    </main>
@endsection