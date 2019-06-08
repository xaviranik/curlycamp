@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="display-4">All Projects</h1>
        <ul>
            @forelse($projects as $project)
                <li>
                    <a href="{{ $project->path() }}">{{ $project->title }}</a>
                </li>
            @empty
                <h1 class="display-4">Nothing here!</h1>
            @endforelse
        </ul>
    </div>
@endsection