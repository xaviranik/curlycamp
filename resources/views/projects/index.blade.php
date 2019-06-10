@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-grey font-normal text-sm">My Projects</h2>
            <a class="button" href="{{ route('projects.create') }}">New Project</a>
        </div>
    </header>

    <div class="block lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">

            </div>
        @empty
            <h4>No Projects yet!</h4>
        @endforelse
    </div>
@endsection