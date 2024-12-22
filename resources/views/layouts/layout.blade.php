<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Simple ToDoList') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

</head>

<body class="bg-cover bg-center flex flex-col min-h-screen"
    style="background-image: url('{{ Vite::asset('resources/images/background.jpg') }}');">

    <!-- Komunikaty błędów/sukcesów -->
    <div>
        @if (session('error'))
            <div class="alert alert-error" role="alert">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <span class="font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
    </div>

    <nav class="fixed top-0 w-full z-50 bg-white bg-opacity-50 backdrop-blur-md shadow-lg py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="text-xl font-bold text-gray-900">
                    <a href="{{ route('home') }}" class="hover:text-gray-600">ToDoList</a>
                </div>

                <ul class="flex space-x-8">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-gray-900 hover:text-gray-700 py-2 px-4 rounded-lg
                                {{ request()->routeIs('home') ? 'bg-blue-500 text-white' : '' }}">
                            Home
                        </a>
                    </li>

                    @auth
                        @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::TASK_READ->value]))
                            <li>
                                <a href="{{ route('tasks.index') }}"
                                    class="text-gray-900 hover:text-gray-700 py-2 px-4 rounded-lg
                                    {{ request()->routeIs('tasks.index') ? 'bg-blue-500 text-white' : '' }}">
                                    Tasks
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::USER_READ->value]))
                            <li>
                                <a href="{{ route('users.index') }}"
                                    class="text-gray-900 hover:text-gray-700 py-2 px-4 rounded-lg
                                        {{ request()->routeIs('users.index') ? 'bg-blue-500 text-white' : '' }}">
                                    Users
                                </a>
                            </li>
                        @endif
                    @endauth

                    @guest
                        <li>
                            <a href="{{ route('login') }}"
                                class="text-gray-900 hover:text-gray-700 py-2 px-4 rounded-lg
                                    {{ request()->routeIs('login') ? 'bg-blue-500 text-white' : '' }}">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}"
                                class="text-gray-900 hover:text-gray-700 py-2 px-4 rounded-lg
                                    {{ request()->routeIs('register') ? 'bg-blue-500 text-white' : '' }}">
                                Register
                            </a>
                        </li>
                    @endguest
                </ul>

                @auth
                    <div class="flex items-center space-x-4">
                        <span>{{ Auth::user()->email }}</span>
                        <div class="relative">
                            <button id="settingsButton" data-dropdown-toggle="settingsDropdown"
                                class="text-gray-900 py-2 px-4 rounded-lg">
                                Settings
                            </button>

                            <!-- Dropdown -->
                            <div id="settingsDropdown" class="hidden z-10 w-48 bg-white rounded shadow-lg dark:bg-gray-700">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="settingsButton">
                                    <li>
                                        <a href="{{ route('profile.edit') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Settings
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-left block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                {{ __('Log Out') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Zawartość strony z marginesem -->
    <div class="flex-grow mt-16">
        <div class=" mx-auto my-8 px-4 sm:px-6 lg:px-8 ">
            <main class="bg-white bg-opacity-80 backdrop-blur-md p-6 rounded-xl shadow-lg">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white bg-opacity-60 py-4 text-center mt-auto">
        <p>Copyright 2024 By KapMik</p>
    </footer>

    <!-- Scripts -->
    <script>
        window.onload = function() {
            const toastContainer = document.querySelector('.toast-container');
            if (toastContainer) {
                setTimeout(function() {
                    toastContainer.style.display = 'none';
                }, 10000);
            }
        };

        function closeToast() {
            document.querySelector('.toast-container').style.display = 'none';
        }
    </script>

    {{-- <script src="{{ asset('vendor/flowbite/flowbite.min.js') }}"></script>
     --}}

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>
