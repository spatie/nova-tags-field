<?php

namespace Spatie\TagsField\Http\Middleware;

use Closure;
use Spatie\TagsField\Tags;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        //TODO: see if this is necessary

        return $next($request);

        return app(Tags::class)->authorize($request)
            ? $next($request)
            : abort(403);
    }
}
