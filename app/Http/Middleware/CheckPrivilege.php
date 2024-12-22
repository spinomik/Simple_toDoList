<?php

namespace App\Http\Middleware;

use App\Enums\PrivilegeEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $privilege): Response
    {
        $user = Auth::user();

        if (!$user) {

            return redirect()->route('home')->with('error', 'You need to be logged in to perform this action.');
        }
        if ($user->isAdmin)

            return $next($request);

        $hasPermission = $user->privileges->contains('id', $privilege);

        if (!$hasPermission) {

            return redirect()->route('home')->with('error', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
