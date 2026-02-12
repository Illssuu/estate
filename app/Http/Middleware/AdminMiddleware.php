<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем, авторизован ли пользователь
        if (!Auth::check()) {
            return redirect()->route('login.show')->with('error', 'Для доступа необходимо авторизоваться.');
        }

        // Проверяем, является ли пользователь администратором
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Доступ запрещен. Требуются права администратора.');
        }

        return $next($request);
    }
}
