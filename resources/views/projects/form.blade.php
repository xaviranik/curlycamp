<div class="container">
    @csrf
    <div class="mb-4">
        <label class="block text-black text-sm font-normal mb-2 " for="title">Title</label>
        <input type="text" name="title" id="title"
               class="shadow border rounded w-full py-2 px-3 mb-4 text-black"
               placeholder="Give a suitable title for your project"
               value="{{ $project->title }}" required>
    </div>
    <div class="mb-4">
        <label class="block text-black text-sm font-normal mb-2" for="description">Description</label>
        <textarea
                class="shadow border rounded w-full py-2 px-3 mb-4 text-black leading-tight"
                name="description" placeholder="Say something about your project"
                id="description" rows="10" required>{{ $project->description }}</textarea>
    </div>
    <button class="button mb-8" type="submit">{{ $buttonText }}</button>
    <a class="ml-4 button bg-blue" href="{{ $project->path() }}">Cancel</a>

    @if ($errors->any())
        <div class="mt-6">
            @foreach($errors->all() as $error)
                <p class="text-red text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif
</div>