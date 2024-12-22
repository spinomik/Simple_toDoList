@extends('layouts.layout')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-md shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Log In</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if ($errors->has('email'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if ($errors->has('password'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mt-4">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <label for="remember_me" class="ms-2 text-sm text-gray-600">Remember me</label>
            </div>

            <!-- Links and Log In Button -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Forgot your password?
                    </a>
                @endif
                <div class="flex items-center space-x-4">
                    <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:text-indigo-800 underline">
                        Register
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Log in
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
