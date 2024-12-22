@extends('layouts.layout')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-md shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Reset Password</h1>
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                    autofocus autocomplete="username"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if ($errors->has('email'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if ($errors->has('password'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if ($errors->has('password_confirmation'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
@endsection
