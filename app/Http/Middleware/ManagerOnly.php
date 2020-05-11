<?php

namespace App\Http\Middleware;

use App\Models\Application\Application;
use App\Models\Application\Submit;
use Closure;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array(\Auth::user()->role, ['admin', 'manager'])) {
            return response("У вас не достаточно прав для просмотра данной страницы", 200);
        }

        return $next($request);
    }
}
