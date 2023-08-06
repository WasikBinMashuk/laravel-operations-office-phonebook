<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNameRedirect
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's name contains "admin"
            if (stripos($user->name, 'Admin') !== false) {
                return redirect()->route('destroy'); // redirects to the destroy session route
            }
        }

        return $next($request);
    }
}
