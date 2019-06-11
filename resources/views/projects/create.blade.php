@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="flex justify-center">
            <div class="card mt-10 px-10 w-1/2">
                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf
                    <h1 class="mt-4 mb-12 text-black font-bold text-center">Let's Start Something New</h1>
                    <div class="mb-4">
                        <label class="block text-black text-sm font-bold mb-2 " for="title">Title</label>
                        <input type="text" name="title" id="title"
                               class="shadow appearance-none border rounded w-full py-2 px-3 mb-4 text-black leading-tight"
                               placeholder="Give a suitable title for your project">
                    </div>
                    <div class="mb-4">
                        <label class="block text-black text-sm font-bold mb-2" for="description">Description</label>
                        <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 mb-4 text-black leading-tight"
                                name="description" placeholder="Say something about your project" id="description" rows="10"></textarea>
                    </div>
                    <button class="button mb-4" type="submit">Create Project</button>
                </form>
            </div>
        </div>
    </div>
@endsection