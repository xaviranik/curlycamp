@extends('layouts.app')
@section('content')
    <div class="lg:flex justify-center">
        <div class="card my-10 lg:px-20 lg:w-2/3">
            <h1 class="mt-6 mb-12 text-black font-normal text-center">Let's Start Something New</h1>
            <form method="POST" action="/projects">
                @include('projects.form', [
                'project' => new App\Project,
                'buttonText' => 'Create Project'
                ])
            </form>
        </div>
    </div>
@endsection