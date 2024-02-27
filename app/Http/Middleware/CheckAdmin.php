<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $check = Auth::user()->role ?? '';
        if ($check == 'admin') {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
