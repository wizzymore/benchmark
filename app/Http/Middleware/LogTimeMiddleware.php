<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LogTimeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        App::terminating(function () use ($request, $response) {
            $time = microtime(true) - LARAVEL_START;
            $path = $request->path();
            Log::insert([
                'path' => $path,
                'time' => $time * 1000, // Request time in miliseconds
            ]);
        });

        return $response;
    }
}
