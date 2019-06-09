@extends('layouts.app')
@section('content')
    <div class="flex items-center mb-3">
        <a href="{{ route('projects.create') }}">New Project</a>
    </div>

    <div class="flex">
        @forelse($projects as $project)
            <div class="bg-white rounded shadow p-5 mr-4 w-1/3" style="height: 200px">
                <h3 class="font-normal text-xl py-4">{{ $project->title }}</h3>
                <div class="text-grey">{{ str_limit($project->description, 100) }}</div>
            </div>
        @empty
            <h4>No Projects yet!</h4>
        @endforelse
    </div>
@endsection