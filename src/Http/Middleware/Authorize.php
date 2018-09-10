<?php

namespace Christophrumpel\NovaNotifications\Http\Middleware;

use Christophrumpel\NovaNotifications\NovaNotifications;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaNotifications::class)->authorize($request) ? $next($request) : abort(403);
    }
}
