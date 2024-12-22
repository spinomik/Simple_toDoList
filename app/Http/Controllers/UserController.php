<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $privileges = Privilege::all();
        return view('users.index', ['users' => $users, 'privileges' => $privileges]);
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('users.edit', $user)->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function blockUser(Request $request, User $user)
    {
        $user->blocked = $request->has('blocked');
        $user->save();

        return back()->with('success', 'User status updated successfully.');
    }

    public function togglePrivilege(Request $request, User $user)
    {
        $validated = $request->validate([
            'privilege_id' => 'required|uuid|exists:privileges,id',
            'action' => 'required|in:add,remove',
        ]);

        $privilegeId = $validated['privilege_id'];
        if ($validated['action'] === 'add') {
            $user->privileges()->syncWithoutDetaching($privilegeId);
        } else {
            $user->privileges()->detach($privilegeId);
        }

        return response()->json(['success' => true]);
    }
}
