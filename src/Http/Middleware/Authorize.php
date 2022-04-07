<?php

namespace Spatie\TagsField\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\TagsField\Tags;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
