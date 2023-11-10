<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() != null) {
            $currentUserId = auth()->user()->id;
            $user = User::find($currentUserId);

            if (!auth()->check() || $user->hasAnyRole(Role::all())) {
                return $next($request);
            } else {
                toastr()->error('', 'Bạn không có quyền hạn!!!');
                return redirect()->route('index');
            }
        } else {
            toastr()->error('', 'Bạn không có quyền hạn!!!');
            return redirect()->route('index');
        }
    }
}
