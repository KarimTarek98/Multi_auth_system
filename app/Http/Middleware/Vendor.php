<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Vendor
{

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('vendor')->check())
        {
            return redirect()->route('vendor.login_form')
                ->with('error', 'You should login first');
        }
        return $next($request);
    }
}
