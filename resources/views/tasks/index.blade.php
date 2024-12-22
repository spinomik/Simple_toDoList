@extends('layouts.layout')

@section('content')
    <div class="container mx-auto p-4">
        <form method="GET" action="{{ route('tasks.index') }}" class="space-y-6 mt-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <!-- Filters Wrapper -->
                <div class="flex flex-wrap space-x-4 space-y-4 lg:space-y-0">
                    <!-- Assigned User -->
                    @if (auth()->user()->isAdmin)
                        <div class="flex flex-col w-1/4 sm:w-auto">
                            <label for="user-filter" class="text-xs font-medium text-gray-700 mb-2">
                                <i class="fas fa-user"></i> Assigned User
                            </label>
                            <select name="user_id[]" id="user-filter" multiple
                                class="block w-full px-3 py-1 text-xs rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, request('user_id', [])) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Task Name -->
                    <div class="flex flex-col w-1/4 sm:w-auto">
                        <label for="name-filter" class="text-xs font-medium text-gray-700 mb-2">
                            <i class="fas fa-filter"></i> Task Name
                        </label>
                        <input type="text" name="name" id="name-filter" value="{{ request('name') }}"
                            placeholder="Enter task name"
                            class="block w-full px-3 py-1 text-xs rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <!-- Priority -->
                    <div class="flex flex-col w-1/4 sm:w-auto">
                        <label for="priority-filter" class="text-xs font-medium text-gray-700 mb-2">
                            <i class="fas fa-filter"></i> Priority
                        </label>
                        <select name="priority[]" id="priority-filter" multiple
                            class="block w-full px-3 py-1 text-xs rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All</option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}"
                                    {{ in_array($priority->id, request('priority', [])) ? 'selected' : '' }}>
                                    {{ $priority->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="flex flex-col w-1/4 sm:w-auto">
                        <label for="status-filter" class="text-xs font-medium text-gray-700 mb-2">
                            <i class="fas fa-filter"></i> Status
                        </label>
                        <select name="status[]" id="status-filter" multiple
                            class="block w-full px-3 py-1 text-xs rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ in_array($status->id, request('status', [])) ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="flex flex-col w-1/4 sm:w-auto">
                        <label for="completion-date-from" class="text-xs font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar"></i> Date From
                        </label>
                        <input type="date" name="completionDate[from]" id="completion-date-from"
                            value="{{ request('completionDate.from') }}"
                            class="block w-full px-3 py-1 text-xs rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <!-- Date To -->
                    <div class="flex flex-col w-1/4 sm:w-auto">
                        <label for="completion-date-to" class="text-xs font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar"></i> Date To
                        </label>
                        <input type="date" name="completionDate[to]" id="completion-date-to"
                            value="{{ request('completionDate.to') }}"
                            class="block w-full px-3 py-1 text-xs rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-4">
                    <!-- Apply Filters Button -->
                    <button type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Apply Filters
                    </button>
                    @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::TASK_READ->value]))
                        <a href="{{ route('tasks.create') }}"
                            class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500">
                            Add Task
                        </a>
                    @endif

                </div>
            </div>
        </form>

        <!-- Tasks Table -->
        <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase group cursor-pointer 
                            {{ request('sort') === 'created_at' ? 'bg-gray-100' : '' }} hover:bg-gray-200">
                            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['sort' => 'created_at', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center w-full">
                                Lp
                                @if (request('sort') === 'created_at')
                                    <i class="fas fa-chevron-{{ request('order') === 'asc' ? 'up' : 'down' }} ml-2"></i>
                                @endif
                            </a>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase group cursor-pointer 
                            {{ request('sort') === 'name' ? 'bg-gray-100' : '' }} hover:bg-gray-200">
                            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['sort' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center w-full">
                                Name
                                @if (request('sort') === 'name')
                                    <i class="fas fa-chevron-{{ request('order') === 'asc' ? 'up' : 'down' }} ml-2"></i>
                                @endif
                            </a>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase group cursor-pointer 
                            {{ request('sort') === 'description' ? 'bg-gray-100' : '' }} hover:bg-gray-200">
                            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['sort' => 'description', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center w-full">
                                Description
                                @if (request('sort') === 'description')
                                    <i class="fas fa-chevron-{{ request('order') === 'asc' ? 'up' : 'down' }} ml-2"></i>
                                @endif
                            </a>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase group cursor-pointer 
                            {{ request('sort') === 'task_priorities_id' ? 'bg-gray-100' : '' }} hover:bg-gray-200">
                            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['sort' => 'task_priorities_id', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center w-full">
                                Priority
                                @if (request('sort') === 'task_priorities_id')
                                    <i class="fas fa-chevron-{{ request('order') === 'asc' ? 'up' : 'down' }} ml-2"></i>
                                @endif
                            </a>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase group cursor-pointer 
                            {{ request('sort') === 'task_statuses_id' ? 'bg-gray-100' : '' }} hover:bg-gray-200">
                            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['sort' => 'task_statuses_id', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center w-full">
                                Status
                                @if (request('sort') === 'task_statuses_id')
                                    <i class="fas fa-chevron-{{ request('order') === 'asc' ? 'up' : 'down' }} ml-2"></i>
                                @endif
                            </a>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase group cursor-pointer 
                            {{ request('sort') === 'completion_date' ? 'bg-gray-100' : '' }} hover:bg-gray-200">
                            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['sort' => 'completion_date', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center w-full">
                                Completion Date
                                @if (request('sort') === 'completion_date')
                                    <i class="fas fa-chevron-{{ request('order') === 'asc' ? 'up' : 'down' }} ml-2"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taskList as $index => $task)
                        <tr class="border-t">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <!-- Numer porządkowy -->
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $task->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $task->description }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $task->taskPriority->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $task->taskStatus->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $task->completion_date }}</td>
                            <td class="px-6 py-4">
                                @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::TASK_READ->value]))
                                    <a href="{{ route('tasks.show', ['task' => $task]) }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-info fa-lg"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::TASK_EDIT->value]))
                                    <a href="{{ route('tasks.edit', ['task' => $task]) }}"
                                        class="text-yellow-600 hover:text-yellow-800 ml-2">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::TASK_DELETE->value]))
                                    <form action="{{ route('tasks.delete', ['task' => $task]) }}" method="POST"
                                        class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800"
                                            onclick="return confirm('Are you sure?');">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $taskList->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
@endsection
