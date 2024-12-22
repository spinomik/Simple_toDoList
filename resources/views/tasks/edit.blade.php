@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-lg">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                @if (auth()->user()->isAdmin)
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Assigned User</label>
                    <select name="user_id" id="user_id"
                        class="block w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $task->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
                @endif
            </div>

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700">Task Name</label>
                <input type="text" name="name" id="name" value="{{ $task->name }}" required
                    class="block w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" required
                    class="block w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $task->description }}</textarea>
            </div>

            <div class="mb-6">
                <label for="task_priorities_id" class="block text-sm font-medium text-gray-700">Priority</label>
                <select name="task_priorities_id" id="task_priorities_id"
                    class="block w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->id }}"
                            {{ $task->task_priorities_id == $priority->id ? 'selected' : '' }}>
                            {{ $priority->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="task_statuses_id" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="task_statuses_id" id="task_statuses_id"
                    class="block w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}"
                            {{ $task->task_statuses_id == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="completion_date" class="block text-sm font-medium text-gray-700">Completion Date</label>
                <input type="datetime-local" name="completion_date" id="completion_date"
                    value="{{ \Carbon\Carbon::parse($task->completionDate)->format('Y-m-d\TH:i') }}"
                    class="block w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full mt-4 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Update Task
            </button>
        </form>
    </div>
@endsection
