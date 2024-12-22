@extends('layouts.layout')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-md shadow-lg">
        <div class="mb-6 text-sm text-gray-600 text-center">
            Forgot your password? No problem. Just let us know your email address, and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @if ($errors->has('email'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </div>
@endsection
