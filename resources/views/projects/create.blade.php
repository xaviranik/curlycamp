@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf
            <h1 class="display-4">Create A New Project</h1>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
            </div>
            <button class="button" type="submit">Create Project</button>
        </form>
    </div>
@endsection