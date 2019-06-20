@if($errors->{ $bag ?? 'default' }->any())
    <ul class="mt-6 list-reset">
        @foreach($errors->{ $bag ?? 'default' }->all() as $error)
            <li class="text-red text-sm">{{ $error }}</li>
        @endforeach
    </ul>
@endif