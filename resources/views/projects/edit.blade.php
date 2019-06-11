@extends('layouts.app')
@section('content')
    <div class="lg:flex justify-center">
        <div class="card my-10 lg:px-20 lg:w-2/3">
            <h1 class="mt-6 mb-12 text-black font-normal text-center">Edit Project</h1>
            <form method="POST" action="{{ $project->path()}}">
                @method('PATCH')
                @include('projects.form', [
                    'buttonText' => 'Update Project'
                ])
            </form>
        </div>
    </div>
@endsection