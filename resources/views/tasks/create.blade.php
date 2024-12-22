@extends('layouts.layout')

@section('content')
    <div class="container mx-auto p-6 max-w-4xl bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Add New Task</h1>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            @if (auth()->user()->isAdmin)
                <div class="form-group">
                    <label for="user_id">Wybierz użytkownika</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $user->id == old('user_id', auth()->id()) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <!-- Ukryte pole dla zwykłego użytkownika -->
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
            @endif

            <!-- Task Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Task Name</label>
                <input type="text" name="name" id="name"
                    class="block w-full p-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required placeholder="Enter the task name">
            </div>

            <!-- Task Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description"
                    class="block w-full p-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter the task description"></textarea>
            </div>

            <!-- Priority -->
            <div class="mb-4">
                <label for="task_priorities_id" class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                <select name="task_priorities_id" id="task_priorities_id"
                    class="block w-full p-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="task_statuses_id" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="task_statuses_id" id="task_statuses_id"
                    class="block w-full p-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Completion Date -->
            <div class="mb-6">
                <label for="completion_date" class="block text-sm font-medium text-gray-700 mb-2">Completion
                    Date</label>
                <input type="datetime-local" name="completion_date" id="completion_date"
                    class="block w-full p-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Create Task
                </button>
            </div>
        </form>
    </div>
@endsection
