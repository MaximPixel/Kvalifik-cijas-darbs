<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\App;

class SetLocale {

    public function handle(Request $request, Closure $next): Response {
        App::setLocale(session("locale") ?? "lv");
        return $next($request);
    }
}
