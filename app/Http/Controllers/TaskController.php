<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskLog;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\PublicToken;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $query = Task::query();
        if (Auth::user()->isAdmin) {
            $users = $request->input('user_id', []);
            if (!empty($users[0])) {
                $query->whereIn('user_id', $request->user_id);
            }
        } else {
            $query->where('user_id', Auth::id());
        }

        $filters = [
            'name' => '%' . $request->input('name', '') . '%',
            'priority' => $request->input('priority', []),
            'status' => $request->input('status', []),
            'completionDate.from' => $request->input('completionDate.from', ''),
            'completionDate.to' => $request->input('completionDate.to', ''),
        ];

        if ($request->filled('name')) {
            $query->where('name', 'like', $filters['name']);
        }

        if (!empty($filters['priority'][0])) {
            $query->whereIn('task_priorities_id', $filters['priority']);
        }

        if (!empty($filters['status'][0])) {
            $query->whereIn('task_statuses_id', $filters['status']);
        }

        if ($filters['completionDate.from']) {
            $query->where('completion_date', '>=', $filters['completionDate.from']);
        }

        if ($filters['completionDate.to']) {
            $query->where('completion_date', '<=', $filters['completionDate.to']);
        }

        $sortColumn = $request->input('sort', 'name');
        $sortOrder = $request->input('order', 'asc');

        if ($sortColumn === 'created_at') {
            $query->orderByRaw('created_at ' . $sortOrder);
        } elseif ($request->filled('sort') && $request->filled('order')) {
            $query->orderBy($sortColumn, $sortOrder);
        } else {
            $query->orderByRaw('created_at ' . 'desc');
        }

        $taskList = $query->paginate(10);

        return view('tasks.index', [
            'taskList' => $taskList,
            'priorities' => TaskPriority::all(),
            'statuses' => TaskStatus::all(),
            'users' => User::all(),
        ]);
    }

    public function create(): View
    {
        $priorities = TaskPriority::all();
        $statuses = TaskStatus::all()->reverse();
        $users = Auth::user()->isAdmin ? User::all() : [];
        return view('tasks.create', compact('priorities', 'statuses', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_priorities_id' => 'required|uuid|exists:task_priorities,id',
            'task_statuses_id' => 'required|uuid|exists:task_statuses,id',
            'completion_date' => 'required|date',
            'user_id' => 'required|uuid|exists:users,id',
        ]);
        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $users = Auth::user()->isAdmin ? User::all() : [];
        $priorities = TaskPriority::all();
        $statuses = TaskStatus::all();
        return view('tasks.edit', compact('task', 'priorities', 'statuses', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_priorities_id' => 'required|uuid|exists:task_priorities,id',
            'task_statuses_id' => 'required|uuid|exists:task_statuses,id',
            'completion_date' => 'required|date',
            'user_id' => 'required|uuid|exists:users,id',
        ]);
        $taskLog = new TaskLog([
            'task_id' => $task->id,
            'changed_by' => Auth::id(),
            'user_id' => $task->user_id,
            'task_priorities_id' => $task->task_priorities_id,
            'task_statuses_id' => $task->task_statuses_id,
            'name' => $task->name,
            'description' => $task->description,
            'completion_date' => $task->completion_date,
        ]);
        $taskLog->save();
        $task->notification_sent = false;
        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function show(Task $task)
    {
        $taskLogs = $task->taskLogs()->orderBy('created_at', 'desc')->get();
        $publicTokens = PublicToken::where('task_id', $task->id)->get()->reverse();
        if ($taskLogs->isEmpty()) {
            $taskLogs = collect();
        }
        if ($publicTokens->isEmpty()) {
            $publicTokens = collect();
        }
        return view('tasks.show', compact('task', 'taskLogs', 'publicTokens'));
    }

    public function showPublic($token)
    {
        $publicToken = PublicToken::where('public_token', $token)->first();

        if (!$publicToken) {
            abort(404, 'Token not found.');
        }

        if ($publicToken->token_expiry < now()) {
            abort(403, 'Token expired.');
        }
        $task = $publicToken->task;

        return view('tasks.show-public', compact('task'));
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
