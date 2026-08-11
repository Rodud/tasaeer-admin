<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if ($request->is('admin') || $request->is('admin/*') || $request->is('login')) {
            App::setLocale(session('admin_locale', 'ar'));
        } else {
            App::setLocale(session('locale', 'ar'));
        }
    
        return $next($request);
    }
}