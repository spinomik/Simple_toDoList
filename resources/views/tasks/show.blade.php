@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('tasks.index') }}"
                class="flex items-center text-blue-500 hover:text-blue-700 focus:outline-none">
                <i class="fas fa-chevron-circle-left"></i>
                <span>Powrót</span>
            </a>
        </div>

        <h1 class="text-3xl font-semibold mb-6">Task Details</h1>
        <div class="space-y-4">
            <h2 class="text-xl font-semibold">Task Name: <span class="font-normal text-gray-600">{{ $task->name }}</span>
            </h2>
            <p class="text-gray-700"><strong>Description:</strong> {{ $task->description }}</p>
            <p class="text-gray-700"><strong>Priority:</strong> {{ $task->taskPriority->name }}</p>
            <p class="text-gray-700"><strong>Status:</strong> {{ $task->taskStatus->name }}</p>
            <p class="text-gray-700"><strong>Completion Date:</strong> {{ $task->completion_date }}</p>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-4">Public Tokens</h3>
            @if (auth()->user()->hasPrivileges([App\Enums\PrivilegeEnum::PUBLIC_TOKEN_GENERATE->value]))
                <form action="{{ route('publicTokens.generate', $task->id) }}" method="POST" class="mb-4">
                    @csrf
                    <button type="submit"
                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Click to generate <i class="fas fa-plus"></i>
                    </button>
                </form>
            @endif
            @if ($publicTokens->isEmpty())
                <p class="text-gray-600">No public tokens</p>
            @else
                <table class="min-w-full table-auto mt-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Token</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Expiration Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publicTokens as $token)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $token->public_token }}</td>
                                <td class="px-4 py-2">{{ $token->token_expiry }}</td>
                                <td class="px-4 py-2">
                                    @if ($token->token_expiry > now())
                                        <span class="text-green-500">Active</span>
                                    @else
                                        <span class="text-red-500">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 flex items-center space-x-2">
                                    @if ($token->token_expiry > now())
                                        <button
                                            class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 focus:outline-none"
                                            data-token="{{ url('/public/tasks/' . $token->public_token) }}">
                                            <i class="far fa-copy"></i>
                                        </button>
                                        <form action="{{ route('publicTokens.deactivate', $token->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="redirect" value="task">
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 focus:outline-none">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="mt-6">
            @if ($taskLogs->isEmpty())
                <p>No changes have been made to this task yet.</p>
            @else
                <h3 class="text-xl font-semibold mb-4">History of Edits</h3>
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">User Assigned</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Description</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Priority</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Completion Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Changed By</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Edit time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($taskLogs as $log)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $log->user->name }}</td>
                                <td class="px-4 py-2">{{ $log->name }}</td>
                                <td class="px-4 py-2">{{ $log->description }}</td>
                                <td class="px-4 py-2">{{ $log->taskPriority->name }}</td>
                                <td class="px-4 py-2">{{ $log->taskStatus->name }}</td>
                                <td class="px-4 py-2">{{ $log->completion_date }}</td>
                                <td class="px-4 py-2">{{ $log->changedBy->name }}</td>
                                <td class="px-4 py-2">{{ $log->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <script>
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                const tokenUrl = this.dataset.token;
                navigator.clipboard.writeText(tokenUrl)
                    .then(() => alert('Link skopiowany do schowka!'))
                    .catch(err => alert('Nie udało się skopiować: ' + err));
            });
        });
    </script>
@endsection
