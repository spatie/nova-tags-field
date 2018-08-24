<?php

namespace :namespace_vendor\:namespace_tool_name\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use :namespace_vendor\:namespace_tool_name\Tool;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        return app(Tool::class)->authorize($request)
            ? $next($request)
            : abort(403);
    }
}