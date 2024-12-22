<?php

namespace App\Http\Controllers;

use App\Models\PublicToken;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PublicTokenController extends Controller
{
    public function generateToken(Task $task)
    {
        PublicToken::create([
            'task_id' => $task->id,
            'public_token' => Str::uuid(),
            'token_expiry' => now()->addMinutes(config('app.token_expiry', 60)),
            'generated_by' => Auth::id(),
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Token publiczny został wygenerowany.');
    }

    public function deactivateToken(PublicToken $token, Request $request)
    {
        $token->update([
            'token_expiry' => now()->subSecond(),
        ]);

        if ($request->has('redirect') && $request->redirect === 'profile') {
            return redirect()->route('profile.edit')
                ->with('success', 'Token publiczny został dezaktywowany.');
        }
        return redirect()->route('tasks.show', $token->task_id)
            ->with('success', 'Token publiczny został dezaktywowany.');
    }

    public function deleteToken(PublicToken $token, Request $request)
    {
        $token->delete();

        $redirect = $request->input('redirect', 'profile');
        return redirect()->route($redirect === 'profile' ? 'profile.show' : 'tasks.show', $token->task_id)
            ->with('success', 'Token został usunięty.');
    }
}
