<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeleteUrlCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($_COOKIE['url'])) {
            setcookie('url', '', time() - 3600, '/');
            unset($_COOKIE['url']);
        }
        return $next($request);
    }
}
