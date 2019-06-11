@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex justify-center">
            <div class="block w-1/2">
                <div class="card mt-10 px-10">
                    <h1 class="mt-4 mb-8 text-black font-bold text-center">Login</h1>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-black text-sm font-bold mb-2">Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 mb-4 text-black leading-tight"
                                   id="name" type="text" name="name" value="{{ old('name') }}" required
                                   autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-black text-sm font-bold mb-2">E-Mail Address</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 mb-4 text-black leading-tight"
                                   id="email" type="email" name="email" value="{{ old('email') }}" required
                                   autocomplete="email" autofocus>
                            @error('email')
                            <p class="text-red text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-black text-sm font-bold mb-2">Password</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 mb-4 text-black leading-tight"
                                   id="password" type="password" name="password" required>
                            @error('password')
                            <p class="text-red text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="confirm-password" class="block text-black text-sm font-bold mb-2">Confirm
                                Password</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 mb-4 text-black leading-tight"
                                   id="confirm-password" type="password" name="password_confirmation" required>
                            @error('password_confirmation')
                            <p class="text-red text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <button type="submit" class="button mb-4">
                                Signup
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
