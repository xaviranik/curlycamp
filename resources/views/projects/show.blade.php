@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey font-normal text-sm">
                <a class="text-green font-normal text-sm no-underline" href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
            </p>
            <a class="button" href="{{ route('projects.create') }}">New Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-grey font-normal text-lg mb-3">Tasks</h2>
                    {{--Tasks--}}
                    <div class="card mb-3">Lorem ipsum</div>
                    <div class="card mb-3">Lorem ipsum</div>
                    <div class="card mb-3">Lorem ipsum</div>
                    <div class="card">Lorem ipsum</div>
                </div>

                <div>
                    <h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>
                    {{--General Notes--}}
                    <textarea class="card w-full" style="min-height: 200px">Lorem ipsum</textarea>
                </div>

            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>
@endsection